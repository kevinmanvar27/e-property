<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Store the contact form data in the database
            $contact = ContactUs::create([
                'name' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'pending', // Default status
            ]);

            // Send email notification
            // Note: You'll need to configure mail settings in your .env file
            // This is a simplified example - you might want to create a Mailable class
            Mail::raw("New contact form submission:\n\nName: {$request->username}\nEmail: {$request->email}\nPhone: {$request->phone}\nSubject: {$request->subject}\nMessage: {$request->message}", function ($message) use ($request) {
                $message->to(config('mail.from.address'))
                        ->subject('New Contact Form Submission: ' . $request->subject)
                        ->from($request->email, $request->username);
            });

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us. We will get back to you soon.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'There was an error submitting your form. Please try again later.'
            ], 500);
        }
    }
}