<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyDigest extends Mailable
{
    use Queueable, SerializesModels;

    private $conteudos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conteudos)
    {
        $this->conteudos = $conteudos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.digest')->with([
            'conteudos' => $this->conteudos,
        ])->subject('Daily Digest');
    }
}
