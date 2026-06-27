<x-guest-layout>
    <div class="card p-0 shadow-card-hover overflow-hidden animate-fade-in-up">
        <!-- Gradient Header -->
        <div class="relative bg-gradient-to-br from-amber-400 via-orange-500 to-secondary-500 p-6 pb-10 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute inset-0 bg-grid opacity-10"></div>
            <div class="relative flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold font-display text-white">Lupa Password</h1>
                    <p class="text-xs text-amber-50">Kirim link reset ke email Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-6 -mt-6 relative">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-medium text-dark-700">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-modern pl-11"
                            placeholder="nama@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500 mt-1" />
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary w-full">
                    <span>Kirim Link Reset</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-dark-500 hover:text-primary-600 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke halaman masuk
                </a>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-gradient-to-br from-primary-50/50 to-secondary-50/30 border border-primary-100/50 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="text-xs text-dark-500 leading-relaxed">
                        <p class="font-semibold text-dark-700 mb-1">Cara reset password:</p>
                        <p>1. Masukkan email terdaftar Anda</p>
                        <p>2. Cek inbox untuk link reset</p>
                        <p>3. Klik link dan buat password baru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
