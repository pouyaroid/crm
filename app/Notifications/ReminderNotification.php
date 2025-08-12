<?php

namespace App\Notifications;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ReminderNotification extends Notification implements ShouldQueue

{
    use Queueable;
    

    public $reminder;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
{
    return [
        'message' => 'یادآوری برای مشتری ' . (optional($this->reminder->getCustomer())->company_name ?? 'نامشخص') . ' - ' . $this->reminder->title,
    ];
}

public function toDatabase($notifiable)
{
    return [
        'message' => 'یادآوری برای مشتری ' . optional($this->reminder->getCustomer())->company_name ?? 'نامشخص' . ' - ' . $this->reminder->title,
        'title' => 'یادآور',
        'body' => $this->reminder->title . ' - ' . $this->reminder->description,
        'reminder_id' => $this->reminder->id,
    ];
}
}
