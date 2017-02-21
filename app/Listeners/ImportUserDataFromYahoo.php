<?php

namespace App\Listeners;

use App\Game;
use App\Events\UserGamesImported;
use App\Events\UserLoggedIntoFantasy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;


class ImportUserDataFromYahoo implements ShouldQueue
{
    use InteractsWithQueue, DispatchesJobs;

    protected $service;

    /**
     * ImportUserDataFromYahoo constructor.
     * @param GetUserTeamsContract $service
     */
    public function __construct(GetUserTeamsContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param UserLoggedIntoFantasy $event
     * @return $this
     */
    public function handle(UserLoggedIntoFantasy $event)
    {
        $this->service->setUser($event->user);

        $dto = $this->service->call();

        $collection = $dto->simpleResponse()->reverse();

        foreach ($collection->all() as $game) {

            $validator = Validator::make(
                array('game_id' => $game['game_id']),
                array('game_id' => array('unique:games,game_id'))
            );

            if ($validator->passes()) {
                $model = new Game([
                        'code' => $game['code'],
                        'season' => $game['season'],
                        'game_id' => $game['game_id'],
                        'name' => $game['game_name'],
                    ]
                );
                $model->save();
            } else {
                $model = Game::where('game_id', $game['game_id'])->firstOrFail();
            }
            event(new UserGamesImported($event->user, $model, new TeamInfoFromResponseDto($game)));

        }
        return $this;
    }
}
