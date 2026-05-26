@extends('admin.layouts.app')

@section('title', $vehicle->exists ? 'Edit Vehicle' : 'Add Vehicle')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">{{ $vehicle->exists ? 'Edit Vehicle listing' : 'Create Vehicle listing' }}</h2>
            <p class="text-xs text-slate-400 mt-1">Configure detailed features, pricing and images for vehicle</p>
        </div>

        <form class="mt-6 space-y-6" method="POST" enctype="multipart/form-data" action="{{ $vehicle->exists ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}">
            @csrf
            @if ($vehicle->exists) @method('PUT') @endif
            
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category</label>
                    <select name="category_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $vehicle->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Brand Subcategory</label>
                    <select name="subcategory_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600" required>
                        <option value="">Select Brand</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" @selected(old('subcategory_id', $vehicle->subcategory_id) == $subcategory->id)>{{ $subcategory->category->name }} - {{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Vehicle Title</label>
                    <input name="title" value="{{ old('title', $vehicle->title) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Hyundai i20 Asta 2022" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">URL Slug (Optional)</label>
                    <input name="slug" value="{{ old('slug', $vehicle->slug) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., hyundai-i20-asta">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Price (Rs)</label>
                    <input name="price" value="{{ old('price', $vehicle->price) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 780000">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Discount Price (Rs) (Optional)</label>
                    <input name="discount_price" value="{{ old('discount_price', $vehicle->discount_price) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 720000">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Manufacturing Year</label>
                    <input name="manufacturer_year" value="{{ old('manufacturer_year', $vehicle->manufacturer_year) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 2022">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Fuel Type</label>
                    <input name="fuel_type" value="{{ old('fuel_type', $vehicle->fuel_type) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Petrol, Diesel, CNG, Electric">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">KM Driven</label>
                    <input name="km_driven" value="{{ old('km_driven', $vehicle->km_driven) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 45000">
                </div>

                <div class="space-y-1.5" x-data="{ imageUrl: '{{ $vehicle->thumbnail ? asset('storage/'.$vehicle->thumbnail) : '' }}' }">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Thumbnail Image</label>
                    <input type="file" name="thumbnail" @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }" class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm outline-none bg-slate-50 transition-all focus:border-indigo-600">
                    
                    <div class="mt-3 flex items-center gap-4">
                        <template x-if="imageUrl">
                            <div class="relative h-20 w-32 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-inner">
                                <img :src="imageUrl" class="h-full w-full object-cover">
                            </div>
                        </template>
                        <template x-if="!imageUrl">
                            <div class="flex h-20 w-32 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                No Preview
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="existing_thumbnail" value="{{ $vehicle->thumbnail }}">

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Description Details</label>
                <textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Describe the vehicle conditions, features, ownership details...">{{ old('description', $vehicle->description) }}</textarea>
            </div>

            <div class="flex gap-6">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="featured" id="featured" value="1" @checked(old('featured', $vehicle->featured)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="featured" class="text-sm font-semibold text-slate-700">Feature this listing (Featured)</label>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="status" id="status" value="1" @checked(old('status', $vehicle->status ?? true)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="status" class="text-sm font-semibold text-slate-700">Publish this listing (Active)</label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-50">
                <button class="rounded-xl bg-indigo-600 px-6 py-3.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Vehicle Listing</button>
                <a href="{{ route('admin.vehicles.index') }}" class="rounded-xl border border-slate-200 px-6 py-3.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
