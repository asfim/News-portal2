<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Comment::with(['user', 'news'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $comments = $query->paginate(15)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Update comment status.
     */
    public function updateStatus(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,spam'
        ]);

        $comment->status = $request->input('status');
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $comment->status,
                'message' => 'Comment status updated successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Comment status updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
