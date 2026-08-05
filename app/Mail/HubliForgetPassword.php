<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HubliForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        $subjects = [
            'license_domain_change' => 'License Domain Change Alert: ' . ($this->data['new'] ?? 'unknown'),
            'license_server_down'   => 'Server LOCKED / Taken Down: ' . ($this->data['app'] ?? 'License App'),
            'license_server_up'     => 'Server UNLOCKED / Back Up: ' . ($this->data['app'] ?? 'License App'),
        ];

        $subject = $subjects[$this->data['event'] ?? ''] ?? 'License Alert';

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        $view = match ($this->data['event'] ?? '') {
            'license_server_down', 'license_server_up' => 'emails.license-server-state',
            default => 'emails.license-domain-alert',
        };

        return new Content(
            view: $view,
            with: [
                'data' => $this->data,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments()
    {
        return [];
    }
}
