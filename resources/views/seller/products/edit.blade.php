<x-dashboard-layout>
    <x-slot name="sidebarTitle">Seller Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('seller.products.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('seller.orders.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Pesanan
        </a>
        <a href="#" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('seller.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
        <a href="{{ route('seller.store.edit') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
            Pengaturan Toko
        </a>
    </x-slot>

    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('seller.products.index') }}" class="inline-flex items-center gap-1.5 text-sm text-dark-500 hover:text-primary-600 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Produk
        </a>
        <h1 class="text-2xl font-bold font-display text-dark-900">Edit Produk</h1>
        <p class="text-sm text-dark-500 mt-0.5">{{ $product->name }}</p>
    </div>

    <div class="max-w-2xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-medium text-dark-700">Nama Produk <span class="text-red-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required
                        class="input-modern">
                    <x-input-error :messages="$errors->get('name')" class="text-xs text-red-500 mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="category_id" class="text-sm font-medium text-dark-700">Kategori <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" required class="input-modern cursor-pointer">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="text-xs text-red-500 mt-1" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="sku" class="text-sm font-medium text-dark-700">SKU</label>
                        <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                            class="input-modern">
                        <x-input-error :messages="$errors->get('sku')" class="text-xs text-red-500 mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="price" class="text-sm font-medium text-dark-700">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="any"
                            class="input-modern">
                        <x-input-error :messages="$errors->get('price')" class="text-xs text-red-500 mt-1" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="stock" class="text-sm font-medium text-dark-700">Stok <span class="text-red-500">*</span></label>
                        <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                            class="input-modern">
                        <x-input-error :messages="$errors->get('stock')" class="text-xs text-red-500 mt-1" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="weight" class="text-sm font-medium text-dark-700">Berat (gram)</label>
                        <input id="weight" type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="0"
                            class="input-modern">
                        <x-input-error :messages="$errors->get('weight')" class="text-xs text-red-500 mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="condition" class="text-sm font-medium text-dark-700">Kondisi <span class="text-red-500">*</span></label>
                        <select id="condition" name="condition" required class="input-modern cursor-pointer">
                            <option value="new" @selected(old('condition', $product->condition) === 'new')>Baru</option>
                            <option value="used" @selected(old('condition', $product->condition) === 'used')>Bekas</option>
                        </select>
                        <x-input-error :messages="$errors->get('condition')" class="text-xs text-red-500 mt-1" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="status" class="text-sm font-medium text-dark-700">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required class="input-modern cursor-pointer">
                            <option value="active" @selected(old('status', $product->status) === 'active')>Aktif</option>
                            <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Nonaktif</option>
                            <option value="draft" @selected(old('status', $product->status) === 'draft')>Draft</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="text-xs text-red-500 mt-1" />
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="description" class="text-sm font-medium text-dark-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="input-modern resize-none">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="text-xs text-red-500 mt-1" />
                </div>

                @if ($product->images && count($product->images) > 0)
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-dark-700">Gambar Saat Ini</label>
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ($product->images as $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-20 rounded-xl object-cover border border-dark-100">
                                    <label class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer hover:bg-red-600 transition-colors text-[10px]">
                                        <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="hidden peer">
                                        <svg class="w-3 h-3 peer-checked:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                                        <svg class="w-3 h-3 peer-checked:hidden block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-dark-400">Klik tanda × untuk hapus gambar (akan dihapus saat simpan).</p>
                    </div>
                @endif

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-dark-700">Tambah Gambar Baru</label>
                    <div class="border-2 border-dashed border-dark-200 rounded-2xl p-6 text-center hover:border-primary-400 transition-colors" x-data="{ previews: [], handleFiles(files) { this.previews = []; Array.from(files).forEach(f => { const reader = new FileReader(); reader.onload = e => this.previews.push(e.target.result); reader.readAsDataURL(f); }); } }">
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="hidden" @change="handleFiles($event.target.files)">
                        <label for="images" class="cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-sm font-medium text-dark-700">Klik untuk upload gambar</p>
                            <p class="text-xs text-dark-400 mt-1">JPG, PNG, WebP. Maks 2MB per file.</p>
                        </label>
                        <template x-if="previews.length > 0">
                            <div class="flex flex-wrap gap-3 mt-4 justify-center">
                                <template x-for="(preview, index) in previews" :key="index">
                                    <div class="relative group">
                                        <img :src="preview" class="w-20 h-20 rounded-xl object-cover border border-dark-200">
                                        <button type="button" @click="previews.splice(index, 1)" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">×</button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Variants -->
                <div class="flex flex-col gap-1.5" x-data="{
                    variants: [
                        @foreach ($product->variants as $variant)
                            { id: {{ $variant->id }}, name: '{{ addslashes($variant->name) }}', price_adjustment: '{{ $variant->price_adjustment }}', stock: {{ $variant->stock }}, sku: '{{ addslashes($variant->sku ?? '') }}', is_active: {{ $variant->is_active ? 'true' : 'false' }} },
                        @endforeach
                    ],
                    removedIds: [],
                    addVariant() { this.variants.push({}); },
                    removeVariant(index) {
                        if (this.variants[index].id) {
                            this.removedIds.push(this.variants[index].id);
                        }
                        this.variants.splice(index, 1);
                    }
                }">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-dark-700">Variasi Produk</label>
                        <button type="button" @click="addVariant()" class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Tambah Variasi
                        </button>
                    </div>
                    <p class="text-xs text-dark-400">Opsional. Tambah variasi seperti ukuran, warna, dll.</p>

                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="border border-dark-100 rounded-2xl p-4 space-y-3 relative">
                            <button type="button" @click="removeVariant(index)"
                                class="absolute top-3 right-3 text-dark-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                            <input type="hidden" :name="`variants[${index}][id]`" :value="variant.id">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-dark-500">Nama Variasi <span class="text-red-500">*</span></label>
                                    <input type="text" :name="`variants[${index}][name]`" x-model="variant.name"
                                        class="input-modern text-sm mt-1" placeholder="Contoh: Ukuran L">
                                </div>
                                <div>
                                    <label class="text-xs text-dark-500">Penyesuaian Harga (Rp)</label>
                                    <input type="number" :name="`variants[${index}][price_adjustment]`" x-model="variant.price_adjustment"
                                        class="input-modern text-sm mt-1" placeholder="0" min="0" step="any">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="text-xs text-dark-500">Stok <span class="text-red-500">*</span></label>
                                    <input type="number" :name="`variants[${index}][stock]`" x-model="variant.stock"
                                        class="input-modern text-sm mt-1" placeholder="0" min="0" required>
                                </div>
                                <div>
                                    <label class="text-xs text-dark-500">SKU</label>
                                    <input type="text" :name="`variants[${index}][sku]`" x-model="variant.sku"
                                        class="input-modern text-sm mt-1" placeholder="Opsional">
                                </div>
                                <div class="flex items-end gap-2">
                                    <label class="flex items-center gap-1.5 text-xs text-dark-600 cursor-pointer">
                                        <input type="checkbox" :name="`variants[${index}][is_active]`" value="1" x-model="variant.is_active"
                                            class="w-4 h-4 rounded text-primary-500 focus:ring-primary-400">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-for="id in removedIds" :key="id">
                        <input type="hidden" name="removed_variant_ids[]" :value="id">
                    </template>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('seller.products.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
