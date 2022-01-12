<?php

namespace marius321967\Messages\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use marius321967\Messages\MessageStore;

/**
 * Middleware stores messages for displaying in the next request.
 */
class FlashMessages {

    /**
     * @var MessageStore
     */
    private $messageStore;

    public function __construct(MessageStore $messageStore) {
        $this->messageStore = $messageStore;
    }

    /**
     * Flashes Message[] at index 'flash_messages'
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next) {
        $response = $next($request);

        $session = $request->session();
        $flashMessages = $this->messageStore->getFlashedMessages();

        if (!empty($flashMessages)) {
            $session->flash('flash_messages', $flashMessages);
        }

        return $response;
    }
}