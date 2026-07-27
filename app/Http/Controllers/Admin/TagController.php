<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Tag::orderBy('name', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $tags = $query->paginate(15)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Tag $tag)
    {
        $tag->status = !$tag->status;
        $tag->save();

        return response()->json([
            'success' => true,
            'status' => $tag->status,
            'message' => 'Tag status updated successfully.'
        ]);
    }
}
