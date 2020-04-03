<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyConfirmMail extends Mailable
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
        return $this->text('event.applyconfirmail')
                    ->subject(($this->data['eventtitle'].'　申込完了通知'))
                    ->with(
                        [
                            'username' => $this->data['username'],
                            'eventtitle' => $this->data['eventtitle'],
                            'eventdates' => $this->data['eventdates'],
                            'entrystatus' => $this->data['entrystatus'],
                        ]
                    );
    }
}
