<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class Game extends Model
{

    protected $fillable = ['name','code','season','logo','game_id'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @param Collection $leagues
     * @return mixed
     */
    public function addLeagueToGame(Collection $collectionOfIds)
    {
        return $this->leagues()->syncWithoutDetaching($collectionOfIds->all());
    }

    /**
     * @param array $options
     * @return Model
     */
    public function validateAndSave(array $options = [])
    {
        $validator = Validator::make(
            array('game_id' => $options['game_id']),
            array('game_id' => array('unique:games,game_id'))
        );

        if ($validator->passes()) {
            $model = new Game($options);
            $model->save();
            return $model;
        } else {
            return $this->where('game_id',$options['game_id'])->firstOrFail();
        }
    }


}
