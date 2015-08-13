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
        \Route::filter('messages_store_flash', function() {
            \Session::flash('flash_messages', \Message::getFlash());
        });
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
