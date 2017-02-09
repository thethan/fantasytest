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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @param array $options
     * @return League
     */
    public function validateAndSave(array $options = [])
    {
        $validator = Validator::make(
            array('league_id' => $options['league_id']),
            array('league_id' => array('unique:leagues,league_id'))
        );

        if ($validator->passes()) {
            $model = new League($options);
            $model->save();
            return $model;
        } else {
            return $this->where('league_id',$options['league_id'])->firstOrFail();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function draft()
    {
        return $this->hasOne(Draft::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roster()
    {
        return $this->hasOne(League::class);
    }


}
