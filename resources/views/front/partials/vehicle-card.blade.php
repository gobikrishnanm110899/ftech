<article class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-100/80">
    <a href="{{ route('vehicle.show', [$vehicle->category->slug, $vehicle->subcategory->slug, $vehicle->slug]) }}" class="block overflow-hidden aspect-[4/3] bg-slate-50 relative">
        @if ($vehicle->thumbnail)
            <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$vehicle->thumbnail) }}" alt="{{ $vehicle->title }}" loading="lazy">
        @else
            <div class="flex h-full items-center justify-center text-xs font-medium text-slate-400">No Image Available</div>
        @endif
        <span class="absolute top-3 left-3 rounded-full bg-slate-900/70 backdrop-blur-md px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-white">
            {{ $vehicle->category->name }}
        </span>
    </a>
    
    <div class="p-5">
        <a href="{{ route('vehicle.show', [$vehicle->category->slug, $vehicle->subcategory->slug, $vehicle->slug]) }}" class="block font-bold text-slate-900 transition-colors group-hover:text-indigo-600 line-clamp-1">
            {{ $vehicle->title }}
        </a>
        
        <div class="mt-2 flex items-baseline gap-2">
            @if ($vehicle->discount_price)
                <span class="text-lg font-extrabold text-orange-600">Rs {{ number_format($vehicle->discount_price) }}</span>
                <span class="text-xs text-slate-400 line-through">Rs {{ number_format($vehicle->price) }}</span>
            @elseif ($vehicle->price)
                <span class="text-lg font-extrabold text-slate-900">Rs {{ number_format($vehicle->price) }}</span>
            @else
                <span class="text-sm font-semibold text-slate-500">Contact for Price</span>
            @endif
        </div>
        
        <div class="mt-4 flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-1 rounded-md bg-slate-50 px-2 py-1 text-[11px] font-semibold text-slate-600">
                📅 {{ $vehicle->manufacturer_year ?: 'N/A' }}
            </span>
            <span class="inline-flex items-center gap-1 rounded-md bg-slate-50 px-2 py-1 text-[11px] font-semibold text-slate-600">
                🏷️ {{ $vehicle->subcategory->name ?? 'Brand' }}
            </span>
            <span class="inline-flex items-center gap-1 rounded-md bg-slate-50 px-2 py-1 text-[11px] font-semibold text-slate-600">
                ⚡ {{ $vehicle->fuel_type ?: 'N/A' }}
            </span>
        </div>
    </div>
</article>

