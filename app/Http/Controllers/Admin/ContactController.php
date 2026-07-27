<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contact messages.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Contact::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $contacts = $query->paginate(15)->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Toggle read/unread status.
     */
    public function toggleRead(Contact $contact)
    {
        $contact->status = ($contact->status === 'unread') ? 'read' : 'unread';
        $contact->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $contact->status,
                'message' => 'Message read status updated.'
            ]);
        }

        return redirect()->back()->with('success', 'Message read status updated.');
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }
}
