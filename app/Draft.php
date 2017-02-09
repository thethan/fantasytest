<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['commissioner_id', 'league_id', 'draft_time', 'roster_spots'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function league()
    {
        return $this->hasOne(League::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough(League::class, User::class);
    }

}
