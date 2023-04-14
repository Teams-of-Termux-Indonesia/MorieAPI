<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RAPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/RAP/RAP_Facebook.php';
        require_once app_path() . '/Helpers/RAP/RAP_Youtube.php';
        require_once app_path() . '/Helpers/RAP/RAP_Tiktok.php';
        require_once app_path() . '/Helpers/RAP/RAP_Instagram.php';
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
