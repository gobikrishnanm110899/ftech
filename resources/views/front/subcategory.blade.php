@extends('front.layout')

@section('title', $subcategory->name.' '.$category->name)

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-8">
        <div class="text-sm text-zinc-500">
            <a href="{{ route('category.show', $category->slug) }}" class="hover:text-orange-700">{{ $category->name }}</a>
        </div>
        <h1 class="mt-1 text-3xl font-semibold">{{ $subcategory->name }} Listings</h1>

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
