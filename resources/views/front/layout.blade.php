<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $setting->site_name ?? config('app.name', 'ftech'))</title>
    <meta name="description" content="@yield('meta_description', 'Vehicle marketplace with categories, brands, search, gallery, and WhatsApp enquiries.')">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title', $setting->site_name ?? config('app.name', 'ftech'))">
    <meta property="og:description" content="@yield('meta_description', 'Vehicle listing marketplace with categories, brands, search, gallery, and WhatsApp enquiries.')">
    <meta property="og:image" content="@yield('meta_image', '')">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="@yield('title', $setting->site_name ?? config('app.name', 'ftech'))">
    <meta property="twitter:description" content="@yield('meta_description', 'Vehicle listing marketplace with categories, brands, search, gallery, and WhatsApp enquiries.')">
    <meta property="twitter:image" content="@yield('meta_image', '')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50/50 font-sans text-slate-900 antialiased">
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 border-b border-slate-100 bg-white/80 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-extrabold tracking-tight text-indigo-950">
                <span class="bg-gradient-to-r from-orange-600 to-indigo-600 bg-clip-text text-transparent">{{ $setting->site_name ?? 'ftech' }}</span>
            </a>
            
            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-2 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" class="transition-colors py-1.5 px-3 rounded-lg {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Home</a>
                <a href="{{ route('search') }}" class="transition-colors py-1.5 px-3 rounded-lg {{ request()->routeIs('search') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Search</a>
                <a href="{{ route('contact') }}" class="transition-colors py-1.5 px-3 rounded-lg {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Contact</a>
                <a href="{{ route('admin.dashboard') }}" class="rounded-full bg-indigo-950 px-4 py-2 text-xs font-bold uppercase tracking-wider text-white shadow-sm transition-all hover:bg-indigo-900 hover:shadow-indigo-100 ml-4">Admin Area</a>
            </nav>

            <!-- Mobile Menu Toggle Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="flex p-2 text-slate-600 hover:text-indigo-600 md:hidden" aria-label="Toggle menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Nav Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden border-t border-slate-100 bg-white px-6 py-4 shadow-inner" style="display: none;">
            <nav class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="transition-colors py-2 px-3 rounded-lg {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Home</a>
                <a href="{{ route('search') }}" @click="mobileMenuOpen = false" class="transition-colors py-2 px-3 rounded-lg {{ request()->routeIs('search') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Search</a>
                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="transition-colors py-2 px-3 rounded-lg {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:text-indigo-600 hover:bg-slate-50' }}">Contact</a>
                <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false" class="inline-block rounded-full bg-indigo-950 px-4 py-2 text-center text-xs font-bold uppercase tracking-wider text-white shadow-sm transition-all hover:bg-indigo-900 mt-2">Admin Area</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="mt-20 border-t border-slate-100 bg-indigo-950 text-indigo-100">
        <div class="mx-auto grid max-w-7xl gap-8 px-6 py-12 md:grid-cols-3">
            <div>
                <div class="text-xl font-bold text-white">{{ $setting->site_name ?? 'ftech' }}</div>
                <p class="mt-3 text-sm leading-relaxed text-indigo-200/80">Premium vehicle listing marketplace. Find and enquire about cars, bikes, buses, and trucks instantly via WhatsApp.</p>
            </div>
            <div class="text-sm">
                <div class="font-bold text-white uppercase tracking-wider text-xs">Contact Details</div>
                <ul class="mt-3 space-y-2 text-indigo-200/80">
                    <li class="flex items-center gap-2">
                        <span class="text-xs">📞</span> {{ $setting->whatsapp_number ?: 'WhatsApp number not set' }}
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-xs">✉️</span> {{ $setting->email ?: 'Email not set' }}
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-xs">📍</span> {{ $setting->address ?: 'Address not set' }}
                    </li>
                </ul>
            </div>
            <div>
                <div class="font-bold text-white uppercase tracking-wider text-xs">Social Channels</div>
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'telegram' => 'Telegram'] as $field => $label)
                        @if (! empty($setting->{$field}))
                            <a class="rounded-md bg-indigo-900/50 px-3 py-1.5 text-xs font-medium text-indigo-200 transition-colors hover:bg-indigo-900 hover:text-white" href="{{ $setting->{$field} }}" target="_blank">{{ $label }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="border-t border-indigo-900 py-6 text-center text-xs text-indigo-300/60">
            &copy; {{ date('Y') }} {{ $setting->site_name ?? 'ftech' }}. All rights reserved.
        </div>
    </footer>
    @livewireScripts
</body>
</html>
