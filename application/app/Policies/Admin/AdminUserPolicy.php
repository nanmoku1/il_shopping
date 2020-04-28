<?php

namespace App\Policies\Admin;

use App\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * @param AdminUser $login_user
     * @return bool
     */
    public function viewAny(AdminUser $login_user)
    {
        //オーナー権限ユーザーのみ利用可
        return $login_user->is_owner;
    }

    /**
     * @param AdminUser $login_user
     * @param AdminUser $admin_user
     * @return bool
     */
    public function view(AdminUser $login_user, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return $login_user->is_owner || $login_user->id === $admin_user->id;
    }

    /**
     * @param AdminUser $login_user
     * @return bool
     */
    public function create(AdminUser $login_user)
    {
        //オーナー権限ユーザーのみ利用可
        return $login_user->is_owner;
    }

    /**
     * @param AdminUser $login_user
     * @param AdminUser $admin_user
     * @return bool
     */
    public function update(AdminUser $login_user, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return $login_user->is_owner || $login_user->id === $admin_user->id;
    }

    /**
     * @param AdminUser $login_user
     * @param AdminUser $admin_user
     * @return bool
     */
    public function delete(AdminUser $login_user, AdminUser $admin_user)
    {
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        return $login_user->is_owner && $login_user->id !== $admin_user->id;
    }
}
