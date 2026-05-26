@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    isEdit: false, 
    actionUrl: '{{ route('admin.categories.store') }}',
    name: '',
    slug: '',
    icon: '',
    status: true,
    
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.categories.store') }}';
        this.name = '';
        this.slug = '';
        this.icon = '';
        this.status = true;
        this.modalOpen = true;
    },
    openEdit(category) {
        this.isEdit = true;
        this.actionUrl = '/admin/categories/' + category.id;
        this.name = category.name;
        this.slug = category.slug;
        this.icon = category.icon;
        this.status = !!category.status;
        this.modalOpen = true;
    }
}">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="flex items-center justify-between border-b border-slate-50 pb-5">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Categories</h2>
                <p class="text-xs text-slate-400 mt-1">Manage parent categories for vehicle listings</p>
            </div>
            <button @click="openCreate()" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">
                ➕ Add Category
            </button>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-3 font-semibold">Name</th>
                        <th class="pb-3 font-semibold">Slug</th>
                        <th class="pb-3 font-semibold text-center">Listings</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 font-semibold text-slate-900">
                                <span class="mr-2 text-base">{{ $category->icon ?: '🚗' }}</span>
                                {{ $category->name }}
                            </td>
                            <td class="py-4 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="py-4 text-center font-bold text-slate-700">{{ $category->vehicles_count }}</td>
                            <td class="py-4">
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $category->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="openEdit({ id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', slug: '{{ addslashes($category->slug) }}', icon: '{{ addslashes($category->icon) }}', status: {{ $category->status ? 1 : 0 }} })" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Edit</button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
        <div class="mt-6 border-t border-slate-50 pt-4">{{ $categories->links() }}</div>
    </div>

    <!-- Category Form Modal Overlay -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm" style="display: none;">
        <!-- Modal Container -->
        <div @click.away="modalOpen = false" class="w-full max-w-md rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl transition-all">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-slate-900" x-text="isEdit ? 'Edit Category' : 'Create Category'"></h3>
                <p class="text-xs text-slate-400 mt-1">Configure details for parent category</p>
            </div>
            
            <form class="mt-6 space-y-4" method="POST" :action="actionUrl">
                @csrf
                <input type="hidden" name="_method" value="PUT" x-bind:disabled="!isEdit">
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category Name</label>
                    <input name="name" x-model="name" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Cars, Bikes" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">URL Slug (Optional)</label>
                    <input name="slug" x-model="slug" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., cars-listing">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category Icon (Emoji/Unicode)</label>
                    <input name="icon" x-model="icon" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., 🚗, 🏍️">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="status" id="status" value="1" x-model="status" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="status" class="text-sm font-semibold text-slate-700">Publish this category (Active)</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
