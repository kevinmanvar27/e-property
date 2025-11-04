<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test if mail functionality is working properly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $to = $this->option('to') ?? config('mail.from.address');
        
        if (!$to) {
            $this->error('No recipient email address provided and no default from address configured.');
            return 1;
        }

        try {
            // Test basic mail configuration
            Mail::raw('This is a test email to verify mail functionality is working properly.', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Test Email from RProperty Application');
            });

            $this->info("Test email sent successfully to: {$to}");
            $this->info("Please check the recipient's inbox to verify delivery.");
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test email: ' . $e->getMessage());
            Log::error('Mail test failed: ' . $e->getMessage());
            
            return 1;
        }
    }
}