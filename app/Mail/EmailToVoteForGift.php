<?php

namespace App\Mail;

use App\Models\Celebrant;
use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EmailToVoteForGift extends Mailable
{
    use Queueable, SerializesModels;

    protected $employee;
    protected $vote;
    protected $celebrant;

    /**
     * Create a new message instance.
     */
    public function __construct(Celebrant $employee, Vote $vote, Celebrant $celebrant)
    {
        $this->employee = $employee;
        $this->vote = $vote;
        $this->celebrant = $celebrant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('birthdays.company@gmail.com', 'B-Day company'),
            subject: 'Прийми участь у Голосуванні за варіант подарунка',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.emailToEmployeesToVoteForGift',
            with: [
                'employeeFirstname' => $this->employee->firstname,
                'employeeLastname' => $this->employee->lastname,
                'employeeHash' => $this->employee->hash,
                'votingEndDate' => $this->vote->end_at,
                'votingHash' => $this->vote->hash,
                'celebrantFirstname' => $this->celebrant->firstname,
                'celebrantLastname' => $this->celebrant->lastname,
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
