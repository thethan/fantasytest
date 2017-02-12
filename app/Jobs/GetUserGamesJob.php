<?php

namespace App\Jobs;

use App\Contracts\Yahoo\ResponseInterface;
use App\Contracts\Yahoo\Services\Users\GetUserGamesContract;
use App\Exceptions\YahooServiceException;
use App\Game;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\DataTransferObjects\Users\Games\UsersGamesDto;


class GetUserGamesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(GetUserGamesContract $yahooService)
    {
        try {
            $yahooService->setUser($this->user);
            /**
             * @var ResponseInterface
             */
            $dto = $yahooService->call();

            foreach ($dto->simpleResponse()->all() as $game ) {
                $validator = Validator::make(
                    array('game_id' =>  $game['game_id']),
                    array('game_id' => array('unique:games,game_id'))
                );

                if($validator->passes()) {
                    $model = new Game($game);
                    $model->save();
                }
            }
            return $dto;
        } catch (\Exception $exception) {
            throw new YahooServiceException($exception->getMessage());
        }
    }
}
