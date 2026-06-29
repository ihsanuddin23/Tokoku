<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <title>{{ config('app.name', 'TokoKu') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-mesh text-dark-900 min-h-screen flex flex-col pb-16 sm:pb-0">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Flash Messages -->
        @if (session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 animate-fade-in-down">
                <div class="glass border-blue-200/50 text-blue-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('info') }}
                </div>
            </div>
        @endif

        @if (session('status'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 animate-fade-in-down">
                <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('partials.footer')

        <!-- Mobile Bottom Navigation -->
        <nav class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-dark-100 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] pb-[env(safe-area-inset-bottom)]">
            <div class="flex items-center justify-around py-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 px-3 py-1.5 text-dark-600 hover:text-primary-600 transition-colors {{ request()->routeIs('home') ? 'text-primary-600' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="text-[10px] font-medium">Home</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-1 px-3 py-1.5 text-dark-600 hover:text-primary-600 transition-colors {{ request()->routeIs('products.index') ? 'text-primary-600' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span class="text-[10px] font-medium">Kategori</span>
                </a>
                <a href="{{ route('cart') }}" class="flex flex-col items-center gap-1 px-3 py-1.5 text-dark-600 hover:text-primary-600 transition-colors {{ request()->routeIs('cart') ? 'text-primary-600' : '' }}">
                    <div class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @auth
                            @if (auth()->user()->cartItems()->count() > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ auth()->user()->cartItems()->count() }}</span>
                            @endif
                        @endauth
                    </div>
                    <span class="text-[10px] font-medium">Keranjang</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 px-3 py-1.5 text-dark-600 hover:text-primary-600 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary-600' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="text-[10px] font-medium">Akun</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 px-3 py-1.5 text-dark-600 hover:text-primary-600 transition-colors {{ request()->routeIs('login') ? 'text-primary-600' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="text-[10px] font-medium">Masuk</span>
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Cookie Consent Banner -->
        <div x-data="{ show: localStorage.getItem('cookieConsent') !== 'true' }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-0 sm:bottom-4 left-0 right-0 sm:left-4 sm:right-4 lg:left-1/2 lg:right-auto lg:-translate-x-1/2 z-50 bg-white border border-dark-200 shadow-card-hover rounded-none sm:rounded-2xl p-4 sm:p-5" style="display: none;">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-dark-900">Kami menggunakan cookie</p>
                        <p class="text-xs text-dark-500 mt-0.5">Website ini menggunakan cookie untuk meningkatkan pengalaman dan keamanan Anda.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                    <button @click="show = false; localStorage.setItem('cookieConsent', 'true');" class="flex-1 sm:flex-none bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors active:scale-95">
                        Izinkan
                    </button>
                    <button @click="show = false; localStorage.setItem('cookieConsent', 'false');" class="flex-1 sm:flex-none bg-white hover:bg-dark-50 text-dark-600 border border-dark-200 text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors active:scale-95">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
