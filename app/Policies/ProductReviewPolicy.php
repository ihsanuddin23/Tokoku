<?php

namespace App\Policies;

use App\Models\ProductReview;
use App\Models\User;

class ProductReviewPolicy
{
    public function respond(User $user, ProductReview $review): bool
    {
        $sellerProfile = $user->sellerProfile;

        return $sellerProfile
            && $review->product
            && $review->product->seller_profile_id === $sellerProfile->id;
    }
}
