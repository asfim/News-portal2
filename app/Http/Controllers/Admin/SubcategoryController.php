<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubcategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Category::whereNotNull('parent_id')->with('parent')->orderBy('sort_order', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $subcategories = $query->paginate(15)->withQueryString();

        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('admin.subcategories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(SubcategoryRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('categories', 'public');
            $data['image'] = '/storage/' . $path;
        }

        Category::create($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit($id)
    {
        $subcategory = Category::whereNotNull('parent_id')->findOrFail($id);
        $parentCategories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();

        return view('admin.subcategories.edit', compact('subcategory', 'parentCategories'));
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(SubcategoryRequest $request, $id)
    {
        $subcategory = Category::whereNotNull('parent_id')->findOrFail($id);
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image_upload')) {
            if ($subcategory->image) {
                $oldPath = str_replace('/storage/', '', $subcategory->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image_upload')->store('categories', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy($id)
    {
        $subcategory = Category::whereNotNull('parent_id')->findOrFail($id);

        if ($subcategory->image) {
            $oldPath = str_replace('/storage/', '', $subcategory->image);
            Storage::disk('public')->delete($oldPath);
        }

        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus($id)
    {
        $subcategory = Category::whereNotNull('parent_id')->findOrFail($id);
        $subcategory->status = !$subcategory->status;
        $subcategory->save();

        return response()->json([
            'success' => true,
            'status' => $subcategory->status,
            'message' => 'Subcategory status updated.'
        ]);
    }
}
