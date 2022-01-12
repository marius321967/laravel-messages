<?php

namespace marius321967\Messages\Facades;

use Illuminate\Support\Facades\Facade;
use marius321967\Messages\MessageStore;

class Message extends Facade {

    protected static function getFacadeAccessor() { return MessageStore::class; }
    
}
