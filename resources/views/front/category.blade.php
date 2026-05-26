@extends('front.layout')

@section('title', $category->name.' Vehicles')

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <div class="text-sm text-zinc-500">Category</div>
                <h1 class="text-3xl font-semibold">{{ $category->name }}</h1>
            </div>
            <form action="{{ route('search') }}" class="flex gap-2">
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <input name="q" class="rounded-md border border-zinc-300 px-3 py-2" placeholder="Search in {{ $category->name }}">
                <button class="rounded-md bg-orange-600 px-4 py-2 text-white hover:bg-orange-700">Search</button>
            </form>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @foreach ($subcategories as $subcategory)
                <a class="rounded-md border border-orange-100 bg-white px-4 py-2 text-sm hover:border-orange-400 hover:text-orange-700" href="{{ route('subcategory.show', [$category->slug, $subcategory->slug]) }}">
                    {{ $subcategory->name }} ({{ $subcategory->vehicles_count }})
                </a>
            @endforeach
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($vehicles as $vehicle)
                @include('front.partials.vehicle-card', ['vehicle' => $vehicle])
            @empty
                <p class="text-zinc-600">No vehicles found.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $vehicles->links() }}</div>
    </main>
@endsection
