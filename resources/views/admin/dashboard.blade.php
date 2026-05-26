@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $cards = [
            ['label' => 'Total Vehicles', 'value' => \App\Models\Vehicle::count(), 'color' => 'from-blue-500 to-indigo-600', 'icon' => '🚗'],
            ['label' => 'Total Categories', 'value' => \App\Models\Category::count(), 'color' => 'from-emerald-400 to-teal-600', 'icon' => '📁'],
            ['label' => 'Total Enquiries', 'value' => \App\Models\Enquiry::count(), 'color' => 'from-violet-500 to-purple-600', 'icon' => '✉️'],
            ['label' => 'Featured Listings', 'value' => \App\Models\Vehicle::where('featured', true)->count(), 'color' => 'from-amber-400 to-orange-500', 'icon' => '✨'],
        ];
    @endphp
    
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="rounded-3xl bg-slate-900 p-8 text-white relative overflow-hidden shadow-lg shadow-slate-900/10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.15),transparent_45%)]"></div>
            <div class="relative">
                <h2 class="text-2xl font-extrabold">Welcome back to Admin Panel</h2>
                <p class="mt-2 text-sm text-slate-400">Here's a quick overview of what's happening on your vehicle listing marketplace.</p>
            </div>
        </div>

        <!-- Stat Cards Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($cards as $card)
                <div class="relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-400">{{ $card['label'] }}</div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-xl">{{ $card['icon'] }}</div>
                    </div>
                    <div class="mt-4 text-3xl font-black text-slate-900">{{ $card['value'] }}</div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r {{ $card['color'] }}"></div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
