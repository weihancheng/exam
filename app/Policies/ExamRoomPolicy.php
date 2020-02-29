<?php

namespace App\Policies;

use App\Exceptions\InternalException;
use App\Models\ExamRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ExamRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any exam rooms.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the exam room.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\ExamRoom  $examRoom
     * @return mixed
     */
    public function view(User $user, ExamRoom $exam_room)
    {
        $examinees = $exam_room->examinee()->get()->pluck('id')->toArray();
        return in_array($user->id, $examinees)
            ? Response::allow()
            : Response::deny('你不是本考场的考生');
    }


    public function correctionView(User $user, ExamRoom $exam_room)
    {
        return $user->id === $exam_room->user_id ? Response::allow() : Response::deny('你没有批改当前考场的权限');
    }

    /**
     * Determine whether the user can create exam rooms.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the exam room.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\ExamRoom  $examRoom
     * @return mixed
     */
    public function update(User $user, ExamRoom $examRoom)
    {
        //
    }

    /**
     * Determine whether the user can delete the exam room.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\ExamRoom  $examRoom
     * @return mixed
     */
    public function delete(User $user, ExamRoom $examRoom)
    {
        //
    }

    /**
     * Determine whether the user can restore the exam room.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\ExamRoom  $examRoom
     * @return mixed
     */
    public function restore(User $user, ExamRoom $examRoom)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the exam room.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\\ExamRoom  $examRoom
     * @return mixed
     */
    public function forceDelete(User $user, ExamRoom $examRoom)
    {
        //
    }
}
