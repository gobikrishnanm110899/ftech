@extends('front.layout')

@section('title', 'Search Vehicles')

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-8">
        <h1 class="text-3xl font-semibold">Search Vehicles</h1>
        <form class="mt-8 grid gap-4 rounded-3xl border border-slate-100 bg-white p-6 shadow-md shadow-slate-100/50 sm:grid-cols-2 lg:grid-cols-6" action="{{ route('search') }}">
            <input name="q" value="{{ $queryText }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600 sm:col-span-2" placeholder="Search vehicle, year...">
            <select name="category_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="subcategory_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600">
                <option value="">All Brands</option>
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" @selected(request('subcategory_id') == $subcategory->id)>{{ $subcategory->name }}</option>
                @endforeach
            </select>
            <select name="fuel_type" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600">
                <option value="">All Fuels</option>
                @foreach (['Petrol', 'Diesel', 'CNG', 'Electric', 'Hybrid'] as $fuel)
                    <option value="{{ $fuel }}" @selected(request('fuel_type') === $fuel)>{{ $fuel }}</option>
                @endforeach
            </select>
            <button class="w-full rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Apply Filters</button>
        </form>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($vehicles as $vehicle)
                @include('front.partials.vehicle-card', ['vehicle' => $vehicle])
            @empty
                <p class="text-zinc-600">No matching vehicles found.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $vehicles->links() }}</div>
    </main>
@endsection
