<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 text-sm text-dark-500 hover:text-primary-600 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Profil
            </a>
        </div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Alamat Pengiriman</h1>
                <p class="text-sm text-dark-500">Kelola alamat pengiriman Anda untuk checkout lebih cepat.</p>
            </div>
            <button x-data="{ open: false }" @click="open = true; $nextTick(() => $dispatch('open-modal'))"
                class="btn-primary text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Alamat
            </button>
        </div>

        @if (session('status'))
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                @if (session('status') === 'address-created') Alamat berhasil ditambahkan.
                @elseif (session('status') === 'address-updated') Alamat berhasil diperbarui.
                @elseif (session('status') === 'address-deleted') Alamat berhasil dihapus.
                @elseif (session('status') === 'address-default-set') Alamat utama berhasil diatur.
                @endif
            </div>
        @endif

        @if ($addresses->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-dark-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <p class="text-dark-500 font-medium mb-1">Belum ada alamat tersimpan</p>
                <p class="text-sm text-dark-400">Tambahkan alamat untuk mempermudah proses checkout</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($addresses as $address)
                    <div class="card p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm font-semibold text-dark-900">{{ $address->label }}</span>
                                    @if ($address->is_default)
                                        <span class="badge-primary">Utama</span>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-dark-700">{{ $address->recipient_name }}</p>
                                <p class="text-sm text-dark-500">{{ $address->phone }}</p>
                                <p class="text-sm text-dark-500 mt-1">{{ $address->full_address }}</p>
                                <p class="text-sm text-dark-500">{{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                            </div>
                            <div class="flex flex-col gap-2 shrink-0">
                                @if (! $address->is_default)
                                    <form method="POST" action="{{ route('profile.addresses.set-default', $address) }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-primary-600 hover:text-primary-700 font-medium hover:underline transition-colors">Jadikan Utama</button>
                                    </form>
                                @endif
                                <button x-data="{ open: false }" @click="$dispatch('edit-address-{{ $address->id }}')"
                                    class="text-xs text-dark-500 hover:text-dark-700 font-medium hover:underline transition-colors text-left">Edit</button>
                                <form method="POST" action="{{ route('profile.addresses.destroy', $address) }}" onsubmit="return confirm('Hapus alamat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium hover:underline transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div x-data="{ open: false }" @edit-address-{{ $address->id }}.window="open = true" x-show="open" x-transition style="display: none;">
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div @click="open = false" class="absolute inset-0 bg-dark-900/60 backdrop-blur-sm"></div>
                            <div class="relative bg-white rounded-2xl shadow-card-hover w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 animate-scale-in">
                                <h3 class="text-lg font-semibold font-display text-dark-900 mb-4">Edit Alamat</h3>
                                <form method="POST" action="{{ route('profile.addresses.update', $address) }}">
                                    @csrf
                                    @method('PATCH')
                                    @include('profile.partials.address-form-fields', ['oldValues' => $address])
                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="open = false" class="btn-secondary text-sm">Batal</button>
                                        <button type="submit" class="btn-primary text-sm">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Add Modal -->
        <div x-data="{ open: false }" @open-modal.window="open = true" x-show="open" x-transition style="display: none;">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div @click="open = false" class="absolute inset-0 bg-dark-900/60 backdrop-blur-sm"></div>
                <div class="relative bg-white rounded-2xl shadow-card-hover w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 animate-scale-in">
                    <h3 class="text-lg font-semibold font-display text-dark-900 mb-4">Tambah Alamat Baru</h3>
                    <form method="POST" action="{{ route('profile.addresses.store') }}">
                        @csrf
                        @include('profile.partials.address-form-fields', ['oldValues' => null])
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="open = false" class="btn-secondary text-sm">Batal</button>
                            <button type="submit" class="btn-primary text-sm">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
