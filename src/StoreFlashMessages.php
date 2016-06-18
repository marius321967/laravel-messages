<?php

namespace marius321967\Messages;

use Session, Message;

class StoreFlashMessages {

    public function handle($request, \Closure $next) {
        $response = $next($request);

        Session::flash('flash_messages', Message::getFlash());

        return $response;
    }
}