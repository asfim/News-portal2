<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorRequest;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the authors.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Author::with('user')->orderBy('name', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $authors = $query->paginate(15)->withQueryString();

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new author.
     */
    public function create()
    {
        // Load users who are not already linked to an author profile
        $users = User::whereDoesntHave('author')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.authors.create', compact('users'));
    }

    /**
     * Store a newly created author in storage.
     */
    public function store(AuthorRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('profile_photo_upload')) {
            $path = $request->file('profile_photo_upload')->store('authors', 'public');
            $data['profile_photo'] = '/storage/' . $path;
        }

        Author::create($data);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author profile created successfully.');
    }

    /**
     * Show the form for editing the specified author.
     */
    public function edit(Author $author)
    {
        // Load users who don't have an author profile or are already linked to this author
        $users = User::where(function ($query) use ($author) {
            $query->whereDoesntHave('author')
                  ->orWhere('id', $author->user_id);
        })
        ->orderBy('name', 'asc')
        ->get();

        return view('admin.authors.edit', compact('author', 'users'));
    }

    /**
     * Update the specified author in storage.
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('profile_photo_upload')) {
            // Delete old photo if exists
            if ($author->profile_photo) {
                $oldPath = str_replace('/storage/', '', $author->profile_photo);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('profile_photo_upload')->store('authors', 'public');
            $data['profile_photo'] = '/storage/' . $path;
        }

        $author->update($data);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author profile updated successfully.');
    }

    /**
     * Remove the specified author from storage.
     */
    public function destroy(Author $author)
    {
        // Delete profile photo file
        if ($author->profile_photo) {
            $oldPath = str_replace('/storage/', '', $author->profile_photo);
            Storage::disk('public')->delete($oldPath);
        }

        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author profile deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Author $author)
    {
        $author->status = !$author->status;
        $author->save();

        return response()->json([
            'success' => true,
            'status' => $author->status,
            'message' => 'Author status updated successfully.'
        ]);
    }
}
