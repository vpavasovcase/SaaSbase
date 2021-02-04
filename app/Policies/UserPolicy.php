<?php

namespace App\Policies;

use App\Models\User;
use App\Tools\CustomHelpers;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;



    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */



    public function viewAny(User $user)
    {

        return $user->roles->contains('id', 1);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        if ($user->roles->contains('id', 1)) {
            return true;
        }

        $auth = $model->roles->max('id') >= $user->roles->max('id');

        if ($auth) {
            $intersect = $model->allUserChapters()->intersect($user->allUserChapters());
            CustomHelpers::consoleDrop($intersect);
            $auth = count($intersect) > 0 ? true : false;
        }

        return $auth;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $auth =  $user->roles->whereBetween('id', [1, 3])->count();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return 0 < $user->roles->whereBetween('id', [1, 3])->count();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return 0 < $user->roles->whereBetween('id', [1, 3])->count();
    }
}
