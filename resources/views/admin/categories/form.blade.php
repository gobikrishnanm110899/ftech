@extends('admin.layouts.app')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
    <div class="max-w-xl rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">{{ $category->exists ? 'Edit Category' : 'Create Category' }}</h2>
            <p class="text-xs text-slate-400 mt-1">Configure details for parent category</p>
        </div>

        <form class="mt-6 space-y-5" method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($category->exists) @method('PUT') @endif
            
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category Name</label>
                <input name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Cars, Bikes" required>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">URL Slug (Optional)</label>
                <input name="slug" value="{{ old('slug', $category->slug) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., cars-listing">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category Icon (Emoji/Unicode)</label>
                <input name="icon" value="{{ old('icon', $category->icon) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 🚗, 🏍️">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="status" id="status" value="1" @checked(old('status', $category->status ?? true)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                <label for="status" class="text-sm font-semibold text-slate-700">Publish this category (Active)</label>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button class="rounded-xl bg-indigo-600 px-5 py-3 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Category</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
