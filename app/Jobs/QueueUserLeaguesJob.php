<?php

namespace App\Jobs;

use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\Game;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;


/**
 * Class SaveUsersLeagueJob
 * @package App\Jobs
 */
class QueueUserLeaguesJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $game;

    public $collection;

    protected $service;

    /**
     * SaveUsersLeagueJob constructor.
     * @param User $user
     * @param Collection $collection
     */
    public function __construct(User $user, Game $game, Collection $collection)
    {
        $this->user = $user;
        $this->game = $game;
        $this->collection = $collection;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
