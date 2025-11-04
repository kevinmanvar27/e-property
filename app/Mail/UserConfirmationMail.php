<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UserConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $logoBase64;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        
        // Generate base64 encoded logo for email clients that block external images
        $this->generateLogoBase64();
    }

    /**
     * Generate base64 encoded logo for reliable email client display
     */
    private function generateLogoBase64()
    {
        $logoPath = \App\Models\Setting::get('general', 'logo');
        
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            $fullPath = Storage::disk('public')->path($logoPath);
            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
            
            if (in_array(strtolower($extension), ['png', 'jpg', 'jpeg', 'gif'])) {
                $imageData = file_get_contents($fullPath);
                $base64 = base64_encode($imageData);
                
                switch (strtolower($extension)) {
                    case 'png':
                        $this->logoBase64 = 'data:image/png;base64,' . $base64;
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $this->logoBase64 = 'data:image/jpeg;base64,' . $base64;
                        break;
                    case 'gif':
                        $this->logoBase64 = 'data:image/gif;base64,' . $base64;
                        break;
                }
            }
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for contacting us - ' . $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user-confirmation',
            text: 'emails.user-confirmation-text',
            with: [
                'logoBase64' => $this->logoBase64,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}