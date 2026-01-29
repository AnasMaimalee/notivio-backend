<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContributionSubmitted extends Notification
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
            'type' => 'contribution.submitted',
            'title' => 'New contribution',
            'message' => "{$this->actor->name} submitted a contribution",
            'jotting_id' => $this->contribution->jotting_id,
            'contribution_id' => $this->contribution->id,
            'actor' => [
                'id' => $this->actor->id,
                'name' => $this->actor->name,
            ],
        ];
    }
}
