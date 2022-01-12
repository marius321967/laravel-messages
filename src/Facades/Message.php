<?php

namespace marius321967\Messages\Facades;

use Illuminate\Support\Facades\Facade;

class Message extends Facade {

    protected static function getFacadeAccessor() { return MessageStore::class; }
    
}
