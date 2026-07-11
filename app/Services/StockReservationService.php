<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class StockReservationService
{
    public const RESERVATION_MINUTES = 15;

    /**
     * Release all active reservations for a user (restore stock).
     */
    public function releaseForUser(int $userId): void
    {
        $reservations = StockReservation::where('user_id', $userId)->get();

        if ($reservations->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($reservations) {
            $productIds = $reservations->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $variantIds = $reservations->pluck('product_variant_id')->filter()->unique();
            $variants = ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');

            foreach ($reservations as $reservation) {
                if ($reservation->product_variant_id && isset($variants[$reservation->product_variant_id])) {
                    $variants[$reservation->product_variant_id]->increment('stock', $reservation->quantity);
                } elseif (isset($products[$reservation->product_id])) {
                    $products[$reservation->product_id]->increment('stock', $reservation->quantity);
                }
            }

            StockReservation::where('user_id', $reservations->first()->user_id)->delete();
        });
    }

    /**
     * Reserve stock for a collection of cart items.
     * Releases any existing reservations first, then creates new ones.
     *
     * @param  Collection  $cartItems  Cart items with loaded product & variant
     * @return array{reservations: Collection, expires_at: \Illuminate\Support\Carbon}
     */
    public function reserveForCheckout(int $userId, Collection $cartItems): array
    {
        $this->releaseForUser($userId);

        $expiresAt = now()->addMinutes(self::RESERVATION_MINUTES);

        $reservations = DB::transaction(function () use ($userId, $cartItems, $expiresAt) {
            $productIds = $cartItems->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $variantIds = $cartItems->pluck('product_variant_id')->filter()->unique();
            $variants = ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');

            $created = collect();

            foreach ($cartItems as $item) {
                $product = $products[$item->product_id] ?? null;
                if (! $product) {
                    continue;
                }

                $variant = $item->product_variant_id ? ($variants[$item->product_variant_id] ?? null) : null;

                if ($variant) {
                    if ($variant->stock < $item->quantity) {
                        throw new \App\Exceptions\InsufficientStockException(
                            "Stok variasi {$variant->name} dari {$product->name} tidak mencukupi (tersisa {$variant->stock})."
                        );
                    }
                    $variant->decrement('stock', $item->quantity);
                } else {
                    if ($product->stock < $item->quantity) {
                        throw new \App\Exceptions\InsufficientStockException(
                            "Stok {$product->name} tidak mencukupi (tersisa {$product->stock})."
                        );
                    }
                    $product->decrement('stock', $item->quantity);
                }

                $created->push(StockReservation::create([
                    'user_id' => $userId,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'expires_at' => $expiresAt,
                ]));
            }

            return $created;
        });

        return ['reservations' => $reservations, 'expires_at' => $expiresAt];
    }

    /**
     * Consume reservations for a user (called when order is placed).
     * Stock is already decremented, so just delete the reservation records.
     */
    public function consumeForUser(int $userId): void
    {
        StockReservation::where('user_id', $userId)->delete();
    }

    /**
     * Release expired reservations (called by scheduled command).
     */
    public function releaseExpired(): int
    {
        $expired = StockReservation::expired()->get();

        if ($expired->isEmpty()) {
            return 0;
        }

        $count = 0;

        $expired->groupBy('product_id')->each(function ($group) use (&$count) {
            DB::transaction(function () use ($group, &$count) {
                $productIds = $group->pluck('product_id')->unique();
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

                $variantIds = $group->pluck('product_variant_id')->filter()->unique();
                $variants = ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');

                foreach ($group as $reservation) {
                    if ($reservation->product_variant_id && isset($variants[$reservation->product_variant_id])) {
                        $variants[$reservation->product_variant_id]->increment('stock', $reservation->quantity);
                    } elseif (isset($products[$reservation->product_id])) {
                        $products[$reservation->product_id]->increment('stock', $reservation->quantity);
                    }
                    $reservation->delete();
                    $count++;
                }
            });
        });

        return $count;
    }
}
