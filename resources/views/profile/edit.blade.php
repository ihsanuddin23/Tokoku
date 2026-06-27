<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Cover Banner -->
        <div class="relative h-32 sm:h-40 rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 overflow-hidden mb-16">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 w-32 h-32 bg-secondary-400/20 rounded-full blur-2xl"></div>
            <div class="absolute inset-0 bg-grid opacity-10"></div>
        </div>

        <!-- Profile Header (overlapping cover) -->
        <div class="flex items-end gap-4 mb-6 -mt-20 relative">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-3xl overflow-hidden shadow-glow ring-4 ring-white shrink-0">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="pb-2 flex-1">
                <h1 class="text-2xl font-bold font-display text-dark-900">{{ $user->name }}</h1>
                <p class="text-sm text-dark-500">{{ $user->email }}</p>
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="badge-primary capitalize">{{ $user->role }}</span>
                    @if ($user->phone)
                        <span class="text-xs text-dark-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            {{ $user->phone }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="card p-4 text-center">
                <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <p class="text-[10px] text-dark-400 font-medium uppercase tracking-wider">Role</p>
                <p class="text-sm font-bold text-dark-900 capitalize mt-0.5">{{ $user->role }}</p>
            </div>
            <div class="card p-4 text-center">
                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-[10px] text-dark-400 font-medium uppercase tracking-wider">Status</p>
                <p class="text-sm font-bold {{ $user->is_active ? 'text-green-600' : 'text-red-500' }} mt-0.5">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
            <div class="card p-4 text-center">
                <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-[10px] text-dark-400 font-medium uppercase tracking-wider">Bergabung</p>
                <p class="text-sm font-bold text-dark-900 mt-0.5">{{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>

        <!-- Flash -->
        @if (session('status') === 'profile-updated')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Profil berhasil diperbarui.
            </div>
        @endif

        <!-- Profile Info Card -->
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-5">Informasi Akun</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Avatar Upload -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-dark-100">
                    <div>
                        <label for="avatar" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 cursor-pointer hover:underline transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Ganti Foto
                        </label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="hidden">
                        <p class="text-xs text-dark-400 mt-1">JPG, PNG. Maks 2MB.</p>
                    </div>
                </div>

                <!-- Name -->
                <div class="flex flex-col gap-1.5 mb-4">
                    <label for="name" class="text-sm font-medium text-dark-700">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="input-modern">
                    <x-input-error :messages="$errors->get('name')" class="text-xs text-red-500 mt-1" />
                </div>

                <!-- Phone -->
                <div class="flex flex-col gap-1.5 mb-4">
                    <label for="phone" class="text-sm font-medium text-dark-700">Nomor HP</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="input-modern" placeholder="08xxxxxxxxxx">
                    <x-input-error :messages="$errors->get('phone')" class="text-xs text-red-500 mt-1" />
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-1.5 mb-6">
                    <label for="email" class="text-sm font-medium text-dark-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="input-modern">
                    <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500 mt-1" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('profile.password') }}" class="card card-hover p-5 flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-dark-900">Ganti Password</p>
                    <p class="text-xs text-dark-500 mt-0.5">Ubah password akun Anda</p>
                </div>
            </a>
            <a href="{{ route('profile.addresses') }}" class="card card-hover p-5 flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-dark-900">Alamat Pengiriman</p>
                    <p class="text-xs text-dark-500 mt-0.5">Kelola alamat Anda</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
