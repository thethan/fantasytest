<?php

namespace App\Listeners;

use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;
use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\Events\UserLoggedIntoFantasy;
use App\Exceptions\Fantasy\FailedToSaveUserGamesInfo;
use App\Exceptions\YahooResponseException;
use App\Game;
use App\Jobs\SaveUsersLeagueJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;


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
        /**
         * @var ResponseInterface
         */
        $dto = $this->service->call();

        //
        foreach ($dto->simpleResponse()->all() as $game) {
            $validator = Validator::make(
                array('game_id' => $game['game_id']),
                array('game_id' => array('unique:games,game_id'))
            );

            if ($validator->passes()) {
                $model = new Game($game);
                $model->save();
            } else {
                $model = Game::where('game_id', $game['game_id'])->firstOrFail();
            }
            // Fire off event to get Leagues and Users
            foreach ($game['teams']->all() as $team) {
                $this->dispatch(new SaveUsersLeagueJob($event->user, $model, new TeamInfoFromResponseDto($team)));
            }
        }
        return $dto;

    }
}
