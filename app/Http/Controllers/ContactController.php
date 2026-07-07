<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contactEmail = Setting::get('contact_email', 'support@tokoku.id');
        $contactPhone = Setting::get('contact_phone', '+62 21 1234 5678');
        $contactAddress = Setting::get('contact_address', 'Jakarta, Indonesia');

        return view('contact.index', compact('contactEmail', 'contactPhone', 'contactAddress'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $contactEmail = Setting::get('contact_email', 'support@tokoku.id');

        Mail::raw(
            "Pesan dari: {$validated['name']} ({$validated['email']})\n\n"
            . "Subjek: {$validated['subject']}\n\n"
            . "Pesan:\n{$validated['message']}",
            function ($mail) use ($contactEmail, $validated) {
                $mail->to($contactEmail)
                    ->subject('[Kontak TokoKu] ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            }
        );

        return back()->with('status', 'contact-sent');
    }

    public function about(): View
    {
        $stats = [
            'products' => \App\Models\Product::where('status', 'active')->count(),
            'sellers' => \App\Models\SellerProfile::where('is_active', true)->count(),
            'users' => \App\Models\User::count(),
        ];

        return view('about.index', compact('stats'));
    }
}
