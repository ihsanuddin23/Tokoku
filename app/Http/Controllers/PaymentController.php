<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function show(Request $request, Order $order): View|RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if (! $order->canBePaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pesanan ini tidak dapat dibayar.');
        }

        $payment = $order->payment;

        if (! $payment || ! $payment->snap_token) {
            $payment = $this->createSnapToken($order);
        }

        if (! $payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Gagal memuat pembayaran. Silakan coba lagi.');
        }

        return view('payment.show', compact('order', 'payment'));
    }

    public function finish(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $status = $request->query('transaction_status');

        if (in_array($status, ['settlement', 'capture'])) {
            return redirect()->route('payment.success', $order)
                ->with('status', 'payment-success');
        }

        if (in_array($status, ['pending', null])) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pembayaran sedang diproses. Kami akan memperbarui status pesanan Anda.');
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Pembayaran gagal atau dibatalkan.');
    }

    public function success(Request $request, Order $order): View|RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items.product', 'address', 'payment');

        return view('payment.success', compact('order'));
    }

    public function webhook(Request $request): JsonResponse
    {
        try {
            $orderId = $request->order_id;
            $statusCode = $request->status_code;
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;
            $transactionId = $request->transaction_id;
            $paymentType = $request->payment_type;

            if (! $orderId || ! $transactionStatus) {
                return response()->json(['status' => 'error', 'message' => 'Invalid payload'], 400);
            }

            $signatureKey = hash('sha512',
                $orderId .
                $statusCode .
                $transactionStatus .
                $fraudStatus .
                config('midtrans.server_key')
            );

            if ($signatureKey !== $request->signature_key) {
                Log::warning('Midtrans webhook signature mismatch', [
                    'order_id' => $orderId,
                ]);

                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
            }

            $payment = Payment::where('midtrans_order_id', $orderId)->firstOrFail();

            if ($payment->transaction_status !== 'pending') {
                return response()->json(['status' => 'ok', 'message' => 'Already processed']);
            }

            $order = $payment->order;

            DB::transaction(function () use ($request, $payment, $order, $transactionStatus, $fraudStatus, $transactionId, $paymentType) {
                $payment->forceFill([
                    'midtrans_transaction_id' => $transactionId,
                    'transaction_status' => $transactionStatus,
                    'fraud_status' => $fraudStatus,
                    'payment_type' => $paymentType,
                    'payment_channel' => $request->bank ?? $request->issuer ?? null,
                    'raw_response' => $request->all(),
                ])->save();

                if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                    $payment->forceFill(['paid_at' => now()])->save();

                    $order->forceFill([
                        'status' => 'paid',
                        'payment_status' => 'paid',
                        'payment_method' => $paymentType,
                        'paid_at' => now(),
                    ])->save();

                    $order->items()->where('status', 'pending')->update(['status' => 'paid']);

                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $order->forceFill([
                        'payment_status' => 'failed',
                    ])->save();
                }
            });

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage(), [
                'payload' => $request->all(),
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function createSnapToken(Order $order): ?Payment
    {
        try {
            $midtransOrderId = 'TOKOKU-' . $order->order_number . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => (int) $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '-',
                ],
                'item_details' => $order->items->map(function ($item) {
                    return [
                        'id' => (string) $item->product_id,
                        'price' => (int) $item->product_price,
                        'quantity' => $item->quantity,
                        'name' => substr($item->product_name, 0, 50),
                    ];
                })->toArray(),
                'callbacks' => [
                    'finish' => route('payment.finish', $order),
                ],
            ];

            if ($order->shipping_cost > 0) {
                $params['item_details'][] = [
                    'id' => 'shipping',
                    'price' => (int) $order->shipping_cost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim',
                ];
            }

            $snapToken = Snap::getSnapToken($params);

            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'midtrans_order_id' => $midtransOrderId,
                'snap_token' => $snapToken,
                'gross_amount' => $order->grand_total,
                'transaction_status' => 'pending',
            ])->save();

            return $payment;

        } catch (\Exception $e) {
            Log::error('Midtrans createSnapToken error: ' . $e->getMessage());
            return null;
        }
    }
}
