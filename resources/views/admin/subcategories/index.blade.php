@extends('admin.layouts.app')

@section('title', 'Subcategories')

@section('content')
@php
    $categoriesList = \App\Models\Category::orderBy('name')->get();
@endphp

<div x-data="{ 
    modalOpen: false, 
    isEdit: false, 
    actionUrl: '{{ route('admin.subcategories.store') }}',
    categoryId: '',
    name: '',
    slug: '',
    logo: '',
    status: true,
    
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.subcategories.store') }}';
        this.categoryId = '';
        this.name = '';
        this.slug = '';
        this.logo = '';
        this.status = true;
        this.modalOpen = true;
    },
    openEdit(subcat) {
        this.isEdit = true;
        this.actionUrl = '/admin/subcategories/' + subcat.id;
        this.categoryId = subcat.category_id;
        this.name = subcat.name;
        this.slug = subcat.slug;
        this.logo = subcat.logo;
        this.status = !!subcat.status;
        this.modalOpen = true;
    }
}">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="flex items-center justify-between border-b border-slate-50 pb-5">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Subcategories (Brands)</h2>
                <p class="text-xs text-slate-400 mt-1">Manage brand labels linked under parent categories</p>
            </div>
            <button @click="openCreate()" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">
                ➕ Add Subcategory
            </button>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-3 font-semibold">Brand Name</th>
                        <th class="pb-3 font-semibold">Category</th>
                        <th class="pb-3 font-semibold text-center">Listings</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($subcategories as $subcategory)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 font-semibold text-slate-900">{{ $subcategory->name }}</td>
                            <td class="py-4 text-xs font-medium text-slate-500">
                                <span class="rounded bg-slate-100 px-2 py-1">{{ $subcategory->category->name }}</span>
                            </td>
                            <td class="py-4 text-center font-bold text-slate-700">{{ $subcategory->vehicles_count }}</td>
                            <td class="py-4">
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $subcategory->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $subcategory->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="openEdit({ id: {{ $subcategory->id }}, category_id: {{ $subcategory->category_id }}, name: '{{ addslashes($subcategory->name) }}', slug: '{{ addslashes($subcategory->slug) }}', logo: '{{ addslashes($subcategory->logo) }}', status: {{ $subcategory->status ? 1 : 0 }} })" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Edit</button>
                                    <form method="POST" action="{{ route('admin.subcategories.destroy', $subcategory) }}" onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-100 px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 border-t border-slate-50 pt-4">{{ $subcategories->links() }}</div>
    </div>

    <!-- Subcategory Form Modal Overlay -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm" style="display: none;">
        <!-- Modal Container -->
        <div @click.away="modalOpen = false" class="w-full max-w-md rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl transition-all">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-slate-900" x-text="isEdit ? 'Edit Subcategory' : 'Create Subcategory'"></h3>
                <p class="text-xs text-slate-400 mt-1">Configure details for brand/subcategory</p>
            </div>
            
            <form class="mt-6 space-y-4" method="POST" :action="actionUrl">
                @csrf
                <input type="hidden" name="_method" value="PUT" x-bind:disabled="!isEdit">
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Parent Category</label>
                    <select name="category_id" x-model="categoryId" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none bg-white transition-all focus:border-indigo-600" required>
                        <option value="">Select Parent Category</option>
                        @foreach ($categoriesList as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Brand Name</label>
                    <input name="name" x-model="name" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Hyundai, Honda" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">URL Slug (Optional)</label>
                    <input name="slug" x-model="slug" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., hyundai-brand">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Logo Reference (Optional)</label>
                    <input name="logo" x-model="logo" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Logo info">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="status" id="status" value="1" x-model="status" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="status" class="text-sm font-semibold text-slate-700">Publish this brand subcategory (Active)</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Subcategory</button>
                </div>
            </form>
        </div>
</div>
@endsection
