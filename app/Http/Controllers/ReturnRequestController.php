<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequest;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnRequestController extends Controller
{
    public function index(Request $request): View
    {
        $returns = $request->user()
            ->returnRequests()
            ->with('order', 'orderItem')
            ->latest()
            ->paginate(10);

        return view('returns.index', compact('returns'));
    }

    public function create(Request $request, Order $order): View|RedirectResponse
    {
        $this->authorize('view', $order);

        if (! in_array($order->status, ['completed', 'shipped'])) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pengembalian hanya dapat diajukan untuk pesanan yang sudah dikirim atau selesai.');
        }

        $existingReturn = ReturnRequest::where('order_id', $order->id)
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingReturn) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Anda sudah memiliki pengajuan pengembalian yang sedang diproses untuk pesanan ini.');
        }

        return view('returns.create', compact('order'));
    }

    public function store(StoreReturnRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('view', $order);

        if (! in_array($order->status, ['completed', 'shipped'])) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pengembalian hanya dapat diajukan untuk pesanan yang sudah dikirim atau selesai.');
        }

        $validated = $request->validated();

        if (! empty($validated['order_item_id'])) {
            $belongsToOrder = $order->items()->where('id', $validated['order_item_id'])->exists();
            if (! $belongsToOrder) {
                return back()->with('info', 'Item yang dipilih tidak termasuk dalam pesanan ini.');
            }
        }

        ReturnRequest::create([
            'order_id'      => $order->id,
            'user_id'       => $request->user()->id,
            'order_item_id' => $validated['order_item_id'] ?? null,
            'reason'        => $validated['reason'],
            'description'   => $validated['description'] ?? null,
            'status'        => 'pending',
        ]);

        return redirect()->route('returns.index')
            ->with('status', 'return-submitted');
    }
}
