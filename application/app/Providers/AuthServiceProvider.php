<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\Admin\AdminUserPolicy;
use App\Policies\Admin\ProductCategoryPolicy;
use App\Policies\UserPolicy;
use App\Policies\ProductReviewPolicy;
use App\Models\AdminUser;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\ProductReview;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AdminUser::class => AdminUserPolicy::class,
        ProductCategory::class => ProductCategoryPolicy::class,
        User::class => UserPolicy::class,
        ProductReview::class => ProductReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
