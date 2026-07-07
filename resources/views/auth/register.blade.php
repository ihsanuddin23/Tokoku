<x-guest-layout>
    <div class="card p-0 shadow-card-hover overflow-hidden animate-fade-in-up">
        <!-- Gradient Header -->
        <div class="relative bg-gradient-to-br from-secondary-500 via-secondary-600 to-primary-600 p-6 pb-10 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-primary-400/20 rounded-full blur-xl"></div>
            <div class="absolute inset-0 bg-grid opacity-10"></div>
            <div class="relative flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold font-display text-white">Buat Akun Baru</h1>
                    <p class="text-xs text-primary-100">Daftar untuk mulai berbelanja</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-6 -mt-6 relative">

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-sm font-medium text-dark-700">Nama Lengkap</label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="input-modern pl-11"
                        placeholder="Nama lengkap Anda" autocomplete="name">
                </div>
                <x-input-error :messages="$errors->get('name')" class="text-xs text-red-500 mt-1" />
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-sm font-medium text-dark-700">Email</label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="input-modern pl-11"
                        placeholder="nama@email.com" autocomplete="username">
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500 mt-1" />
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5" x-data="{ show: false, pwd: '', strength: 0, label: '', color: '' }" x-init="
                $watch('pwd', (val) => {
                    let s = 0;
                    if (val.length >= 8) s++;
                    if (/[A-Z]/.test(val)) s++;
                    if (/[0-9]/.test(val)) s++;
                    if (/[^A-Za-z0-9]/.test(val)) s++;
                    strength = s;
                    const labels = ['Terlalu lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];
                    const colors = ['bg-red-400', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-green-400'];
                    label = labels[s];
                    color = colors[s];
                })
            ">
                <label for="password" class="text-sm font-medium text-dark-700">Password</label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <input id="password" :type="show ? 'text' : 'password'" name="password" x-model="pwd" required
                        class="input-modern pl-11 pr-11"
                        placeholder="Minimal 8 karakter" autocomplete="new-password">
                    <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-dark-400 hover:text-primary-500 transition-colors">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <!-- Strength meter -->
                <div x-show="pwd.length > 0" x-transition style="display: none;" class="mt-2">
                    <div class="flex gap-1.5">
                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300" :class="strength >= 1 ? color : 'bg-dark-100'"></div>
                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300" :class="strength >= 2 ? color : 'bg-dark-100'"></div>
                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300" :class="strength >= 3 ? color : 'bg-dark-100'"></div>
                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300" :class="strength >= 4 ? color : 'bg-dark-100'"></div>
                    </div>
                    <p class="text-[10px] text-dark-400 mt-1.5" x-text="label"></p>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500 mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-sm font-medium text-dark-700">Konfirmasi Password</label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="input-modern pl-11"
                        placeholder="Ulangi password" autocomplete="new-password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-xs text-red-500 mt-1" />
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-primary w-full">
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-sm text-dark-500 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:text-primary-700 hover:underline transition-colors">Masuk di sini</a>
        </p>
        </div>
    </div>
</x-guest-layout>
