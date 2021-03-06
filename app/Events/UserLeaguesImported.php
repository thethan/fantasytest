<?php

namespace App\Events;

use App\League;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;


class UserLeaguesImported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var User
     */
    public $user;
    /**
     * @var League
     */
    public $league;
    /**
     * @var TeamInfoFromResponseDto
     */
    public $dto;
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
