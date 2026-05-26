@extends('admin.layouts.app')

@section('title', 'Vehicles')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="flex items-center justify-between border-b border-slate-50 pb-5">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Vehicles</h2>
                <p class="text-xs text-slate-400 mt-1">Manage active listings and detailed specifications</p>
            </div>
            <a class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700" href="{{ route('admin.vehicles.create') }}">
                ➕ Add Vehicle
            </a>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-3 font-semibold">Vehicle</th>
                        <th class="pb-3 font-semibold">Category/Brand</th>
                        <th class="pb-3 font-semibold text-right">Price</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($vehicles as $vehicle)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4">
                                <div class="font-bold text-slate-900">{{ $vehicle->title }}</div>
                                @if($vehicle->featured)
                                    <span class="inline-flex items-center rounded bg-amber-50 px-1.5 py-0.5 text-[10px] font-bold text-amber-800 uppercase tracking-wide">⭐ Featured</span>
                                @endif
                            </td>
                            <td class="py-4 text-xs font-medium text-slate-500">
                                <span class="rounded bg-slate-100 px-2 py-1">{{ $vehicle->category->name }}</span>
                                <span class="text-slate-300">/</span>
                                <span class="rounded bg-slate-50 px-2 py-1 border border-slate-100">{{ $vehicle->subcategory->name }}</span>
                            </td>
                            <td class="py-4 text-right font-extrabold text-slate-900">
                                Rs {{ number_format($vehicle->discount_price ?: $vehicle->price ?: 0) }}
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $vehicle->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $vehicle->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors" href="{{ route('admin.vehicles.gallery', $vehicle) }}">🖼️ Gallery</a>
                                    <a class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors" href="{{ route('admin.vehicles.edit', $vehicle) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Are you sure you want to delete this vehicle listing?')">
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
        <div class="mt-6 border-t border-slate-50 pt-4">{{ $vehicles->links() }}</div>
    </div>
@endsection
