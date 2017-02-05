<?php

namespace App;

use Dotenv\Validator;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['league_id', 'team_id', 'user_id','name'];

    public function saveIfUnique(array $array, User $user)
    {

        $validator = Validator::make(
            array('team_id' =>  $array['team_id']),
            array('team_id' => array('unique:teams,team_id'))
        );

        if($validator->passes()) {
            $model = new Team($array);
            $user->teams()->save($model);
        }
    }

    public function leagues()
    {
        return $this->belongsTo(League::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
