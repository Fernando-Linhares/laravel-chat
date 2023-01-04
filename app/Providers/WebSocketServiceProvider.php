<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WebSocketService;
use App\Services\Contracts\IWebSocketService;

class WebSocketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IWebSocketService::class,
            function () {
                return new WebSocketService(new \SplObjectStorage);
            }
        );
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
