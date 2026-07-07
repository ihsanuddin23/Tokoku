<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVoucherController extends Controller
{
    public function index(Request $request): View
    {
        $vouchers = Voucher::with('sellerProfile')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('code', 'like', "%{$request->search}%")
                        ->orWhere('name', 'like', "%{$request->search}%");
                });
            })
            ->when($request->status, function ($q, $status) {
                match ($status) {
                    'active'   => $q->where('is_active', true)->where('starts_at', '<=', now())->where('expires_at', '>', now()),
                    'scheduled'=> $q->where('is_active', true)->where('starts_at', '>', now()),
                    'expired'  => $q->where('expires_at', '<', now()),
                    'inactive' => $q->where('is_active', false),
                    default    => null,
                };
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create(): View
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code'                => ['required', 'string', 'max:50', 'unique:vouchers,code'],
            'name'                => ['required', 'string', 'max:100'],
            'description'         => ['nullable', 'string', 'max:500'],
            'type'                => ['required', 'in:percentage,fixed,free_shipping'],
            'value'               => ['required', 'numeric', 'min:0'],
            'min_purchase'        => ['nullable', 'numeric', 'min:0'],
            'max_discount'        => ['nullable', 'numeric', 'min:0'],
            'usage_limit'         => ['nullable', 'integer', 'min:1'],
            'usage_limit_per_user'=> ['required', 'integer', 'min:1'],
            'starts_at'           => ['required', 'date'],
            'expires_at'          => ['required', 'date', 'after:starts_at'],
            'is_active'           => ['boolean'],
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['min_purchase'] = $validated['min_purchase'] ?? 0;

        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('status', 'voucher-created');
    }

    public function edit(Voucher $voucher): View
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher): RedirectResponse
    {
        $validated = $request->validate([
            'code'                => ['required', 'string', 'max:50', 'unique:vouchers,code,' . $voucher->id],
            'name'                => ['required', 'string', 'max:100'],
            'description'         => ['nullable', 'string', 'max:500'],
            'type'                => ['required', 'in:percentage,fixed,free_shipping'],
            'value'               => ['required', 'numeric', 'min:0'],
            'min_purchase'        => ['nullable', 'numeric', 'min:0'],
            'max_discount'        => ['nullable', 'numeric', 'min:0'],
            'usage_limit'         => ['nullable', 'integer', 'min:1'],
            'usage_limit_per_user'=> ['required', 'integer', 'min:1'],
            'starts_at'           => ['required', 'date'],
            'expires_at'          => ['required', 'date', 'after:starts_at'],
            'is_active'           => ['boolean'],
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['min_purchase'] = $validated['min_purchase'] ?? 0;

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('status', 'voucher-updated');
    }

    public function destroy(Voucher $voucher): RedirectResponse
    {
        $voucher->delete();

        return back()->with('status', 'voucher-deleted');
    }
}
