<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['league_id', 'team_key', 'user_id','name','logo'];


    public function leagues()
    {
        return $this->belongsTo(League::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function validateAndSave(array $options = [])
    {
        dump($options);
        $validator = Validator::make(
            array('team_key' => $options['team_key']),
            array('team_key' => array('unique:teams,team_key'))
        );

        if ($validator->passes()) {
            $model = new Team($options);
            $model->save($options);
            return $model;
        } else {
            return $this->where('team_key',$options['team_key'])->firstOrFail();
        }
    }
}
