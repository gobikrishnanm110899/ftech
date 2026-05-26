@extends('front.layout')

@section('title', ($setting->site_name ?? 'ftech').' - Premium Vehicle Marketplace')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 text-white py-20 px-6">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.15),transparent_45%)]"></div>
        <div class="relative mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-500/10 px-3 py-1 text-xs font-semibold tracking-wide text-orange-400">
                    ✨ Premium Vehicle Listings
                </span>
                <h1 class="mt-6 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl leading-none">
                    Find Your Perfect <br>
                    <span class="bg-gradient-to-r from-orange-400 to-amber-300 bg-clip-text text-transparent">Car, Bike or Truck</span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-300">
                    Explore our curated collection of verified listings. Filter by category, manufacturer year, fuel type, and price to find exactly what you need.
                </p>
                <form action="{{ route('search') }}" class="mt-8 flex max-w-2xl gap-3 rounded-2xl bg-white/10 p-2 backdrop-blur-md border border-white/10">
                    <input name="q" class="w-full bg-transparent px-4 py-3 text-sm text-white placeholder-slate-400 outline-none" placeholder="Search Splendor, Hyundai, 2022...">
                    <button class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition-all hover:bg-orange-600">Search</button>
                </form>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                @foreach ($categories->take(4) as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                        <div class="text-3xl transition-transform duration-300 group-hover:scale-110">{{ $category->icon ?: '🚗' }}</div>
                        <div class="mt-4 font-bold text-lg text-white">{{ $category->name }}</div>
                        <div class="mt-1 text-xs text-slate-400">{{ $category->vehicles_count }} listings</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-16">
        <div class="flex items-end justify-between border-b border-slate-100 pb-5">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Featured Vehicles</h2>
                <p class="mt-1 text-sm text-slate-500">Handpicked premium listings for you</p>
            </div>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 transition-colors hover:text-indigo-700">
                View all listings →
            </a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($featuredVehicles as $vehicle)
                @include('front.partials.vehicle-card', ['vehicle' => $vehicle])
            @empty
                <p class="text-slate-500 text-sm">No featured listings found.</p>
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-8">
        <div class="border-b border-slate-100 pb-5">
            <h2 class="text-3xl font-extrabold text-slate-900">Latest Additions</h2>
            <p class="mt-1 text-sm text-slate-500">Freshly listed vehicles on our marketplace</p>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($latestVehicles as $vehicle)
                @include('front.partials.vehicle-card', ['vehicle' => $vehicle])
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-16">
        <div class="rounded-3xl bg-slate-950 p-8 md:p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(79,70,229,0.15),transparent_40%)]"></div>
            <div class="relative">
                <h2 class="text-2xl font-extrabold text-white">Popular Brands & Subcategories</h2>
                <p class="mt-1 text-sm text-slate-400">Browse vehicles by their specific brand manufacturers</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @foreach ($brands as $brand)
                        <a class="rounded-xl border border-white/5 bg-white/5 px-4 py-2.5 text-xs font-semibold text-slate-300 transition-all hover:bg-white/10 hover:text-white" href="{{ route('subcategory.show', [$brand->category->slug, $brand->slug]) }}">
                            {{ $brand->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

