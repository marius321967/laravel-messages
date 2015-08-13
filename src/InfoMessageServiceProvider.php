<?php

namespace marius321967\Messages;


class InfoMessageServiceProvider extends \Illuminate\Support\ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // view()->share('messagess', 'test');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('info_messages', 'marius321967\Messages\MessageHandler');
    }
}
