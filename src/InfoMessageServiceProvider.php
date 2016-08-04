<?php

namespace marius321967\Messages;

use Illuminate\Support\ServiceProvider;

class InfoMessageServiceProvider extends ServiceProvider {


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MessageHandler::class, function() {
            return new MessageHandler();
        });

        $this->app->bind('info_messages', MessageHandler::class);
    }
}
