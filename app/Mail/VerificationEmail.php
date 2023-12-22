<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $worker;
    public function __construct($worker)
    {
        $this->worker = $worker;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'name' => $this->worker->name,
                'verification_token' => url("http://127.0.0.1:8000/api/auth/worker/{$this->worker->verification_token}")
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
// public function build()
// {
//     return $this->view('mail');
// }
