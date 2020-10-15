<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration_request extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
    protected $viewStr;
 
    public function __construct($content, $viewStr = 'to')
    {
        $this->content = $content;
        $this->viewStr = $viewStr;
    }
 
    public function build()
    {
        return $this->text('registration_request.'.$this->viewStr)
            ->to($this->content['to'])
            ->subject($this->content['subject'])
            ->with([
                'content' => $this->content,
            ]);
    }
}
