@props(['sidebarTitle' => 'Dashboard', 'sidebar' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <title>{{ config('app.name', 'TokoKu') }} — {{ $sidebarTitle }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-mesh text-dark-900">
        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
            <!-- Sidebar -->
            <aside class="w-64 bg-dark-900 h-screen sticky top-0 flex flex-col shrink-0 hidden lg:flex z-40 relative">
                <!-- Gradient accent bar -->
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-primary-400 via-primary-500 to-secondary-500"></div>

                <!-- Logo -->
                <div class="p-5 border-b border-dark-800 relative">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-glow group-hover:scale-110 transition-transform">
                            T
                        </div>
                        <div>
                            <span class="text-lg font-bold font-display text-white block leading-tight">TokoKu</span>
                            <span class="text-[11px] text-dark-400">{{ $sidebarTitle }}</span>
                        </div>
                    </div>
                </div>

                <!-- Nav -->
                <nav class="flex-1 p-3 flex flex-col gap-1 overflow-y-auto scrollbar-thin">
                    {{ $sidebar }}
                </nav>

                <!-- User Profile Card -->
                <div class="p-3 border-t border-dark-800">
                    <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-dark-800/50 mb-2">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shrink-0 shadow-glow">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-dark-400 truncate capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-green-400 shrink-0 animate-pulse"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 text-dark-400 hover:text-white hover:bg-dark-800 rounded-xl text-sm font-medium transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            Kembali ke Beranda
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl text-sm font-medium transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-dark-900/60 backdrop-blur-sm z-40 lg:hidden" style="display: none;" @click="sidebarOpen = false"></div>

            <!-- Mobile Sidebar Drawer -->
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="fixed left-0 top-0 bottom-0 w-64 bg-dark-900 shadow-2xl flex flex-col z-50 lg:hidden" style="display: none;">
                <div class="p-5 border-b border-dark-800 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg">
                            T
                        </div>
                        <span class="text-lg font-bold font-display text-white">TokoKu</span>
                    </div>
                    <button @click="sidebarOpen = false" class="text-dark-400 hover:text-white p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <nav class="flex-1 p-3 flex flex-col gap-1 overflow-y-auto scrollbar-thin">
                    {{ $sidebar }}
                </nav>
                <div class="p-3 border-t border-dark-800 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-dark-400 hover:text-white hover:bg-dark-800 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Beranda
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl text-sm font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Bar -->
                <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-dark-100">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 gap-4">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 text-dark-600 hover:bg-dark-50 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>

                        <!-- Title (mobile) -->
                        <span class="lg:hidden text-sm font-semibold text-dark-900">{{ $sidebarTitle }}</span>

                        <!-- Search (desktop) -->
                        <div class="hidden lg:flex flex-1 max-w-md">
                            <div class="relative w-full group">
                                <input type="text" placeholder="Cari produk, pesanan, user..."
                                    class="w-full bg-dark-50 border border-dark-200/60 rounded-xl pl-11 pr-5 py-2.5 text-sm outline-none transition-all duration-200 focus:bg-white focus:border-primary-400 focus:ring-4 focus:ring-primary-100 placeholder-dark-400">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ notifOpen: false }">
                                <button @click="notifOpen = !notifOpen" class="relative p-2.5 text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group">
                                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-secondary-500 rounded-full animate-pulse"></span>
                                </button>
                                <div x-show="notifOpen" @click.outside="notifOpen = false" x-transition.origin.top.right
                                    class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-card-hover py-2 border border-dark-100 animate-scale-in" style="display: none;">
                                    <div class="px-4 py-3 border-b border-dark-100 flex items-center justify-between">
                                        <p class="text-sm font-semibold text-dark-900">Notifikasi</p>
                                        <span class="badge-primary text-[10px]">2 Baru</span>
                                    </div>
                                    <div class="max-h-80 overflow-y-auto scrollbar-thin">
                                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-dark-50 transition-colors">
                                            <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-dark-900">Order baru masuk</p>
                                                <p class="text-xs text-dark-400 mt-0.5">Order #ORD-001 dari pembeli</p>
                                            </div>
                                        </a>
                                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-dark-50 transition-colors">
                                            <div class="w-9 h-9 rounded-xl bg-secondary-100 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-dark-900">Stok produk menipis</p>
                                                <p class="text-xs text-dark-400 mt-0.5">3 produk perlu restock segera</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="border-t border-dark-100 p-2">
                                        <a href="#" class="block text-center text-sm text-primary-600 hover:text-primary-700 font-medium py-2 rounded-lg hover:bg-primary-50 transition-colors">Lihat Semua</a>
                                    </div>
                                </div>
                            </div>

                            <!-- User -->
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-semibold text-dark-900 leading-tight">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-dark-400 capitalize">{{ Auth::user()->role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('info'))
                    <div class="px-4 sm:px-6 lg:px-8 pt-4 animate-fade-in-down">
                        <div class="glass border-blue-200/50 text-blue-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ session('info') }}
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 animate-fade-in">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
