<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param array $options
     */
    public function save(array $options = [])
    {
        $this->api_token = $this->api_token ?: Str::random(60);

        parent::save($options);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function yahooToken()
    {
        return $this->hasOne(YahooToken::class);
    }

    /**
     * @return mixed
     */
    public function games()
    {
        return DB::table('games')
                ->join('teams', 'games.id', '=', 'teams.game_id')
                ->select('games.*')
                ->where('teams.user_id', '=', $this->id)
                ->distinct()
                ->get();
    }

    /**
     * @return mixed
     */
    public function leagues()
    {
        return DB::table('leagues')
            ->join('teams', 'leagues.id', '=', 'teams.league_id')
            ->select('leagues.*')
            ->where('teams.user_id', '=', $this->id)
            ->distinct()
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
