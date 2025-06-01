<?php

namespace App\Notifications;

use App\Models\Risk;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RiskStatusNotification extends Notification
{
    use Queueable;

    protected $risk;

    public function __construct(Risk $risk)
    {
        $this->risk = $risk;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Risk Status Update')
            ->line('Your reported risk has been updated.')
            ->line('Description: ' . $this->risk->description)
            ->line('Status: ' . ucfirst(str_replace('_', ' ', $this->risk->status)))
            ->line('Response: ' . ($this->risk->response ?? 'None'))
            ->action('View Dashboard', route('staff.dashboard'))
            ->line('Thank you for using our system!');
    }

    public function toArray($notifiable)
    {
        return [
            'risk_id' => $this->risk->id,
            'description' => $this->risk->description,
            'status' => $this->risk->status,
            'response' => $this->risk->response,
        ];
    }
}