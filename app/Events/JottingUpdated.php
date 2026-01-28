<?php

namespace App\Events;

use App\Models\Jotting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class JottingUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $jotting;

    public function __construct(Jotting $jotting)
    {
        $this->jotting = $jotting->load('versions', 'attachments');
    }

    public function broadcastOn()
    {
        return new PresenceChannel("jotting.{$this->jotting->id}");
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->jotting->id,
            'title' => $this->jotting->title,
            'content' => $this->jotting->content,
        ];
    }
}
