<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = ['game_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param Collection $users
     * @return mixed
     */
    public function addUserToGame(Collection $users)
    {
        return $this->users()->syncWithoutDetaching($users);
    }

    /**
     * @param Collection $users
     * @return mixed
     */
    public function removeUser(Collection $users)
    {
        return $this->users()->detach($users);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    /**
     * @param Collection $leagues
     * @return mixed
     */
    public function addLeagueToGame(Collection $leagues)
    {
        return $this->leagues()->syncWithoutDetaching($leagues);
    }
}
