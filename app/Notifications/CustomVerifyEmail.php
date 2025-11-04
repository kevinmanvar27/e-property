<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('Verify Your Email Address'))
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'url' => $verificationUrl,
                'logoBase64' => $this->generateLogoBase64(),
            ])
            ->text('emails.verify-email-text', [
                'user' => $notifiable,
                'url' => $verificationUrl,
            ]);
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
                        return 'data:image/png;base64,' . $base64;
                    case 'jpg':
                    case 'jpeg':
                        return 'data:image/jpeg;base64,' . $base64;
                    case 'gif':
                        return 'data:image/gif;base64,' . $base64;
                }
            }
        }
        
        return null;
    }
}