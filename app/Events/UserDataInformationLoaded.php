<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserDataInformationLoaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $teams, $leagues, $games;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->teams = $user->teams;
        // Needed to write sql queries to join
        $this->games = $user->games();
        // Needed to write sql queries to join
        $this->leagues = $user->leagues();
    }

    protected function games(User $user)
    {
        return $user->games;
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
