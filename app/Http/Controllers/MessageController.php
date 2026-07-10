<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\SellerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $conversations = Conversation::where(function ($q) use ($user) {
            $q->where('buyer_id', $user->id)
                ->orWhereHas('sellerProfile', fn ($sq) => $sq->where('user_id', $user->id));
        })
            ->with(['buyer', 'sellerProfile', 'product', 'latestMessage'])
            ->latest('last_message_at')
            ->paginate(20);

        return view('messages.index', compact('conversations'));
    }

    public function show(Request $request, Conversation $conversation): View
    {
        $user = $request->user();

        if ($conversation->buyer_id !== $user->id && $conversation->sellerProfile->user_id !== $user->id) {
            abort(403);
        }

        $conversation->load(['buyer', 'sellerProfile', 'product', 'messages.sender']);

        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('conversation', 'user'));
    }

    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = $request->user();

        if ($conversation->buyer_id !== $user->id && $conversation->sellerProfile->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->update(['last_message_at' => $message->created_at]);

        return back();
    }

    public function start(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seller_profile_id' => ['required', 'exists:seller_profiles,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        $sellerProfile = SellerProfile::findOrFail($validated['seller_profile_id']);

        if ($sellerProfile->user_id === $user->id) {
            return back()->with('info', 'Tidak bisa chat dengan toko sendiri.');
        }

        $conversation = Conversation::firstOrCreate(
            [
                'buyer_id' => $user->id,
                'seller_profile_id' => $validated['seller_profile_id'],
                'product_id' => $validated['product_id'] ?? null,
            ],
            ['last_message_at' => now()]
        );

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->update(['last_message_at' => $message->created_at]);

        return redirect()->route('messages.show', $conversation);
    }
}
