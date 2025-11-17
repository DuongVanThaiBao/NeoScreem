<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $inlineImagePath;
    public $attachmentPath;

    public function __construct($username, $inlineImagePath = null, $attachmentPath = null)
    {
        $this->username = $username;
        $this->inlineImagePath = $inlineImagePath;
        $this->attachmentPath = $attachmentPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to NeoScreem 🎬',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'username' => $this->username,
                'imagePath' => $this->inlineImagePath,
            ],
        );
    }

    public function attachments(): array
    {
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            return [Attachment::fromPath($this->attachmentPath)];
        }
        return [];
    }
}
