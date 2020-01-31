<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 管理画面用のクッキー名称、セッションテーブル名を変更する
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        if (strpos($uri, '/admin/') === 0 || $uri === '/admin') {
            config([
                'session.cookie' => config('const.session_cookie_admin'),
                'session.table' => config('const.ssession_table_admin'),
            ]);
        }
    }
}
