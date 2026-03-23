<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TareaEliminada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tareaId;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($tareaId, $userId)
    {
        $this->tareaId = $tareaId;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('trabajador.' . $this->userId);
    }

    public function broadcasAs(): string
    {
        return 'tarea.eliminada';
    }

    public function broadcastWith(): array
    {
        return[
            'id' => $this->tareaId
        ];
    }
}
