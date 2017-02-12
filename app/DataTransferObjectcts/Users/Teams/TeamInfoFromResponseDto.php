<?php

namespace App\DataTransferObjects\Users\Teams;

use Illuminate\Contracts\Support\Arrayable;

class TeamInfoFromResponseDto implements Arrayable
{
    protected $team_key;

    protected $logo;

    protected $name;

    protected $league_id;


    public function __construct(array $array)
    {
        $this->league_id = $array['league_id'];
        $this->name = $array['name'];
        $this->logo = $array['logo'];
        $this->team_key = $array['team_key'];
    }

    public function toArray() : array
    {
        return [
            'logo' => $this->logo,
            'name' => $this->name,
            'team_key' => $this->team_key,
            'league_id' => $this->league_id,
        ];
    }
}