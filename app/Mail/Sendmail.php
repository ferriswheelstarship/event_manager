<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class Sendmail extends Mailable
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
            ->text('mail.sendmail')
            ->to(['ito@mj-inc.jp'])
            ->subject(($this->data['title']))
            ->with([
                'body' => $this->data['body']
            ])
            ->sendgrid([
                'personalizations' => $this->data['to']                
            ]);

    }
}
