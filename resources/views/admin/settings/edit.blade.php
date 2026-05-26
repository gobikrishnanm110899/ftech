@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">Settings</h2>
            <p class="text-xs text-slate-400 mt-1">Configure global application contact details, logos and social media parameters</p>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Site Name</label>
                    <input name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., Ftech Vehicles" required>
                </div>

                <div class="space-y-1.5" x-data="{ imageUrl: '{{ $setting->logo ? asset('storage/'.$setting->logo) : '' }}' }">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Logo File</label>
                    <input type="file" name="logo" @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }" class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm outline-none bg-slate-50 transition-all focus:border-indigo-600">
                    <input type="hidden" name="existing_logo" value="{{ $setting->logo }}">
                    
                    <div class="mt-3 flex items-center gap-4">
                        <template x-if="imageUrl">
                            <div class="relative h-16 w-16 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-inner">
                                <img :src="imageUrl" class="h-full w-full object-cover">
                            </div>
                        </template>
                        <template x-if="!imageUrl">
                            <div class="flex h-16 w-16 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                No Logo
                            </div>
                        </template>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">WhatsApp Contact Phone</label>
                    <input name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., +919080706050">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Email Address</label>
                    <input name="email" value="{{ old('email', $setting->email) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="e.g., support@ftech.com">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Physical Office Address</label>
                <textarea name="address" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="Street name, City, State details">{{ old('address', $setting->address) }}</textarea>
            </div>

            <div class="border-t border-slate-50 pt-5 space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Social Channel URLs</h3>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Facebook Link</label>
                        <input name="facebook" value="{{ old('facebook', $setting->facebook) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="https://facebook.com/yourpage">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Instagram Link</label>
                        <input name="instagram" value="{{ old('instagram', $setting->instagram) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="https://instagram.com/yourprofile">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">YouTube Link</label>
                        <input name="youtube" value="{{ old('youtube', $setting->youtube) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="https://youtube.com/yourchannel">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Telegram Link</label>
                        <input name="telegram" value="{{ old('telegram', $setting->telegram) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition-all focus:border-indigo-600" placeholder="https://t.me/yourgroup">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-50">
                <button class="rounded-xl bg-indigo-600 px-6 py-3.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Save Global Settings</button>
            </div>
        </form>
    </div>
@endsection
