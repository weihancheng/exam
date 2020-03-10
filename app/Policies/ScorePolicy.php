<?php

namespace App\Policies;

use App\Models\Score;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any scores.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the score.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\Score  $score
     * @return mixed
     */
    public function view(User $user, Score $score)
    {
        return $user->id === $score->user_id;
    }

    /**
     * Determine whether the user can create scores.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the score.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\Score  $score
     * @return mixed
     */
    public function update(User $user, Score $score)
    {
        //
    }

    /**
     * Determine whether the user can delete the score.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\Score  $score
     * @return mixed
     */
    public function delete(User $user, Score $score)
    {
        //
    }

    /**
     * Determine whether the user can restore the score.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\Score  $score
     * @return mixed
     */
    public function restore(User $user, Score $score)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the score.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\Score  $score
     * @return mixed
     */
    public function forceDelete(User $user, Score $score)
    {
        //
    }
}
