<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueRoster extends Model
{
    protected $table = 'rosters';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['league_id', 'count', 'position'];


    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
