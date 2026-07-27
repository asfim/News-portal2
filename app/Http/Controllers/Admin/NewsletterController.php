<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the subscribers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Newsletter::latest();

        if ($search) {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->paginate(15)->withQueryString();

        return view('admin.newsletters.index', compact('subscribers'));
    }

    /**
     * Remove the specified subscriber from storage.
     */
    public function destroy(Newsletter $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber removed successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Newsletter $subscriber)
    {
        $subscriber->status = !$subscriber->status;
        $subscriber->save();

        return response()->json([
            'success' => true,
            'status' => $subscriber->status,
            'message' => 'Subscriber status updated successfully.'
        ]);
    }
}
