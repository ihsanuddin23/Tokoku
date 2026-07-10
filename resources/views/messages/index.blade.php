<x-app-layout>
    @section('meta_title', 'Pesan — ' . config('app.name'))

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold font-display text-dark-900 mb-6">Pesan</h1>

        @if ($conversations->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Pesan</h2>
                <p class="text-sm text-dark-400 max-w-md mx-auto">Mulai chat dengan seller dari halaman produk atau toko.</p>
            </div>
        @else
            <div class="card overflow-hidden divide-y divide-dark-50">
                @foreach ($conversations as $conversation)
                    <a href="{{ route('messages.show', $conversation) }}" class="flex items-center gap-4 p-4 hover:bg-dark-50/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                            <span class="text-sm font-bold text-primary-600">{{ strtoupper(substr($conversation->sellerProfile->store_name, 0, 2)) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-medium text-dark-900 truncate">{{ $conversation->sellerProfile->store_name }}</p>
                                @if ($conversation->latestMessage)
                                    <span class="text-[10px] text-dark-400 shrink-0">{{ $conversation->latestMessage->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            @if ($conversation->product)
                                <p class="text-xs text-dark-400 truncate">{{ $conversation->product->name }}</p>
                            @endif
                            @if ($conversation->latestMessage)
                                <p class="text-xs text-dark-500 truncate mt-0.5">{{ $conversation->latestMessage->body }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($conversations->hasPages())
                <div class="flex justify-center mt-6">
                    {{ $conversations->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
