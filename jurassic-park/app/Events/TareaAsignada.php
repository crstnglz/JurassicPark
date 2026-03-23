<?php

namespace App\Events;

use App\Models\Tarea;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TareaAsignada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tarea;

    /**
     * Create a new event instance.
     */
    public function __construct(Tarea $tarea)
    {
        $this->tarea = $tarea;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('trabajador.' . $this->tarea->user_id);
    }

    public function broadcastAs(): string
    {
        return 'tarea.asignada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->tarea->id,
            'tipo' => $this->tarea->tipo,
            'estado' => $this->tarea->estado,
            'descripcion' => $this->tarea->descripcion,
            'celda' => $this->tarea->celda ? [
                'id' => $this->tarea->celda->id,
                'nombre' => $this->tarea->celda->nombre
            ] : null
        ];
    }
}
