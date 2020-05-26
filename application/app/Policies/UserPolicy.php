<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $login_user
     * @param User $user
     * @return bool
     */
    public function update(User $login_user, User $user)
    {
        return $login_user->id === $user->id;
    }
}
