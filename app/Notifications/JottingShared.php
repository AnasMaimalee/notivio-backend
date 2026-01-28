<?php

namespace App\Notifications;

use App\Models\Jotting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class JottingShared extends Notification
{
    use Queueable;

    protected Jotting $jotting;
    protected string $sharedBy;

    public function __construct(Jotting $jotting, string $sharedBy)
    {
        $this->jotting = $jotting;
        $this->sharedBy = $sharedBy;
    }

    public function via($notifiable)
    {
        return ['database']; // Can add 'broadcast' later for real-time
    }

    public function toDatabase($notifiable)
    {
        return [
            'jotting_id' => $this->jotting->id,
            'title' => $this->jotting->title,
            'message' => "{$this->sharedBy} shared a jotting with you.",
        ];
    }
}
