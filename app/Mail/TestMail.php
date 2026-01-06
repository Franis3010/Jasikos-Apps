<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    // use Queueable, SerializesModels;

    // public function __construct(public string $body = 'Halo dari Jasikos via Mailtrap!') {}

    // public function envelope(): Envelope
    // {
    //     return new Envelope(subject: 'Test Mailtrap - Jasikos');
    // }

    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'emails.test',
    //         with: ['body' => $this->body]
    //     );
    // }

    // public function attachments(): array
    // {
    //     return [];
    // }
}
