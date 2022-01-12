<?php

namespace marius321967\Messages\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use marius321967\Messages\MessageStore;

/**
 * Middleware stores messages for displaying in the next request.
 */
class LoadFlashedMessages {

    /**
     * @var MessageStore
     */
    private $store;

    public function __construct(MessageStore $store) {
        $this->store = $store;
    }

    /**
     * Retrieves Message[] from index 'flash_messages' and stores into MessageStore.
     * 
     * Fails silently if no session.
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next) {
        if ($request->hasSession()) {
            $session = $request->session();
            $previousMessages = $session->pull('flash_messages');
    
            if (is_array($previousMessages)) {
                foreach ($previousMessages as $message) {
                    $this->store->addContainer($message);
                }
            }
        }

        return $next($request);
    }
}