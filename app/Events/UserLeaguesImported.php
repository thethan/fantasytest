<?php

namespace App\Events;

use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\League;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLeaguesImported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $league, $dto;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, League $league, TeamInfoFromResponseDto $dto)
    {
        $this->user = $user;
        $this->league = $league;
        $this->dto = $dto;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.'.$this->user->id);
    }
}
