<?php

namespace marius321967\Messages;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use marius321967\Messages\Middleware\FlashMessages;
use marius321967\Messages\Middleware\LoadFlashedMessages;

class MessageServiceProvider extends ServiceProvider {

    public function boot() {
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', LoadFlashedMessages::class);
        $router->pushMiddlewareToGroup('web', FlashMessages::class);
    }

    public function register() {
        $this->app->singleton(MessageStore::class, function() {
            return new MessageStore();
        });

    }
}
