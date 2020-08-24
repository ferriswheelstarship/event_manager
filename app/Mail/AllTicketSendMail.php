<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class AllTicketSendMail extends Mailable
{
    use Queueable, SerializesModels;
    use SendGrid;

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
        return $this
            ->view('entry.allticketsendmail')
            ->to(['ito@mj-inc.jp'])
            ->subject(($this->data['eventtitle'].'　受講券のご案内'))
            ->with([
                'eventtitle' => $this->data['eventtitle'],
                'eventnotice' => $this->data['eventnotice'],
                'eventdates' => $this->data['eventdates'],
            ])
            ->sendgrid([
                'personalizations' => $this->data['personalizations']                
            ]);
    }
}
