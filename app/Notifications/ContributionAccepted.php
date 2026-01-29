<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContributionAccepted extends Notification
{
    public function __construct(
        public Contribution $contribution,
        public User $actor
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'contribution.accepted',
            'title' => 'Contribution accepted',
            'message' => 'Your contribution was accepted',
            'jotting_id' => $this->contribution->jotting_id,
            'contribution_id' => $this->contribution->id,
            'actor' => [
                'id' => $this->actor->id,
                'name' => $this->actor->name,
            ],
        ];
    }
}
