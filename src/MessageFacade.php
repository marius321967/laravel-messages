<?php

namespace marius321967\Messages;

use Illuminate\Support\Facades\Facade;

class MessageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'info_messages';
    }
}
