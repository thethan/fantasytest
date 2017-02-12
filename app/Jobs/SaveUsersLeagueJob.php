<?php

namespace App\Jobs;

use App\Game;
use App\League;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Contracts\Yahoo\Services\Leagues\GetLeaguesContract;


/**
 * Class SaveUsersLeagueJob
 * @package App\Jobs
 */
class SaveUsersLeagueJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $game;

    public $dto;

    protected $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Game $game, Arrayable $teamsDto)
    {
        $this->user = $user;
        $this->game = $game;
        $this->dto = $teamsDto;

        $this->service = app()->make(GetLeaguesContract::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $validator = Validator::make(
            array('league_id' => $this->dto->toArray()['league_id']),
            array('league_id' => array('unique:leagues,league_id'))
        );

        if ($validator->passes()) {

            $this->service->setUser($this->user);
            $this->service->setUriParams('league_key', $this->dto->toArray()['league_id']);
            $this->service->setUriParams('game_key', $this->game->game_id);
            $dto = $this->service->call();
            dump($dto->simpleResponse());exit;
            $league = new League(['league_id' => $this->dto->toArray()['league_id']]);
            $this->game->leagues()->save($league);
        }

    }
}
