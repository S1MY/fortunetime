<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $question)
    {
        $this->name = $name;
        $this->email = $email;
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.sendMail', ['name' => $this->name, 'email' => $this->email, 'question' => $this->question])->subject('Обработка формы обраной связи');
    }
}
