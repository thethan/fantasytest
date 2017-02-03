<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['league_id', 'game_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasManyThrough(Team::class, User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function games()
    {
        return $this->belongsTo(Game::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
