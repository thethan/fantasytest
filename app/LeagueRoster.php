<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueRoster extends Model
{
    protected $table = 'rosters';
    /**
     * @var array
     */
    protected $fillable = ['league_id'];

}
