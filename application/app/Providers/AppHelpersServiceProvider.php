<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppHelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(sprintf('%s/Helpers/*.php', app_path())) as $helper_file) {
            require_once($helper_file);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
