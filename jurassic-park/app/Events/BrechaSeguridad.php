<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrechaSeguridad implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $informe;

    /**
     * Create a new event instance.
     */
    public function __construct(array $informe)
    {
        $this->informe = $informe;
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
        return 'brecha.seguridad';
    }

    public function broadcastWith(): array
    {
        return [
            'celda' => $this->informe['celda']['nombre'],
            'resultado' => $this->informe['resultado'],
            'carnivoros_letales' => $this->informe['carnivoros_letales'],
            'bajas_personal' => $this->informe['bajas_personal'],
            'eventos' => $this->informe['eventos']
        ];
    }
}
