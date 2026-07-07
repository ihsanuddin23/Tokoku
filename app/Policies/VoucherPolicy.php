<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voucher;

class VoucherPolicy
{
    public function update(User $user, Voucher $voucher): bool
    {
        $sellerProfile = $user->sellerProfile;

        return $sellerProfile
            && $voucher->seller_profile_id === $sellerProfile->id;
    }

    public function delete(User $user, Voucher $voucher): bool
    {
        $sellerProfile = $user->sellerProfile;

        return $sellerProfile
            && $voucher->seller_profile_id === $sellerProfile->id;
    }
}
