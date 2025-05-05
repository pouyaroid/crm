<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendCustomerEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $messageText;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $messageText)
    {
        $this->email = $email;
        $this->messageText = $messageText;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         // ارسال ایمیل
         Mail::raw($this->messageText, function ($message) {
            $message->to($this->email)
                    ->subject('پیام جدید برای شما');
        });

        // ثبت در لاگ
        Log::info("📧 ایمیل به {$this->email} با موفقیت ارسال شد.");
    }
}
