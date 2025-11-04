<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserConfirmationMail;

class TestUserConfirmationMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:user-confirmation-mail {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test user confirmation email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        Mail::to($email)->send(new UserConfirmationMail('Test User', $email, 'Test Subject'));
        
        $this->info("Test email sent to {$email}");
    }
}