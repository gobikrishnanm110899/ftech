@extends('admin.layouts.app')

@section('title', $subcategory->exists ? 'Edit Subcategory' : 'Add Subcategory')

@section('content')
    <div class="max-w-xl rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">{{ $subcategory->exists ? 'Edit Subcategory' : 'Create Subcategory' }}</h2>
            <p class="text-xs text-slate-400 mt-1">Configure details for subcategory (brand)</p>
        </div>

        <form class="mt-6 space-y-5" method="POST" action="{{ $subcategory->exists ? route('admin.subcategories.update', $subcategory) : route('admin.subcategories.store') }}">
            @csrf
            @if ($subcategory->exists) @method('PUT') @endif
            
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Parent Category</label>
                <select name="category_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600" required>
                    <option value="">Select Parent Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $subcategory->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Brand/Subcategory Name</label>
                <input name="name" value="{{ old('name', $subcategory->name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Hyundai, Honda" required>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">URL Slug (Optional)</label>
                <input name="slug" value="{{ old('slug', $subcategory->slug) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., hyundai-brand">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Brand Logo or Text (Optional)</label>
                <input name="logo" value="{{ old('logo', $subcategory->logo) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Logo path or info">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="status" id="status" value="1" @checked(old('status', $subcategory->status ?? true)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                <label for="status" class="text-sm font-semibold text-slate-700">Publish this brand subcategory (Active)</label>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button class="rounded-xl bg-indigo-600 px-5 py-3 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Brand</button>
                <a href="{{ route('admin.subcategories.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
