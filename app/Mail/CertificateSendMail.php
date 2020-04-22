<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertificateSendMail extends Mailable
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
        return $this->text('history.certificatesendmail')
                    ->subject(('保育士等キャリアアップ研修【'.$this->data['parent_curriculum'].'】修了証のご案内'))
                    ->with(
                        [
                            'username' => $this->data['username'],
                            'parent_curriculum' => $this->data['parent_curriculum'],
                        ]
                    );
    }
}
