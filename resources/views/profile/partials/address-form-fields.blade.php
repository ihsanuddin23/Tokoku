<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="flex flex-col gap-1">
        <label for="label" class="text-sm font-medium text-gray-700">Label Alamat</label>
        <input id="label" type="text" name="label" value="{{ old('label', $oldValues->label ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="Rumah, Kantor, dll">
    </div>
    <div class="flex flex-col gap-1">
        <label for="recipient_name" class="text-sm font-medium text-gray-700">Nama Penerima</label>
        <input id="recipient_name" type="text" name="recipient_name" value="{{ old('recipient_name', $oldValues->recipient_name ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="Nama penerima paket">
    </div>
    <div class="flex flex-col gap-1">
        <label for="phone" class="text-sm font-medium text-gray-700">No. HP Penerima</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $oldValues->phone ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="08xxxxxxxxxx">
    </div>
    <div class="flex flex-col gap-1">
        <label for="postal_code" class="text-sm font-medium text-gray-700">Kode Pos</label>
        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $oldValues->postal_code ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="12345">
    </div>
    <div class="flex flex-col gap-1">
        <label for="province" class="text-sm font-medium text-gray-700">Provinsi</label>
        <input id="province" type="text" name="province" value="{{ old('province', $oldValues->province ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="Jawa Barat">
    </div>
    <div class="flex flex-col gap-1">
        <label for="city" class="text-sm font-medium text-gray-700">Kota/Kabupaten</label>
        <input id="city" type="text" name="city" value="{{ old('city', $oldValues->city ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="Bandung">
    </div>
    <div class="flex flex-col gap-1 sm:col-span-2">
        <label for="district" class="text-sm font-medium text-gray-700">Kecamatan</label>
        <input id="district" type="text" name="district" value="{{ old('district', $oldValues->district ?? '') }}" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
            placeholder="Coblong">
    </div>
    <div class="flex flex-col gap-1 sm:col-span-2">
        <label for="full_address" class="text-sm font-medium text-gray-700">Alamat Lengkap</label>
        <textarea id="full_address" name="full_address" rows="3" required
            class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition resize-none"
            placeholder="Jl. Contoh No. 123, RT 01/RW 02">{{ old('full_address', $oldValues->full_address ?? '') }}</textarea>
    </div>
    <div class="sm:col-span-2">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_default" value="1" {{ old('is_default', $oldValues->is_default ?? false) ? 'checked' : '' }}
                class="rounded border-gray-300 text-primary-500 focus:ring-primary-400">
            <span class="ms-2 text-sm text-gray-600">Jadikan alamat utama</span>
        </label>
    </div>
</div>
