<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class League extends Model
{
    protected $table = 'leagues';
    /**
     * @var array
     */
    protected $fillable = ['league_id', 'game_id','name'];

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

    public function validateAndSave(array $options = [])
    {
        $validator = Validator::make(
            array('league_id' => $options['league_id']),
            array('league_id' => array('unique:leagues,league_id'))
        );

        return $validator->passes();
    }

}
