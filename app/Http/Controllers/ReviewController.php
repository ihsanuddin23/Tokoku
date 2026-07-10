<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('view', $order);

        if ($order->status !== 'completed') {
            return back()->with('info', 'Ulasan hanya bisa diberikan setelah pesanan selesai.');
        }

        $validated = $request->validated();

        foreach ($validated['reviews'] as $reviewData) {
            $alreadyReviewed = ProductReview::where('user_id', $request->user()->id)
                ->where('product_id', $reviewData['product_id'])
                ->where('order_id', $order->id)
                ->exists();

            if ($alreadyReviewed) {
                continue;
            }

            $orderHasProduct = $order->items()
                ->where('product_id', $reviewData['product_id'])
                ->exists();

            if (! $orderHasProduct) {
                continue;
            }

            ProductReview::create([
                'user_id' => $request->user()->id,
                'product_id' => $reviewData['product_id'],
                'order_id' => $order->id,
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'] ?? null,
            ]);

            $this->recalculateProductRating($reviewData['product_id']);
        }

        return redirect()->route('orders.show', $order)
            ->with('status', 'review-submitted');
    }

    private function recalculateProductRating(int $productId): void
    {
        $avg = ProductReview::where('product_id', $productId)->avg('rating');
        $count = ProductReview::where('product_id', $productId)->count();

        \App\Models\Product::where('id', $productId)->update([
            'rating' => round($avg, 1),
            'review_count' => $count,
        ]);
    }

    public function respond(Request $request, ProductReview $review): RedirectResponse
    {
        $this->authorize('respond', $review);

        $validated = $request->validate([
            'seller_response' => ['required', 'string', 'max:500'],
        ]);

        $review->forceFill([
            'seller_response'      => $validated['seller_response'],
            'seller_responded_at'  => now(),
        ])->save();

        return back()->with('status', 'review-responded');
    }
}
