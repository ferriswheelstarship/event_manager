<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpgradingNoticeMail extends Mailable
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
        return $this->text('entry.upgradingnoticemail')
                    ->subject(($this->data['eventtitle'].'　申込繰り上げのご案内'))
                    ->with(
                        [
                            'username' => $this->data['username'],
                            'eventtitle' => $this->data['eventtitle'],
                            'eventdates' => $this->data['eventdates']
                        ]
                    );
    }
}
