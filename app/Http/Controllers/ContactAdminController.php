<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    /**
     * Display a listing of the contact messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return all contacts for DataTables to handle pagination and sorting
        $contacts = ContactUs::orderBy('created_at', 'desc')->get();
        return view('admin.contact-us.index', compact('contacts'));
    }

    /**
     * Display the specified contact message.
     *
     * @param  \App\Models\ContactUs  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contact)
    {
        return view('admin.contact-us.show', compact('contact'));
    }

    /**
     * Update the status of the contact message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactUs  $contact
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, ContactUs $contact)
    {
        // Accept both POST requests
        $request->validate([
            'status' => 'required|in:pending,under_review,clear',
        ]);

        $contact->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $request->status,
        ]);
    }
}