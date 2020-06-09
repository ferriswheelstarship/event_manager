<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FinishedSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('history.finishedsendmail')
                    ->subject(('【'.$this->data['event_title'].'】受講証明書のご案内'))
                    ->with(
                        [
                            'username' => $this->data['username'],
                            'event_title' => $this->data['event_title'],
                        ]
                    );
    }
}
