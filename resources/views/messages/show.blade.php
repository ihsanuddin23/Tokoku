<x-app-layout>
    @section('meta_title', 'Pesan — ' . config('app.name'))

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-4">
            <a href="{{ route('messages.index') }}" class="text-sm text-dark-500 hover:text-primary-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Kembali
            </a>
        </div>

        <div class="card overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-dark-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-primary-600">{{ strtoupper(substr($conversation->sellerProfile->store_name, 0, 2)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-dark-900">{{ $conversation->sellerProfile->store_name }}</p>
                    @if ($conversation->product)
                        <p class="text-xs text-dark-400 truncate">{{ $conversation->product->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Messages -->
            <div class="px-6 py-6 space-y-4 max-h-[500px] overflow-y-auto" id="chat-messages">
                @foreach ($conversation->messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%] {{ $message->sender_id === auth()->id() ? 'bg-primary-500 text-white' : 'bg-dark-100 text-dark-700' }} rounded-2xl px-4 py-2.5">
                            <p class="text-sm leading-relaxed">{{ $message->body }}</p>
                            <p class="text-[10px] {{ $message->sender_id === auth()->id() ? 'text-primary-100' : 'text-dark-400' }} mt-1">{{ $message->created_at->format('H:i, d M') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Reply Form -->
            <div class="px-6 py-4 border-t border-dark-100">
                <form method="POST" action="{{ route('messages.store', $conversation) }}">
                    @csrf
                    <div class="flex items-center gap-3">
                        <input type="text" name="body" placeholder="Tulis pesan..." class="flex-1 bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400" required maxlength="1000">
                        <button type="submit" class="btn-primary py-2.5 px-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
    </script>
</x-app-layout>
