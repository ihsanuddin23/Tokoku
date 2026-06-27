<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 text-sm text-dark-500 hover:text-primary-600 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Profil
            </a>
        </div>
        <div class="mb-8">
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Ganti Password</h1>
            <p class="text-sm text-dark-500">Pastikan akun Anda menggunakan password yang kuat.</p>
        </div>

        @if (session('status') === 'password-updated')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Password berhasil diperbarui.
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="lg:col-span-2 card p-6">
                <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
                    @csrf

                    <div class="flex flex-col gap-1.5">
                        <label for="current_password" class="text-sm font-medium text-dark-700">Password Saat Ini</label>
                        <div class="relative" x-data="{ show: false }">
                            <input id="current_password" :type="show ? 'text' : 'password'" name="current_password" required
                                class="input-modern pr-11" autocomplete="current-password" placeholder="Masukkan password saat ini">
                            <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-dark-400 hover:text-primary-500 transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('current_password')" class="text-xs text-red-500 mt-1" />
                    </div>

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
                        <label for="password" class="text-sm font-medium text-dark-700">Password Baru</label>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" x-model="pwd" required
                                class="input-modern pr-11" placeholder="Minimal 8 karakter" autocomplete="new-password">
                            <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-dark-400 hover:text-primary-500 transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
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

                    <div class="flex flex-col gap-1.5">
                        <label for="password_confirmation" class="text-sm font-medium text-dark-700">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="input-modern" placeholder="Ulangi password baru" autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-xs text-red-500 mt-1" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Sidebar -->
            <div class="card p-6">
                <h3 class="text-sm font-semibold font-display text-dark-900 mb-4">Tips Keamanan</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-xs text-dark-500 leading-relaxed">Gunakan minimal 8 karakter dengan kombinasi huruf besar, angka, dan simbol.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <p class="text-xs text-dark-500 leading-relaxed">Hindari menggunakan informasi pribadi seperti nama atau tanggal lahir.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-xs text-dark-500 leading-relaxed">Ubah password secara berkala untuk keamanan akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
