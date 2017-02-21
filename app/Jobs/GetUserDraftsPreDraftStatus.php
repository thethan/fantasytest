<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class GetUserDraftsPreDraftStatus
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $drafts;
    /**
     * Execute the job.
     *
     * @return Collection
     */
    public function handle(User $user)
    {
        $drafts = $user->drafts();
        $filtered =  $drafts->filter(function($value, $key) {
            return $value->draft_status == "predraft";
        });
        $values =  array_values($filtered->all());
        return new Collection($values);
    }




}
