<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.subcategories.index', [
            'subcategories' => Subcategory::with('category')->withCount('vehicles')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.subcategories.form', [
            'subcategory' => new Subcategory(),
            'categories' => Category::where('status', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Subcategory::create($this->validated($request));

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created.');
    }

    public function edit(Subcategory $subcategory): View
    {
        return view('admin.subcategories.form', [
            'subcategory' => $subcategory,
            'categories' => Category::where('status', true)->get(),
        ]);
    }

    public function update(Request $request, Subcategory $subcategory): RedirectResponse
    {
        $subcategory->update($this->validated($request));

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated.');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $subcategory->delete();

        return back()->with('success', 'Subcategory deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140'],
            'logo' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}
