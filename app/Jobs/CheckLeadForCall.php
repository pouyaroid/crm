<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Lead;
use App\Notifications\NoCallReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckLeadForCall implements ShouldQueue
{
    
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function handle()
    {
        // اگر هیچ تماسی برای این لید ثبت نشده
        if (! $this->lead->leadCalls()->exists()) {
            $user = $this->lead->user;
            $user->notify(new NoCallReminder($this->lead));
        }
    }
}
