<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Hubungi Kami</span>
        </div>

        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold font-display text-dark-900 mb-3">Hubungi Kami</h1>
            <p class="text-dark-500 max-w-xl mx-auto">Punya pertanyaan, saran, atau kendala? Tim kami siap membantu Anda. Kirim pesan melalui formulir di bawah ini.</p>
        </div>

        @if (session('status') === 'contact-sent')
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-sm font-medium">Pesan Anda berhasil dikirim. Kami akan membalas secepatnya ke email Anda.</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contact Info -->
            <div class="space-y-4">
                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-dark-900 mb-1">Email</h3>
                    <p class="text-sm text-dark-500">{{ $contactEmail }}</p>
                </div>

                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-dark-900 mb-1">Telepon</h3>
                    <p class="text-sm text-dark-500">{{ $contactPhone }}</p>
                </div>

                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-dark-900 mb-1">Alamat</h3>
                    <p class="text-sm text-dark-500">{{ $contactAddress }}</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('contact.store') }}" class="card p-6 sm:p-8 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="subject" :value="__('Subjek')" />
                        <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" :value="old('subject')" required />
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="message" :value="__('Pesan')" />
                        <textarea id="message" name="message" rows="6" class="input-modern mt-1 block w-full" required>{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
