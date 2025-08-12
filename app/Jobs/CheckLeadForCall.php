<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Lead;
use App\Notifications\NoCallReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        try {
            // لاگ برای بررسی وضعیت دیتا
            Log::info('CheckLeadForCall Debug', [
                'lead_id'   => $this->lead->id,
                'has_calls' => $this->lead->leadCalls()->exists(),
                'user_id'   => optional($this->lead->user)->id
            ]);
    
            // ارسال نوتیفیکیشن بدون شرط
            $user = $this->lead->user;
            if ($user) {
                $user->notify(new NoCallReminder($this->lead));
                Log::info('Notification sent for lead ID: ' . $this->lead->id);
            } else {
                Log::error('CheckLeadForCall: lead has no associated user. Lead ID: ' . $this->lead->id);
            }
    
        } catch (\Exception $e) {
            Log::error('Error in CheckLeadForCall job: ' . $e->getMessage());
        }
    }}