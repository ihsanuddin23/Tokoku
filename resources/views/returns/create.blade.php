<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('orders.show', $order) }}" class="hover:text-primary-600 transition-colors">Pesanan</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Ajukan Pengembalian</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Ajukan Pengembalian</h1>
            <p class="text-sm text-dark-500">Pesanan {{ $order->order_number }}</p>
        </div>

        <form action="{{ route('returns.store', $order) }}" method="POST">
            @csrf

            <div class="card p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-2">Alasan Pengembalian <span class="text-red-500">*</span></label>
                    <select name="reason" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                        <option value="">Pilih alasan...</option>
                        <option value="Produk rusak">Produk rusak</option>
                        <option value="Produk tidak sesuai deskripsi">Produk tidak sesuai deskripsi</option>
                        <option value="Produk salah/varian salah">Produk salah/varian salah</option>
                        <option value="Paket tidak diterima">Paket tidak diterima</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('reason')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-2">Deskripsi Detail</label>
                    <textarea name="description" rows="4" placeholder="Jelaskan masalah produk secara detail..." class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all resize-none"></textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if ($order->items->count() > 1)
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-2">Produk yang Dikembalikan (opsional)</label>
                        <select name="order_item_id" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                            <option value="">Semua produk dalam pesanan</option>
                            @foreach ($order->items as $item)
                                <option value="{{ $item->id }}">{{ $item->product_name }} ({{ $item->quantity }}x)</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Catatan</p>
                            <p class="text-xs text-yellow-700 mt-1">Pengajuan akan ditinjau oleh admin dalam 1-2 hari kerja. Pastikan produk dalam kondisi sesuai saat dikembalikan.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('orders.show', $order) }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Ajukan Pengembalian</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
