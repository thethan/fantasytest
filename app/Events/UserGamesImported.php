<?php

namespace App\Events;

use App\Game;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;

class UserGamesImported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game, $user, $dto;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Game $game, TeamInfoFromResponseDto $dto)
    {
        $this->user = $user;
        $this->game = $game;
        $this->dto = $dto;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user-'.$this->user->id);
    }
}
