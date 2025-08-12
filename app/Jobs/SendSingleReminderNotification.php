<?php

namespace App\Jobs;

use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSingleReminderNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;

    /**
     * Create a new job instance.
     *
     * @param Reminder $reminder
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = $this->reminder->user;

        if ($user && ! $this->reminder->is_notified) {
            $user->notify(new ReminderNotification($this->reminder));

            // علامت‌گذاری ریمایندر به عنوان ارسال شده
            $this->reminder->is_notified = true;
            $this->reminder->save();
        }
    }
}
