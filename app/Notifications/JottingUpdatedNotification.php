<?php

namespace App\Notifications;

use App\Models\Jotting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JottingUpdatedNotification extends Notification
{
    use Queueable;

    protected Jotting $jotting;
    protected string $updatedBy;

    public function __construct(Jotting $jotting, string $updatedBy)
    {
        $this->jotting = $jotting;
        $this->updatedBy = $updatedBy;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'jotting_id' => $this->jotting->id,
            'title' => $this->jotting->title,
            'message' => "{$this->updatedBy} updated a jotting shared with you.",
        ];
    }
}
