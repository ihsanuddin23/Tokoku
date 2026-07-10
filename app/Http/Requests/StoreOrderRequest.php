<?php

namespace App\Http\Requests;

use App\Services\ShippingService;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $couriers = array_keys(app(ShippingService::class)->getCosts());

        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'notes' => ['nullable', 'string', 'max:500'],
            'shipping_courier' => ['required', 'in:' . implode(',', $couriers)],
            'payment_method' => ['required', 'in:midtrans,cod'],
        ];
    }
}
