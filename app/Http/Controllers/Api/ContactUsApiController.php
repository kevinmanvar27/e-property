<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactFormMail;
use App\Mail\UserConfirmationMail;

/**
 * @OA\Schema(
 *     schema="ContactRequest",
 *     type="object",
 *     @OA\Property(property="username", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="phone", type="string", example="1234567890"),
 *     @OA\Property(property="subject", type="string", example="Inquiry about properties"),
 *     @OA\Property(property="message", type="string", example="I would like to know more about your properties."),
 *     required={"username", "email", "subject", "message"}
 * )
 *
 * @OA\Schema(
 *     schema="ContactResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Thank you for contacting us. We will get back to you soon."),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *         @OA\Property(property="phone", type="string", example="1234567890"),
 *         @OA\Property(property="subject", type="string", example="Inquiry about properties"),
 *         @OA\Property(property="message", type="string", example="I would like to know more about your properties."),
 *         @OA\Property(property="status", type="string", example="pending"),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ContactValidationErrorResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Validation failed"),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\Property(
 *             property="username",
 *             type="array",
 *             @OA\Items(type="string", example="The username field is required.")
 *         ),
 *         @OA\Property(
 *             property="email",
 *             type="array",
 *             @OA\Items(type="string", example="The email must be a valid email address.")
 *         )
 *     )
 * )
 *
 * @OA\Tag(
 *     name="Contact Us",
 *     description="API Endpoints for Contact Form"
 * )
 */
class ContactUsApiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/contact-us",
     *      operationId="contactUs",
     *      tags={"Contact Us"},
     *      summary="Submit Contact Form",
     *      description="Submit contact form data and send emails",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContactRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful submission",
     *          @OA\JsonContent(ref="#/components/schemas/ContactResponse")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *          @OA\JsonContent(ref="#/components/schemas/ContactValidationErrorResponse")
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="There was an error submitting your form. Please try again later.")
     *          )
     *      )
     * )
     *
     * Store a newly created contact message in storage.
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
                'message' => 'Validation failed',
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

            // Send email notification to admin
            Mail::to(config('mail.from.address'))->send(new ContactFormMail(
                $request->username,
                $request->email,
                $request->phone,
                $request->subject,
                $request->message
            ));
            
            // Send confirmation email to the user
            Mail::to($request->email)->send(new UserConfirmationMail(
                $request->username,
                $request->email,
                $request->subject
            ));

            return response()->json([
                'success' => true,
                'data' => $contact,
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