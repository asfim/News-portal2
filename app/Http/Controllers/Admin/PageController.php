<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Page::orderBy('title', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(PageRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Static page created successfully.');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Static page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Static page deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Page $page)
    {
        $page->status = !$page->status;
        $page->save();

        return response()->json([
            'success' => true,
            'status' => $page->status,
            'message' => 'Page status updated successfully.'
        ]);
    }
}
