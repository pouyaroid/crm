<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintSubmitted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $complaint)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('ثبت شکایت شما با موفقیت انجام شد')
        ->greeting('سلام ' . $notifiable->name . ' عزیز')
        ->line('شکایت شما با عنوان "' . $this->complaint->title . '" با موفقیت ثبت شد.')
        ->line('تیم پشتیبانی در حال بررسی شکایت شماست و در اسرع وقت پاسخ داده خواهد شد.')
        ->line('شماره سفارش: ' . $this->complaint->ordernumber)
        ->line('از شکیبایی شما سپاس‌گزاریم.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
