<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderSeller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $this->authorize('payment', $order);

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
        $this->authorize('payment', $order);

        $status = $request->query('transaction_status');

        // If client reports settlement/capture, verify with Midtrans to prevent fake payment
        if (in_array($status, ['settlement', 'capture'])) {
            if ($order->status === 'pending') {
                $verified = $this->verifyTransactionWithMidtrans($order);

                if ($verified) {
                    $this->markOrderAsPaid($order, $request);
                    return redirect()->route('payment.success', $order)
                        ->with('status', 'payment-success');
                }

                return redirect()->route('orders.show', $order)
                    ->with('error', 'Verifikasi pembayaran gagal. Silakan hubungi dukungan jika dana telah dibayar.');
            }

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

    private function verifyTransactionWithMidtrans(Order $order): bool
    {
        $payment = $order->payment;

        if (! $payment || ! $payment->midtrans_order_id) {
            return false;
        }

        try {
            $transactionStatus = \Midtrans\Transaction::status($payment->midtrans_order_id);
            $realStatus = $transactionStatus->transaction_status ?? null;
            $fraudStatus = $transactionStatus->fraud_status ?? null;

            if (in_array($realStatus, ['settlement', 'capture']) && $fraudStatus !== 'deny') {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Midtrans verifyTransaction error: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);

            return false;
        }
    }

    private function markOrderAsPaid(Order $order, Request $request): void
    {
        $payment = $order->payment;
        $paymentType = $request->query('payment_type') ?? ($payment?->payment_type ?? 'midtrans');
        $transactionId = $request->query('transaction_id') ?? ($payment?->midtrans_transaction_id);

        DB::transaction(function () use ($order, $payment, $request, $paymentType, $transactionId) {
            if ($payment) {
                $payment->fill([
                    'midtrans_transaction_id' => $transactionId,
                    'transaction_status' => $request->query('transaction_status') ?? 'settlement',
                    'payment_type' => $paymentType,
                    'paid_at' => now(),
                ])->save();
            }

            $order->forceFill([
                'status' => 'paid',
                'payment_status' => 'paid',
                'payment_method' => $paymentType,
                'paid_at' => now(),
            ])->save();

            $order->items()->where('status', 'pending')->update(['status' => 'paid']);
        });

        // Send email notifications
        $order->load('items.sellerProfile.user', 'user');

        if ($order->user) {
            Mail::to($order->user->email)->queue(new OrderStatusUpdated($order, 'pending', 'paid'));
        }

        foreach ($order->items as $item) {
            if ($item->sellerProfile && $item->sellerProfile->user) {
                Mail::to($item->sellerProfile->user->email)->queue(new NewOrderSeller($item));
            }
        }
    }

    public function success(Request $request, Order $order): View|RedirectResponse
    {
        $this->authorize('payment', $order);

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

            return DB::transaction(function () use ($request, $orderId, $transactionStatus, $fraudStatus, $transactionId, $paymentType) {
                $payment = Payment::where('midtrans_order_id', $orderId)->lockForUpdate()->firstOrFail();

                if ($payment->transaction_status !== 'pending') {
                    return response()->json(['status' => 'ok', 'message' => 'Already processed']);
                }

                $order = $payment->order;

                $payment->fill([
                    'midtrans_transaction_id' => $transactionId,
                    'transaction_status' => $transactionStatus,
                    'fraud_status' => $fraudStatus,
                    'payment_type' => $paymentType,
                    'payment_channel' => $request->bank ?? $request->issuer ?? null,
                    'raw_response' => $request->all(),
                ])->save();

                if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                    $payment->fill(['paid_at' => now()])->save();

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

                if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                    $order->load('items.sellerProfile.user', 'user');
                    if ($order->user) {
                        Mail::to($order->user->email)->queue(new OrderStatusUpdated($order, 'pending', 'paid'));
                    }

                    foreach ($order->items as $item) {
                        if ($item->sellerProfile && $item->sellerProfile->user) {
                            Mail::to($item->sellerProfile->user->email)->queue(new NewOrderSeller($item));
                        }
                    }
                }

                return response()->json(['status' => 'ok']);
            });

        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage(), [
                'payload' => $request->all(),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
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

            $payment = Payment::create([
                'order_id' => $order->id,
                'midtrans_order_id' => $midtransOrderId,
                'snap_token' => $snapToken,
                'gross_amount' => $order->grand_total,
                'transaction_status' => 'pending',
            ]);

            return $payment;

        } catch (\Exception $e) {
            Log::error('Midtrans createSnapToken error: ' . $e->getMessage());
            return null;
        }
    }
}
