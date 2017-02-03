<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['league_id', 'team_id', 'user_id','name'];


    public function leagues()
    {
        return $this->belongsTo(League::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
