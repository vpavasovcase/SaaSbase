<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use App\Tools\CustomHelpers;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Company $model)
    {

        return $user->roles->contains('id', 1) || $user->companies->contains($model);
    }

    public function viewAny(User $user)
    {

        return $user->roles->contains('id', 1);
    }

    public function create(User $user)
    {
        $auth =  $user->roles->whereBetween('id', [1, 2])->count();
    }

    public function update(User $user, User $model)
    {
        return $user->roles->contains('id', 1) || $user->companies->contains($model);
    }

    public function delete(User $user, User $model)
    {
        return $user->roles->contains('id', 1) || $user->companies->contains($model);
    }
}
