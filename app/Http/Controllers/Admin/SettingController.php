<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['setting' => Setting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'existing_logo' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'facebook' => ['nullable', 'url', 'max:500'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'youtube' => ['nullable', 'url', 'max:500'],
            'telegram' => ['nullable', 'url', 'max:500'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $setting = Setting::current();

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        } else {
            $data['logo'] = $data['existing_logo'] ?? null;
        }

        unset($data['existing_logo']);
        $setting->update($data);

        return back()->with('success', 'Settings updated.');
    }
}
