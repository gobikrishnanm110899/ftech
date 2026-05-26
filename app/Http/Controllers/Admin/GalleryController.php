<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function edit(Vehicle $vehicle): View
    {
        return view('admin.gallery.edit', ['vehicle' => $vehicle->load('gallery')]);
    }

    public function store(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $request->validate([
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:20480'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $hasImages = $request->hasFile('files');
        $hasVideo = $request->filled('video_url');

        if (!$hasImages && !$hasVideo) {
            return back()->withErrors(['files' => 'Please select at least one image file or enter a video URL.']);
        }

        if ($hasVideo) {
            $vehicle->gallery()->create([
                'file' => $request->input('video_url'),
                'type' => 'video',
                'sort_order' => $request->input('sort_order') ?? 0,
            ]);
        }

        if ($hasImages) {
            foreach ($request->file('files') as $uploadedFile) {
                $filePath = $uploadedFile->store('vehicles/gallery', 'public');
                $vehicle->gallery()->create([
                    'file' => $filePath,
                    'type' => 'image',
                    'sort_order' => $request->input('sort_order') ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Gallery item(s) added successfully.');
    }

    public function destroy(VehicleGallery $gallery): RedirectResponse
    {
        if ($gallery->type === 'image' && $gallery->file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->file);
        }

        $gallery->delete();

        return back()->with('success', 'Gallery item deleted.');
    }
}
