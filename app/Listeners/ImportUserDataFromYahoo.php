<?php

namespace App\Listeners;

use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;
use App\DataTransferObjects\Users\Games\UsersTeamsDto;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\Events\UserGamesImported;
use App\Events\UserLoggedIntoFantasy;
use App\Exceptions\Fantasy\FailedToSaveUserGamesInfo;
use App\Exceptions\YahooResponseException;
use App\Game;
use App\Jobs\QueueUserLeaguesJob;
use App\Jobs\SaveLeagueJob;
use App\Yahoo\Responses\User\TeamResponseForSaving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;


class ImportUserDataFromYahoo
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
     * @return \Psr\Http\Message\ResponseInterface
     * @throws YahooResponseException
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

    }
}
