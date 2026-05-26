<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('front.home', [
            'setting' => Setting::current(),
            'categories' => Category::where('status', true)->withCount('vehicles')->get(),
            'featuredVehicles' => Vehicle::where('status', true)->where('featured', true)->with(['category', 'subcategory'])->latest()->take(6)->get(),
            'latestVehicles' => Vehicle::where('status', true)->with(['category', 'subcategory'])->latest()->take(8)->get(),
            'brands' => Subcategory::where('status', true)->with('category')->latest()->take(12)->get(),
        ]);
    }

    public function category(Category $category): View
    {
        abort_unless($category->status, 404);

        return view('front.category', [
            'setting' => Setting::current(),
            'category' => $category,
            'subcategories' => $category->subcategories()->where('status', true)->withCount('vehicles')->get(),
            'vehicles' => $category->vehicles()->where('status', true)->with(['category', 'subcategory'])->latest()->paginate(12),
        ]);
    }

    public function subcategory(Category $category, Subcategory $subcategory): View
    {
        abort_unless($category->status && $subcategory->status && $subcategory->category_id === $category->id, 404);

        return view('front.subcategory', [
            'setting' => Setting::current(),
            'category' => $category,
            'subcategory' => $subcategory,
            'vehicles' => $subcategory->vehicles()->where('status', true)->with(['category', 'subcategory'])->latest()->paginate(12),
        ]);
    }

    public function vehicle(Category $category, Subcategory $subcategory, Vehicle $vehicle): View
    {
        abort_unless(
            $category->status &&
            $subcategory->status &&
            $vehicle->status &&
            $subcategory->category_id === $category->id &&
            $vehicle->category_id === $category->id &&
            $vehicle->subcategory_id === $subcategory->id,
            404
        );

        $related = Vehicle::where('status', true)
            ->where('id', '!=', $vehicle->id)
            ->where(function ($query) use ($vehicle) {
                $query->where('subcategory_id', $vehicle->subcategory_id)
                    ->orWhere('category_id', $vehicle->category_id);
            })
            ->with(['category', 'subcategory'])
            ->take(4)
            ->get();

        return view('front.vehicle', [
            'setting' => Setting::current(),
            'vehicle' => $vehicle->load(['category', 'subcategory', 'gallery']),
            'relatedVehicles' => $related,
        ]);
    }

    public function search(Request $request): View
    {
        $queryText = trim((string) $request->query('q'));

        $vehicles = Vehicle::where('status', true)
            ->with(['category', 'subcategory'])
            ->when($queryText, function ($query) use ($queryText) {
                $query->where(function ($search) use ($queryText) {
                    $search->where('title', 'like', "%{$queryText}%")
                        ->orWhere('manufacturer_year', 'like', "%{$queryText}%")
                        ->orWhereHas('category', fn ($category) => $category->where('name', 'like', "%{$queryText}%"))
                        ->orWhereHas('subcategory', fn ($subcategory) => $subcategory->where('name', 'like', "%{$queryText}%"));
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('subcategory_id'), fn ($query) => $query->where('subcategory_id', $request->integer('subcategory_id')))
            ->when($request->filled('fuel_type'), fn ($query) => $query->where('fuel_type', $request->query('fuel_type')))
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->integer('min_price')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->integer('max_price')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('front.search', [
            'setting' => Setting::current(),
            'vehicles' => $vehicles,
            'categories' => Category::where('status', true)->get(),
            'subcategories' => Subcategory::where('status', true)->get(),
            'queryText' => $queryText,
        ]);
    }

    public function contact(): View
    {
        return view('front.contact', ['setting' => Setting::current()]);
    }

    public function enquiry(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['vehicle_id'] = $vehicle->id;
        Enquiry::create($data);

        $setting = Setting::current();
        $message = "Vehicle Enquiry\n\nVehicle:\n{$vehicle->title}\n\nName:\n{$data['name']}\n\nCity:\n".($data['city'] ?? '-')."\n\nPhone:\n{$data['phone']}\n\nLink:\n".URL::previous();
        $whatsapp = $setting->whatsapp_number ? 'https://wa.me/'.preg_replace('/\D+/', '', $setting->whatsapp_number).'?text='.rawurlencode($message) : null;

        return back()->with('success', 'Enquiry saved successfully.')->with('whatsapp', $whatsapp);
    }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        Enquiry::create($data);

        return back()->with('success', 'Your message has been received.');
    }
}
