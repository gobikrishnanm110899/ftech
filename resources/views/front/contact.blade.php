@extends('front.layout')

@section('title', 'Contact')

@section('content')
    <main class="mx-auto grid max-w-7xl gap-12 px-6 py-12 lg:grid-cols-2">
        <section class="space-y-6">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold tracking-wide text-indigo-600">
                    📍 Get In Touch
                </span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 select-none">Contact Us</h1>
                <p class="mt-2 text-slate-500 text-sm">Have any questions? We'd love to hear from you. Get in touch with us using the details below or send a message.</p>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                    <span class="text-2xl">💬</span>
                    <div>
                        <div class="text-xs font-semibold text-slate-400">WhatsApp</div>
                        <div class="text-sm font-bold text-slate-800">{{ $setting->whatsapp_number ?: 'Not set' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                    <span class="text-2xl">✉️</span>
                    <div>
                        <div class="text-xs font-semibold text-slate-400">Email Address</div>
                        <div class="text-sm font-bold text-slate-800">{{ $setting->email ?: 'Not set' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                    <span class="text-2xl">📍</span>
                    <div>
                        <div class="text-xs font-semibold text-slate-400">Office Location</div>
                        <div class="text-sm font-bold text-slate-800">{{ $setting->address ?: 'Not set' }}</div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-md shadow-slate-100/50">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-sm font-semibold text-emerald-800 backdrop-blur-md">
                    ✨ {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                @csrf
                <input name="name" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Your Name" required>
                <input name="phone" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Phone Number" required>
                <textarea name="message" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Your Message" required></textarea>
                <button class="w-full rounded-xl bg-indigo-600 py-4 font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Submit Message</button>
            </form>
        </section>
    </main>
@endsection
