<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <title>@yield('meta_title', config('app.name', 'TokoKu'))</title>
        <meta name="description" content="@yield('meta_description', 'TokoKu — Belanja mudah, jualan untung. Platform e-commerce multi-role dengan produk terlengkap.')">

        <!-- Open Graph -->
        <meta property="og:title" content="@yield('og_title', config('app.name', 'TokoKu'))">
        <meta property="og:description" content="@yield('og_description', 'TokoKu — Belanja mudah, jualan untung.')">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="@yield('og_image', asset('favicon.svg'))">
        <meta property="og:site_name" content="{{ config('app.name', 'TokoKu') }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('og_title', config('app.name', 'TokoKu'))">
        <meta name="twitter:description" content="@yield('og_description', 'TokoKu — Belanja mudah, jualan untung.')">
        <meta name="twitter:image" content="@yield('og_image', asset('favicon.svg'))">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-dark-900">
        <div class="min-h-screen flex">
            <!-- Left: Brand Section -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 via-primary-500 to-primary-700 flex-col justify-between p-12 text-white relative overflow-hidden">
                <!-- Decorative shapes -->
                <div class="absolute top-20 right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-20 left-10 w-48 h-48 bg-primary-300/20 rounded-full blur-2xl animate-pulse-slow"></div>
                <div class="absolute top-1/2 right-1/3 w-32 h-32 bg-secondary-400/20 rounded-full blur-xl animate-float" style="animation-delay: 1s;"></div>

                <!-- Grid overlay -->
                <div class="absolute inset-0 bg-grid opacity-10"></div>

                <!-- Content -->
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-xl group-hover:scale-110 transition-transform duration-300">
                            T
                        </div>
                        <span class="text-2xl font-bold font-display">TokoKu</span>
                    </a>
                </div>

                <div class="relative z-10 space-y-6">
                    <h2 class="text-4xl font-bold font-display leading-tight">
                        Belanja Mudah,<br>
                        <span class="text-primary-200">Jualan Menyenangkan</span>
                    </h2>
                    <p class="text-primary-100 leading-relaxed text-lg max-w-md">
                        Platform e-commerce modern yang menghubungkan pembeli dan penjual dalam satu ekosistem yang simpel dan terpercaya.
                    </p>

                    <!-- Feature pills -->
                    <div class="flex flex-wrap gap-3 pt-4">
                        <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Belanja Aman
                        </div>
                        <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Mulai Berjualan
                        </div>
                        <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Proses Cepat
                        </div>
                    </div>

                    <!-- Stats row -->
                    <div class="flex gap-8 pt-6">
                        <div>
                            <p class="text-2xl font-bold font-display">10K+</p>
                            <p class="text-xs text-primary-200 mt-0.5">Pembeli</p>
                        </div>
                        <div class="w-px bg-white/20"></div>
                        <div>
                            <p class="text-2xl font-bold font-display">500+</p>
                            <p class="text-xs text-primary-200 mt-0.5">Seller</p>
                        </div>
                        <div class="w-px bg-white/20"></div>
                        <div>
                            <p class="text-2xl font-bold font-display">99%</p>
                            <p class="text-xs text-primary-200 mt-0.5">Puas</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="relative z-10">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/10 max-w-md">
                        <div class="flex items-center gap-1 mb-3">
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        </div>
                        <p class="text-sm text-primary-50 leading-relaxed mb-4">
                            "TokoKu sangat memudahkan saya berjualan. Interface-nya intuitif, fiturnya lengkap, dan pembeli terus bertambah."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold text-sm">R</div>
                            <div>
                                <p class="text-sm font-semibold text-white">Rina Wijaya</p>
                                <p class="text-xs text-primary-200">Seller · Jakarta</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-sm text-primary-200">
                    &copy; {{ date('Y') }} TokoKu. Powered by Laravel & Tailwind CSS.
                </div>
            </div>

            <!-- Right: Form Section -->
            <div class="w-full lg:w-1/2 flex flex-col bg-mesh relative">
                <!-- Top Bar -->
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile Logo -->
                    <a href="{{ route('home') }}" class="lg:hidden inline-flex items-center gap-2 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-base shadow-glow group-hover:scale-110 transition-transform duration-300">
                            T
                        </div>
                        <span class="text-lg font-bold font-display text-dark-900">TokoKu</span>
                    </a>
                    <!-- Desktop spacer -->
                    <div class="hidden lg:block"></div>
                    <!-- Back to Home -->
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-dark-500 hover:text-primary-600 font-medium px-3 py-2 rounded-xl hover:bg-primary-50 transition-all duration-200 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        <span class="hidden sm:inline">Kembali ke Beranda</span>
                    </a>
                </div>

                <!-- Form Content -->
                <div class="flex-1 flex flex-col justify-center items-center px-6 pb-12">
                    <div class="w-full max-w-md animate-fade-in-up">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
