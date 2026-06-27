<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Jadi Seller</span>
        </div>

        <!-- Gradient Hero -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-600 p-6 sm:p-8 mb-8 animate-fade-in-up">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-secondary-400/20 rounded-full blur-2xl"></div>
            <div class="absolute inset-0 bg-grid opacity-10"></div>
            <div class="relative flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold font-display text-white mb-1">Jadi Seller</h1>
                    <p class="text-sm text-primary-100">Buka toko Anda di TokoKu dan mulai berjualan hari ini.</p>
                </div>
            </div>
        </div>

        @if (session('status') === 'seller-application-submitted')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pengajuan seller berhasil dikirim! Menunggu verifikasi admin.
            </div>
        @endif

        @if ($verification && $verification->status !== 'rejected')
            <!-- Status Card -->
            <div class="card p-8 text-center">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4
                    @if ($verification->status === 'pending') bg-amber-100
                    @elseif ($verification->status === 'approved') bg-green-100
                    @endif">
                    @if ($verification->status === 'pending')
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif ($verification->status === 'approved')
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @endif
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">
                    @if ($verification->status === 'pending')
                        Pengajuan Sedang Ditinjau
                    @elseif ($verification->status === 'approved')
                        Selamat! Toko Anda Disetujui
                    @endif
                </h2>
                <p class="text-sm text-dark-500 mb-4">
                    @if ($verification->status === 'pending')
                        Nama toko: <strong>{{ $verification->store_name }}</strong><br>
                        Kota: {{ $verification->city }}<br><br>
                        Mohon tunggu, admin akan memverifikasi toko Anda dalam 1-2 hari kerja.
                    @elseif ($verification->status === 'approved')
                        Toko <strong>{{ $verification->store_name }}</strong> sudah aktif. Anda bisa mulai menambahkan produk.
                    @endif
                </p>
                @if ($verification->status === 'approved')
                    <a href="{{ route('seller.dashboard') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        Ke Dashboard Seller
                    </a>
                @endif
            </div>
        @else
            @if ($verification && $verification->status === 'rejected')
                <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Pengajuan sebelumnya ditolak: {{ $verification->admin_note }}. Silakan ajukan kembali.
                </div>
            @endif
            <!-- Benefits Section -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="card p-4 text-center card-hover group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mx-auto mb-2 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-dark-900">Gratis</p>
                    <p class="text-[10px] text-dark-400 mt-0.5">Tanpa biaya awal</p>
                </div>
                <div class="card p-4 text-center card-hover group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center mx-auto mb-2 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-dark-900">10K+ Buyers</p>
                    <p class="text-[10px] text-dark-400 mt-0.5">Jangkauan luas</p>
                </div>
                <div class="card p-4 text-center card-hover group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-2 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-dark-900">Cepat</p>
                    <p class="text-[10px] text-dark-400 mt-0.5">Verifikasi 1-2 hari</p>
                </div>
            </div>

            <!-- Stepper -->
            <div class="flex items-center justify-between mb-6 px-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-glow">1</div>
                    <span class="text-xs font-medium text-dark-700 hidden sm:inline">Isi Form</span>
                </div>
                <div class="flex-1 h-0.5 bg-gradient-to-r from-primary-300 to-dark-200 mx-2 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-dark-100 text-dark-400 flex items-center justify-center text-xs font-bold">2</div>
                    <span class="text-xs font-medium text-dark-400 hidden sm:inline">Verifikasi</span>
                </div>
                <div class="flex-1 h-0.5 bg-dark-200 mx-2 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-dark-100 text-dark-400 flex items-center justify-center text-xs font-bold">3</div>
                    <span class="text-xs font-medium text-dark-400 hidden sm:inline">Mulai Jual</span>
                </div>
            </div>

            <!-- Application Form -->
            <div class="card p-6">
                <form method="POST" action="{{ route('become-seller.store') }}" class="space-y-5">
                    @csrf

                    <div class="flex flex-col gap-1.5">
                        <label for="store_name" class="text-sm font-medium text-dark-700">Nama Toko</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                            <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" required
                                class="input-modern pl-11" placeholder="Contoh: Toko Elektronik Maju">
                        </div>
                        <x-input-error :messages="$errors->get('store_name')" class="text-xs text-red-500 mt-1" />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="city" class="text-sm font-medium text-dark-700">Kota Asal</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <input id="city" type="text" name="city" value="{{ old('city') }}" required
                                class="input-modern pl-11" placeholder="Contoh: Jakarta Selatan">
                        </div>
                        <x-input-error :messages="$errors->get('city')" class="text-xs text-red-500 mt-1" />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="description" class="text-sm font-medium text-dark-700">Deskripsi Toko</label>
                        <textarea id="description" name="description" rows="4"
                            class="input-modern resize-none" placeholder="Ceritakan singkat tentang toko Anda...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="text-xs text-red-500 mt-1" />
                    </div>

                    <!-- Info -->
                    <div class="bg-primary-50/50 border border-primary-100 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-xs text-dark-500">
                            Dengan mendaftar sebagai seller, Anda menyetujui syarat & ketentuan TokoKu.
                            Pengajuan akan diverifikasi oleh admin dalam 1-2 hari kerja.
                        </p>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Ajukan Pendaftaran
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
