<?php

namespace App\Events;

use App\Models\Celda;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CeldaActualizada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $celda;

    /**
     * Create a new event instance.
     */
    public function __construct(Celda $celda)
    {
        $this->celda = $celda;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('parque');
    }

    public function broadcastAs(): string
    {
        return 'celda.actualizada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->celda->id,
            'nombre' => $this->celda->nombre,
            'alimento' => $this->celda->alimento,
            'averias_pendientes' => $this->celda->averias_pendientes,
            'nivel_seguridad' => $this->celda->nivel_seguridad,
            'nivel_peligrosidad' => $this->celda->nivel_peligrosidad
        ];
    }
}
