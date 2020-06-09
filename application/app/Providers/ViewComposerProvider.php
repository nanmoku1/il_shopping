<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composers([
            ViewComposers\ProductCategoriesComposer::class => 'layouts.app',
        ]);
    }
}
