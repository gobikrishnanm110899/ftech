<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        return view('admin.vehicles.index', [
            'vehicles' => Vehicle::with(['category', 'subcategory'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.vehicles.form', $this->formData(new Vehicle()));
    }

    public function store(Request $request): RedirectResponse
    {
        Vehicle::create($this->validated($request));

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle created.');
    }

    public function edit(Vehicle $vehicle): View
    {
        return view('admin.vehicles.form', $this->formData($vehicle));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update($this->validated($request, $vehicle));

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->thumbnail) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($vehicle->thumbnail);
        }

        foreach ($vehicle->gallery as $item) {
            if ($item->type === 'image' && $item->file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->file);
            }
        }

        $vehicle->delete();

        return back()->with('success', 'Vehicle deleted.');
    }

    private function formData(Vehicle $vehicle): array
    {
        return [
            'vehicle' => $vehicle,
            'categories' => Category::where('status', true)->get(),
            'subcategories' => Subcategory::where('status', true)->with('category')->get(),
        ];
    }

    private function validated(Request $request, Vehicle $vehicle = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200'],
            'price' => ['nullable', 'integer', 'min:0'],
            'discount_price' => ['nullable', 'integer', 'min:0'],
            'manufacturer_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'fuel_type' => ['nullable', 'string', 'max:60'],
            'km_driven' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'max:4096'],
            'existing_thumbnail' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($vehicle && $vehicle->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($vehicle->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('vehicles/thumbnails', 'public');
        } else {
            $data['thumbnail'] = $data['existing_thumbnail'] ?? null;
        }

        unset($data['existing_thumbnail']);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['featured'] = $request->boolean('featured');
        $data['status'] = $request->boolean('status');

        return $data;
    }
}
