<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 7/5/15
 * Time: 2:11 PM
 */

namespace marius321967\Messages;


class StoreFlashMessages {

    public function handle($request, \Closure $next) {
        $response = $next($request);

        \Session::flash('flash_messages', \Message::getFlash());

        return $response;
    }
}