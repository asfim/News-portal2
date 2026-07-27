<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the advertisements.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Advertisement::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('placement_key', 'like', "%{$search}%");
            });
        }

        $advertisements = $query->paginate(15)->withQueryString();

        return view('admin.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new advertisement.
     */
    public function create()
    {
        return view('admin.advertisements.create');
    }

    /**
     * Store a newly created advertisement in storage.
     */
    public function store(AdvertisementRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('advertisements', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        Advertisement::create($data);

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement campaign created successfully.');
    }

    /**
     * Show the form for editing the specified advertisement.
     */
    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    /**
     * Update the specified advertisement in storage.
     */
    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image_upload')) {
            // Delete old banner
            if ($advertisement->image_path) {
                $oldPath = str_replace('/storage/', '', $advertisement->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image_upload')->store('advertisements', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $advertisement->update($data);

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement campaign updated successfully.');
    }

    /**
     * Remove the specified advertisement from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image_path) {
            $oldPath = str_replace('/storage/', '', $advertisement->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement campaign deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Advertisement $advertisement)
    {
        $advertisement->status = !$advertisement->status;
        $advertisement->save();

        return response()->json([
            'success' => true,
            'status' => $advertisement->status,
            'message' => 'Ad status updated successfully.'
        ]);
    }
}
