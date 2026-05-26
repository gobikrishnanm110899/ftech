@extends('layouts.app')

@section('content')
    <main class="mx-auto max-w-5xl p-6">
        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-2xl font-semibold">ftech</h1>
            <p class="mt-2 text-slate-600">Vehicle Marketplace (Laravel + Livewire + Tailwind CDN)</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-sm font-medium">Next</div>
                    <ul class="mt-2 list-disc pl-5 text-sm text-slate-600">
                        <li>Admin panel</li>
                        <li>Categories / Subcategories</li>
                        <li>Vehicles + Gallery</li>
                    </ul>
                </div>
                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-sm font-medium">Database</div>
                    <p class="mt-2 text-sm text-slate-600">Migrations are ready for MySQL.</p>
                </div>
            </div>
        </div>
    </main>
@endsection

