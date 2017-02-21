<?php

namespace App\DataTransferObjects\Users\Teams;

use Illuminate\Contracts\Support\Arrayable;

class TeamInfoFromResponseDto implements Arrayable
{
    protected $team_key;

    protected $logo;

    protected $name;

    protected $league_id;

    protected $game_id;

    protected $season;

    protected $code;


    public function __construct(array $array)
    {
        $this->league_id = $array['league_id'];
        $this->name = $array['name'];
        $this->logo = $array['logo'];
        $this->team_key = $array['team_key'];
        $this->game_id = $array['game_id'];
        $this->season = $array['season'];
        $this->code = $array['code'];
    }


    public function toArray() : array
    {
        return [
            'logo' => $this->logo,
            'name' => $this->name,
            'team_key' => $this->team_key,
            'league_id' => $this->league_id,
            'code' => $this->code,
            'season' => $this->season,
            'game_id' => $this->game_id,
        ];
    }
}