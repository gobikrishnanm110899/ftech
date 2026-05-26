<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'ftech') }} Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50/50 font-sans text-slate-900 antialiased" x-data="{ mobileSidebarOpen: false }">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
        <!-- Sidebar -->
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 flex w-[280px] flex-col border-r border-slate-200 bg-slate-900 text-slate-200 transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:w-auto">
            <div class="flex items-center justify-between border-b border-slate-800 px-6 py-5">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-black tracking-tight text-white">
                    <span class="bg-gradient-to-r from-orange-500 to-indigo-400 bg-clip-text text-transparent">ftech</span> Admin
                </a>
                <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <nav class="flex-1 space-y-1.5 px-4 py-6">
                @foreach ([
                    route('admin.dashboard') => ['label' => 'Dashboard', 'icon' => '📊', 'pattern' => 'admin.dashboard'],
                    route('admin.categories.index') => ['label' => 'Categories', 'icon' => '📁', 'pattern' => 'admin.categories.*'],
                    route('admin.subcategories.index') => ['label' => 'Subcategories', 'icon' => '🏷️', 'pattern' => 'admin.subcategories.*'],
                    route('admin.vehicles.index') => ['label' => 'Vehicles', 'icon' => '🚗', 'pattern' => 'admin.vehicles.*'],
                    route('admin.enquiries.index') => ['label' => 'Enquiries', 'icon' => '✉️', 'pattern' => 'admin.enquiries.*'],
                    route('admin.settings.edit') => ['label' => 'Settings', 'icon' => '⚙️', 'pattern' => 'admin.settings.*'],
                ] as $url => $data)
                    @php
                        $isActive = request()->routeIs($data['pattern']);
                    @endphp
                    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ $isActive ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}" href="{{ $url }}">
                        <span class="text-lg">{{ $data['icon'] }}</span>
                        {{ $data['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-slate-800 p-4">
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-slate-700">
                    🌐 View Main Site
                </a>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="flex flex-col min-h-screen">
            <!-- Topbar (Mobile trigger) -->
            <header class="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4 lg:px-8">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = true" class="text-slate-500 hover:text-slate-800 lg:hidden">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="select-none">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Admin Area</div>
                        <h1 class="text-xl font-extrabold text-slate-900">@yield('title', 'Admin')</h1>
                    </div>
                </div>
                <div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 transition-colors hover:bg-slate-50">Logout</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-sm font-semibold text-emerald-800 backdrop-blur-md">
                        ✨ {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-orange-100 bg-orange-50/50 p-4 text-sm font-semibold text-orange-800 backdrop-blur-md">
                        ⚠️ {{ $errors->first() }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
