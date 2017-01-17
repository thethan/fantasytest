<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = ['league_key', 'game_key'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function addUserToGame(Collection $users)
    {
        return $this->users()->syncWithoutDetaching($users);
    }

    public function removeUser()
    {
        return $this->users()->detach();
    }
}
