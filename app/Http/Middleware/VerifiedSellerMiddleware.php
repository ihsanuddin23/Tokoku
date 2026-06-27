<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedSellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isSeller()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $profile = $user->sellerProfile;

        if (! $profile || ! $profile->is_verified) {
            return redirect('/')
                ->with('info', 'Toko Anda masih dalam proses verifikasi admin.');
        }

        if (! $profile->is_active) {
            return redirect('/')
                ->with('info', 'Toko Anda saat ini dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}
