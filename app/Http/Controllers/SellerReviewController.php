<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerReviewController extends Controller
{
    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $reviews = ProductReview::with('user', 'product', 'order')
            ->whereHas('product', fn ($q) => $q->where('seller_profile_id', $sellerProfile->id))
            ->when($request->rating, fn ($q) => $q->where('rating', $request->rating))
            ->when($request->filter === 'unresponded', fn ($q) => $q->whereNull('seller_response'))
            ->when($request->filter === 'responded', fn ($q) => $q->whereNotNull('seller_response'))
            ->latest()
            ->paginate(15);

        return view('seller.reviews.index', compact('reviews'));
    }
}
