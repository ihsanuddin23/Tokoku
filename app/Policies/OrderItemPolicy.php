<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;

class OrderItemPolicy
{
    public function updateStatus(User $user, OrderItem $orderItem): bool
    {
        $sellerProfile = $user->sellerProfile;

        return $sellerProfile
            && $orderItem->seller_profile_id === $sellerProfile->id;
    }
}
