<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class TestContactFormMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:contact-form-mail {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test contact form email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@example.com';
        
        Mail::to($email)->send(new ContactFormMail(
            'Test User',
            'test@example.com',
            '123-456-7890',
            'Test Subject',
            'This is a test message from the contact form.'
        ));
        
        $this->info("Test contact form email sent to {$email}");
    }
}