@extends('front.layout')

@section('title', $vehicle->title . ' - ' . ($setting->site_name ?? 'ftech'))
@section('meta_description', Illuminate\Support\Str::limit(strip_tags($vehicle->description), 150))
@section('meta_image', $vehicle->thumbnail ? asset('storage/'.$vehicle->thumbnail) : '')

@section('content')
    <main class="mx-auto max-w-7xl px-6 py-12">
        @if (session('whatsapp'))
            <script>window.open(@json(session('whatsapp')), '_blank');</script>
        @endif
        @if (session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-sm font-semibold text-emerald-800 backdrop-blur-md">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-12 lg:grid-cols-[1.2fr_.8fr]">
            <!-- Gallery Component with Alpine.js -->
            <div x-data="{ activeImage: '{{ $vehicle->thumbnail ? asset('storage/'.$vehicle->thumbnail) : '' }}' }">
                <div class="aspect-[16/10] overflow-hidden rounded-3xl bg-slate-100 border border-slate-100 shadow-sm">
                    @if ($vehicle->thumbnail)
                        <img class="h-full w-full object-cover transition-all duration-300" :src="activeImage" alt="{{ $vehicle->title }}">
                    @else
                        <div class="flex h-full items-center justify-center text-slate-400">No Image Available</div>
                    @endif
                </div>
                
                @if($vehicle->gallery->count() > 0 || $vehicle->thumbnail)
                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @if($vehicle->thumbnail)
                            <button @click="activeImage = '{{ asset('storage/'.$vehicle->thumbnail) }}'" 
                                    :class="activeImage === '{{ asset('storage/'.$vehicle->thumbnail) }}' ? 'ring-2 ring-indigo-600 scale-95' : 'opacity-80 hover:opacity-100'" 
                                    class="aspect-video overflow-hidden rounded-xl border border-slate-200 bg-white transition-all duration-200">
                                <img class="h-full w-full object-cover" src="{{ asset('storage/'.$vehicle->thumbnail) }}">
                            </button>
                        @endif
                        @foreach ($vehicle->gallery as $item)
                            @php
                                $imgSrc = str_starts_with($item->file, 'http') ? $item->file : asset('storage/'.$item->file);
                            @endphp
                            <button @click="activeImage = '{{ $imgSrc }}'" 
                                    :class="activeImage === '{{ $imgSrc }}' ? 'ring-2 ring-indigo-600 scale-95' : 'opacity-80 hover:opacity-100'" 
                                    class="aspect-video overflow-hidden rounded-xl border border-slate-200 bg-white transition-all duration-200">
                                <img class="h-full w-full object-cover" src="{{ $imgSrc }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Vehicle Info & Form -->
            <div>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                    {{ $vehicle->category->name }} / {{ $vehicle->subcategory->name }}
                </span>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ $vehicle->title }}</h1>
                
                <div class="mt-6 flex items-baseline gap-3">
                    <span class="text-3xl font-extrabold text-orange-600">Rs {{ number_format($vehicle->discount_price ?: $vehicle->price ?: 0) }}</span>
                    @if ($vehicle->discount_price && $vehicle->price)
                        <span class="text-lg text-slate-400 line-through">Rs {{ number_format($vehicle->price) }}</span>
                    @endif
                </div>

                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 text-center shadow-sm">
                        <div class="text-xs font-medium text-slate-400">Manufacture Year</div>
                        <div class="mt-1 font-bold text-slate-800 text-lg">{{ $vehicle->manufacturer_year ?: 'N/A' }}</div>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 text-center shadow-sm">
                        <div class="text-xs font-medium text-slate-400">Fuel Type</div>
                        <div class="mt-1 font-bold text-slate-800 text-lg">{{ $vehicle->fuel_type ?: 'N/A' }}</div>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 text-center shadow-sm">
                        <div class="text-xs font-medium text-slate-400">Kilometers Driven</div>
                        <div class="mt-1 font-bold text-slate-800 text-lg">{{ $vehicle->km_driven ? number_format($vehicle->km_driven) : 'N/A' }}</div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-900">Description</h3>
                    <p class="mt-3 leading-relaxed text-slate-600 whitespace-pre-line text-sm">{{ $vehicle->description }}</p>
                </div>

                <form method="POST" action="{{ route('vehicles.enquiry', $vehicle) }}" class="mt-10 rounded-3xl border border-slate-100 bg-white p-6 shadow-md shadow-slate-100/50">
                    @csrf
                    <h3 class="text-lg font-bold text-slate-900">Get WhatsApp Enquiry</h3>
                    <p class="text-xs text-slate-400 mt-1">Submit your details to start a conversation directly on WhatsApp.</p>
                    <div class="mt-6 space-y-4">
                        <input name="name" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Your Name" required>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <input name="city" class="rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="City">
                            <input name="phone" class="rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Phone Number" required>
                        </div>
                        <textarea name="message" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Hi, I am interested in this vehicle."></textarea>
                        <button class="w-full rounded-xl bg-emerald-600 py-4 font-bold text-white shadow-lg shadow-emerald-600/10 transition-colors hover:bg-emerald-700">Send WhatsApp Enquiry</button>
                    </div>
                </form>
            </div>
        </div>

        @if($relatedVehicles->count() > 0)
            <section class="mt-20">
                <div class="border-b border-slate-100 pb-5">
                    <h2 class="text-2xl font-extrabold text-slate-900">Related Listings</h2>
                    <p class="mt-1 text-sm text-slate-500">Other vehicles you might be interested in</p>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedVehicles as $vehicle)
                        @include('front.partials.vehicle-card', ['vehicle' => $vehicle])
                    @endforeach
                </div>
            </section>
        @endif
    </main>
@endsection
