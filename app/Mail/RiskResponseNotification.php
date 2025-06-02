<?php

namespace App\Mail;

use App\Models\Risk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RiskResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $risk;
    public $action;

    public function __construct(Risk $risk, string $action)
    {
        $this->risk = $risk;
        $this->action = $action;
    }

    public function build()
    {
        return $this->subject('Risk Update: ' . ucfirst($this->action))
                    ->view('emails.risk_response')
                    ->with([
                        'risk' => $this->risk,
                        'action' => $this->action,
                    ]);
    }
}
