<?php

namespace App\Policies;

use App\User;
use App\Draft;
use Illuminate\Auth\Access\HandlesAuthorization;

class DraftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the draft.
     *
     * @param  \App\User  $user
     * @param  \App\Draft  $draft
     * @return mixed
     */
    public function view(User $user, Draft $draft)
    {
        //
    }

    /**
     * Determine whether the user can create drafts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the draft.
     *
     * @param  \App\User  $user
     * @param  \App\Draft  $draft
     * @return mixed
     */
    public function update(User $user, Draft $draft)
    {
        //
    }

    /**
     * Determine whether the user can delete the draft.
     *
     * @param  \App\User  $user
     * @param  \App\Draft  $draft
     * @return mixed
     */
    public function delete(User $user, Draft $draft)
    {
        //
    }
}
