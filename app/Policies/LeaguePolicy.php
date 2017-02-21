<?php

namespace App\Policies;

use App\User;
use App\League;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaguePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the league.
     *
     * @param  \App\User  $user
     * @param  \App\League  $league
     * @return mixed
     */
    public function view(User $user, League $league)
    {
        $filtered = $user->leagues()->filter(function ($value, $key) use ($league){
            return (int)$league->id === (int)$value->id;
        });

        return $filtered->count() == 1;

    }

    /**
     * Determine whether the user can create leagues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the league.
     *
     * @param  \App\User  $user
     * @param  \App\League  $league
     * @return mixed
     */
    public function update(User $user, League $league)
    {
        //
    }

    /**
     * Determine whether the user can delete the league.
     *
     * @param  \App\User  $user
     * @param  \App\League  $league
     * @return mixed
     */
    public function delete(User $user, League $league)
    {
        //
    }
}
