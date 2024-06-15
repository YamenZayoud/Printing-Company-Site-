<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $resetUrl;

    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
        $this->resetUrl = route('change.password', [
            'token' => $this->token, 
            'email' => $this->email,
        ]);
    }

   /* public function envelope()
    {
        return new Envelope(
            subject: 'Password Reset Mail',
        );
    }

    public function content()
    {
        return new Content(
            
           
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     *//*
    public function attachments(): array
    {
        return ['resetUrl' => $this->resetUrl,];
    }*/


    public function build()
{
    return $this->subject('Reset Your Password')
                ->markdown('emails.password.reset', [
                    'resetUrl' => $this->resetUrl, 
                ]);
}
}
