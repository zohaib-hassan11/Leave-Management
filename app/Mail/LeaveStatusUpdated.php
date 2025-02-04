<?php

namespace App\Mail;

use App\Models\UserRequest;  // Import UserLeaveRequest if necessary
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The leave request instance.
     *
     * @var \App\Models\UserRequest
     */
    public $leave;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\UserRequest  $leave
     * @return void
     */
    public function __construct(UserRequest $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Status Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'userLeave.statusMail',
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
