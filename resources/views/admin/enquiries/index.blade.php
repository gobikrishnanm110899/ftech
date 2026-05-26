@extends('admin.layouts.app')

@section('title', 'Enquiries')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">Enquiries</h2>
            <p class="text-xs text-slate-400 mt-1">Review contact requests and vehicle purchase enquiries</p>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-3 font-semibold">User Details</th>
                        <th class="pb-3 font-semibold">Phone</th>
                        <th class="pb-3 font-semibold">Vehicle Target</th>
                        <th class="pb-3 font-semibold">Message</th>
                        <th class="pb-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($enquiries as $enquiry)
                        <tr class="hover:bg-slate-50/40 transition-colors align-top">
                            <td class="py-4">
                                <div class="font-bold text-slate-900">{{ $enquiry->name }}</div>
                                <div class="text-[11px] font-semibold text-slate-400">📍 {{ $enquiry->city ?: 'Unknown Location' }}</div>
                            </td>
                            <td class="py-4 font-mono text-xs text-slate-700">{{ $enquiry->phone }}</td>
                            <td class="py-4 text-xs font-semibold text-slate-800">
                                @if($enquiry->vehicle)
                                    <span class="rounded bg-indigo-50 px-2.5 py-1 text-indigo-700">{{ $enquiry->vehicle->title }}</span>
                                @else
                                    <span class="rounded bg-slate-100 px-2.5 py-1 text-slate-600">General Contact</span>
                                @endif
                            </td>
                            <td class="py-4 text-xs text-slate-600 max-w-xs truncate">{{ $enquiry->message }}</td>
                            <td class="py-4 text-right">
                                <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" onsubmit="return confirm('Are you sure you want to remove this enquiry?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-100 px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 border-t border-slate-50 pt-4">{{ $enquiries->links() }}</div>
    </div>
@endsection
