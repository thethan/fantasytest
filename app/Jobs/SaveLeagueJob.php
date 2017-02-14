<?php

namespace App\Jobs;

use App\Contracts\Yahoo\Services\Leagues\GetLeaguesContract;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\Game;
use App\League;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Validator;

class SaveLeagueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $game;

    public $dto;

    protected $service;

    /**
     * SaveLeagueJob constructor.
     * @param User $user
     * @param Game $game
     * @param TeamInfoFromResponseDto $dto
     */
    public function __construct(User $user, Game $game, TeamInfoFromResponseDto $dto)
    {
        $this->user = $user;
        $this->game = $game;
        $this->dto  = $dto;
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
            dump($dto);exit;
            $model = new League(['league_id' => $this->dto->toArray()['league_id'], 'name' => '']);
            $model->save();
        } else {
            $model = Game::where('game_id', $this->game->game_id)->firstOrFail();
        }
    }
}
