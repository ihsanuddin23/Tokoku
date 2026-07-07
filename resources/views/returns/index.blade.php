<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Pengembalian</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Pengajuan Pengembalian</h1>
            <p class="text-sm text-dark-500">Riwayat pengajuan return & refund Anda</p>
        </div>

        @if (session('status') === 'return-submitted')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pengajuan pengembalian berhasil dikirim. Tim kami akan meninjau dalam 1-2 hari kerja.
            </div>
        @endif

        @if ($returns->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1m12 0a2 2 0 01-2 2H6a2 2 0 01-2-2m12 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v6m12 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 15H4" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Pengajuan</h2>
                <p class="text-sm text-dark-400 max-w-md mx-auto">Anda belum pernah mengajukan pengembalian apapun.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($returns as $return)
                    <div class="card p-5">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-dark-50">
                            <div>
                                <p class="text-sm font-mono font-medium text-dark-900">{{ $return->order->order_number }}</p>
                                <p class="text-xs text-dark-400">{{ $return->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="badge {{ $return->status_badge }} text-[10px]">{{ $return->status_label }}</span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-dark-400">Alasan</p>
                                <p class="text-sm font-medium text-dark-700">{{ $return->reason }}</p>
                            </div>
                            @if ($return->description)
                                <div>
                                    <p class="text-xs text-dark-400">Deskripsi</p>
                                    <p class="text-sm text-dark-600">{{ $return->description }}</p>
                                </div>
                            @endif
                            @if ($return->admin_note)
                                <div>
                                    <p class="text-xs text-dark-400">Catatan Admin</p>
                                    <p class="text-sm text-dark-600">{{ $return->admin_note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($returns->hasPages())
                <div class="flex justify-center mt-6">
                    {{ $returns->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
