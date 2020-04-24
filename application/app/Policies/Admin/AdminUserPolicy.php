<?php

namespace App\Policies\Admin;

use App\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserPolicy
{
    use HandlesAuthorization;

    protected const MANAGER_ADMIN_ONLY = 1;
    protected const MANAGER_ADMIN_OR_ME = 2;
    protected const MANAGER_ADMIN_AND_NOT_ME = 3;

    /**
     * @param AdminUser $user
     * @return bool
     */
    public function viewAny(AdminUser $user)
    {
        return $this->_auth(self::MANAGER_ADMIN_ONLY, $user);
    }

    /**
     * @param AdminUser $user
     * @param AdminUser $adminUser
     * @return bool
     */
    public function view(AdminUser $user, AdminUser $adminUser)
    {
        return $this->_auth(self::MANAGER_ADMIN_OR_ME, $user, $adminUser);
    }

    /**
     * @param AdminUser $user
     * @param AdminUser $adminUser
     * @return bool
     */
    public function create(AdminUser $user)
    {
        return $this->_auth(self::MANAGER_ADMIN_ONLY, $user);
    }

    /**
     * @param AdminUser $user
     * @param AdminUser $adminUser
     * @return bool
     */
    public function update(AdminUser $user, AdminUser $adminUser)
    {
        return $this->_auth(self::MANAGER_ADMIN_OR_ME, $user, $adminUser);
    }

    /**
     * @param AdminUser $user
     * @param AdminUser $adminUser
     * @return bool
     */
    public function delete(AdminUser $user, AdminUser $adminUser)
    {
        return $this->_auth(self::MANAGER_ADMIN_AND_NOT_ME, $user, $adminUser);
    }

    /**
     * @param int $type
     * @param AdminUser $user
     * @param AdminUser|null $adminUser
     * @return bool
     */
    protected function _auth(int $type, AdminUser $user, AdminUser $adminUser = null)
    {
        switch ($type) {
            case self::MANAGER_ADMIN_OR_ME:
                if (!$user->is_owner
                    && (!$adminUser || $user->id !== $adminUser->id)) {
                    return false;
                }
                return true;
                break;
            case self::MANAGER_ADMIN_AND_NOT_ME:
                if (!$user->is_owner || !$adminUser || $user->id === $adminUser->id) {
                    return false;
                }
                return true;
                break;
        }
        return $user->is_owner;
    }
}
