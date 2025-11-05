<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class CustomResetPassword extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $resetUrl = $this->resetUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $resetUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'url' => $resetUrl,
                'logoBase64' => $this->generateLogoBase64(),
            ])
            ->text('emails.reset-password-text', [
                'user' => $notifiable,
                'url' => $resetUrl,
            ]);
    }
    
    /**
     * Get the reset password URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
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