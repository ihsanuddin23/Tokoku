<x-guest-layout>
    <div class="card p-0 shadow-card-hover overflow-hidden animate-fade-in-up">
        <!-- Gradient Header -->
        <div class="relative bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-6 pb-10 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-secondary-400/20 rounded-full blur-xl"></div>
            <div class="absolute inset-0 bg-grid opacity-10"></div>
            <div class="relative flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold font-display text-white">Masuk ke Akun</h1>
                    <p class="text-xs text-primary-100">Selamat datang kembali!</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-6 -mt-6 relative">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-medium text-dark-700">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-modern pl-11"
                            placeholder="nama@email.com" autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500 mt-1" />
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-medium text-dark-700">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required
                            class="input-modern pl-11 pr-11"
                            placeholder="Masukkan password" autocomplete="current-password">
                        <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-dark-400 hover:text-primary-500 transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500 mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center cursor-pointer">
                        <input id="remember" type="checkbox" name="remember"
                            class="rounded border-dark-300 text-primary-500 focus:ring-primary-400 w-4 h-4">
                        <span class="ms-2 text-sm text-dark-600">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium hover:underline transition-colors">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary w-full">
                    <span>Masuk</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center text-sm text-dark-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:text-primary-700 hover:underline transition-colors">Daftar sekarang</a>
            </p>

            <!-- Demo hint -->
            <div class="mt-6 bg-gradient-to-br from-primary-50/50 to-secondary-50/30 border border-primary-100/50 rounded-2xl p-4" x-data="{ showCreds: false }">
                <button type="button" @click="showCreds = !showCreds" class="w-full flex items-center justify-between text-xs text-dark-500">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-medium text-primary-600">Demo Credentials</span>
                    </span>
                    <svg class="w-4 h-4 text-dark-400 transition-transform duration-300" :class="{ 'rotate-180': showCreds }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="showCreds" x-collapse x-cloak style="display: none;" class="mt-3 space-y-2">
                    <button type="button" @click="document.getElementById('email').value = 'buyer@tokoku.test'; document.getElementById('password').value = 'password';"
                        class="w-full flex items-center justify-between bg-white rounded-xl px-3 py-2.5 text-xs hover:shadow-soft transition-all border border-dark-100 group">
                        <span class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-[10px] shadow-sm">B</span>
                            <span class="font-medium text-dark-700">Buyer</span>
                        </span>
                        <span class="text-dark-400 font-mono group-hover:text-primary-600 transition-colors">buyer@tokoku.test</span>
                    </button>
                    <button type="button" @click="document.getElementById('email').value = 'seller@tokoku.test'; document.getElementById('password').value = 'password';"
                        class="w-full flex items-center justify-between bg-white rounded-xl px-3 py-2.5 text-xs hover:shadow-soft transition-all border border-dark-100 group">
                        <span class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white font-bold text-[10px] shadow-sm">S</span>
                            <span class="font-medium text-dark-700">Seller</span>
                        </span>
                        <span class="text-dark-400 font-mono group-hover:text-secondary-600 transition-colors">seller@tokoku.test</span>
                    </button>
                    <button type="button" @click="document.getElementById('email').value = 'admin@tokoku.test'; document.getElementById('password').value = 'password';"
                        class="w-full flex items-center justify-between bg-white rounded-xl px-3 py-2.5 text-xs hover:shadow-soft transition-all border border-dark-100 group">
                        <span class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-[10px] shadow-sm">A</span>
                            <span class="font-medium text-dark-700">Admin</span>
                        </span>
                        <span class="text-dark-400 font-mono group-hover:text-purple-600 transition-colors">admin@tokoku.test</span>
                    </button>
                    <p class="text-center text-[10px] text-dark-400 pt-1">Password untuk semua: <span class="font-mono font-medium text-dark-600">password</span></p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
