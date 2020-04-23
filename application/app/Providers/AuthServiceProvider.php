<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\AdminUser;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //管理ページ認可
        //オーナー権限ユーザーのみ利用可
        Gate::define('manager-admin-only', function (AdminUser $user) {
            return $user->is_owner;
        });
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        Gate::define('manager-admin-or-me', function (AdminUser $user, $id) {
            $adminUser = AdminUser::select(["id", "name", "email", "is_owner"])->where("id", "=", $id)->first();
            if (!$user->is_owner
                && (!$adminUser || $user->id !== $adminUser->id)) {
                return false;
            }
            return true;
        });
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        Gate::define('manager-admin-and-not-me', function (AdminUser $user, $id) {
            $adminUser = AdminUser::select(["id", "name", "email", "is_owner"])->where("id", "=", $id)->first();
            if (!$user->is_owner || !$adminUser || $user->id === $adminUser->id) {
                return false;
            }
            return true;
        });
    }
}
