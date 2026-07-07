<x-dashboard-layout>
    <x-slot name="sidebarTitle">Admin Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Manajemen User
        </a>
        <a href="{{ route('admin.verifications.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Verifikasi Seller
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            Kategori
        </a>
        <a href="{{ route('admin.banners.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Banner
        </a>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            Semua Pesanan
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold font-display text-dark-900">Manajemen Banner</h1>
                <p class="text-sm text-dark-500 mt-1">Kelola banner promo di halaman beranda</p>
            </div>
            <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Banner
            </button>
        </div>

        @if (session('status'))
            <div class="card p-4 mb-6 @if(session('status') === 'banner-deleted') bg-red-50 border-red-200 @else bg-green-50 border-green-200 @endif">
                <div class="flex items-center gap-2 text-sm @if(session('status') === 'banner-deleted') text-red-700 @else text-green-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @if(session('status') === 'banner-created') Banner berhasil ditambahkan. @elseif(session('status') === 'banner-updated') Banner berhasil diperbarui. @elseif(session('status') === 'banner-deleted') Banner berhasil dihapus. @endif
                </div>
            </div>
        @endif

        <div class="card overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-dark-100 bg-dark-50/50">
                        <th class="text-left text-xs font-semibold text-dark-500 uppercase px-4 py-3">Preview</th>
                        <th class="text-left text-xs font-semibold text-dark-500 uppercase px-4 py-3">Judul</th>
                        <th class="text-left text-xs font-semibold text-dark-500 uppercase px-4 py-3">Link</th>
                        <th class="text-center text-xs font-semibold text-dark-500 uppercase px-4 py-3">Urutan</th>
                        <th class="text-center text-xs font-semibold text-dark-500 uppercase px-4 py-3">Status</th>
                        <th class="text-right text-xs font-semibold text-dark-500 uppercase px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    @forelse ($banners as $banner)
                        <tr class="hover:bg-dark-50/30 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-20 h-12 rounded-lg overflow-hidden bg-dark-100">
                                    @if ($banner->image_path)
                                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-dark-300 text-xs">No image</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-dark-900">{{ $banner->title }}</td>
                            <td class="px-4 py-3 text-sm text-dark-500 max-w-[200px] truncate">{{ $banner->link ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-dark-600 text-center">{{ $banner->order }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($banner->is_active)
                                    <span class="badge-success text-[10px]">Aktif</span>
                                @else
                                    <span class="badge bg-dark-100 text-dark-500 text-[10px]">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openEditModal({{ $banner->id }}, '{{ addslashes($banner->title) }}', '{{ addslashes($banner->link ?? '') }}', {{ $banner->order }}, {{ $banner->is_active ? 1 : 0 }})" class="text-primary-600 hover:text-primary-700 text-xs font-medium transition-colors">Edit</button>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-medium transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-sm text-dark-400">Belum ada banner.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($banners->hasPages())
            <div class="flex justify-center mt-6">
                {{ $banners->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('modal-create').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold font-display text-dark-900 mb-4">Tambah Banner</h2>
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Judul Banner</label>
                    <input type="text" name="title" required class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Gambar Banner</label>
                    <input type="file" name="image_path" required accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-dark-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Link Tujuan (opsional)</label>
                    <input type="text" name="link" placeholder="/products" class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-1">Urutan</label>
                        <input type="number" name="order" min="0" value="{{ \App\Models\Banner::max('order') + 1 }}" class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-dark-700 mt-7">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-dark-300 text-primary-600 focus:ring-primary-400">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('modal-edit').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold font-display text-dark-900 mb-4">Edit Banner</h2>
            <form id="form-edit" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Judul Banner</label>
                    <input type="text" name="title" id="edit-title" required class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Ganti Gambar (opsional)</label>
                    <input type="file" name="image_path" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-dark-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Link Tujuan (opsional)</label>
                    <input type="text" name="link" id="edit-link" class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-1">Urutan</label>
                        <input type="number" name="order" id="edit-order" min="0" class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-dark-700 mt-7">
                            <input type="checkbox" name="is_active" id="edit-active" value="1" class="rounded border-dark-300 text-primary-600 focus:ring-primary-400">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, title, link, order, isActive) {
            document.getElementById('form-edit').action = '{{ route("admin.banners.update", ":id") }}'.replace(':id', id);
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-link').value = link;
            document.getElementById('edit-order').value = order;
            document.getElementById('edit-active').checked = isActive === 1;
            document.getElementById('modal-edit').classList.remove('hidden');
        }
    </script>
</x-dashboard-layout>
