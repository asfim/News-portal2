<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the media assets.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Media::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('caption', 'like', "%{$search}%")
                  ->orWhere('copyright', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate(24)->withQueryString();

        // AJAX request for editor / select popup
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.media.partials.grid', compact('media'))->render(),
                'pagination' => view('admin.media.partials.pagination', compact('media'))->render(),
            ]);
        }

        return view('admin.media.index', compact('media'));
    }

    /**
     * Store a newly uploaded media asset in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,webm,avi,mov,mkv|max:51200', // max 50MB overall
        ]);

        $uploadedMedia = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Custom validation: Images max 10MB, Videos max 50MB
                $isImage = str_starts_with($file->getMimeType(), 'image/');
                if ($isImage && $file->getSize() > 10240 * 1024) {
                    return response()->json(['success' => false, 'message' => 'Image size cannot exceed 10MB.']);
                }

                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('media', $filename, 'public');

                $media = Media::create([
                    'name' => pathinfo($originalName, PATHINFO_FILENAME),
                    'filename' => $filename,
                    'path' => '/storage/' . $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'alt_text' => pathinfo($originalName, PATHINFO_FILENAME),
                    'caption' => null,
                    'copyright' => null,
                    'uploaded_by' => auth()->id(),
                ]);

                $uploadedMedia[] = $media;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'media' => $uploadedMedia,
                'message' => 'Images uploaded successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    /**
     * Update the details of the specified media asset.
     */
    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'copyright' => 'nullable|string|max:255',
        ]);

        $medium->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'media' => $medium,
                'message' => 'Media details updated.'
            ]);
        }

        return redirect()->back()->with('success', 'Media details updated.');
    }

    /**
     * Remove the specified media asset from storage.
     */
    public function destroy(Media $medium)
    {
        $relativePath = str_replace('/storage/', '', $medium->path);
        
        // Delete physical file
        Storage::disk('public')->delete($relativePath);
        
        // Delete DB record
        $medium->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Media asset deleted successfully.');
    }
}
