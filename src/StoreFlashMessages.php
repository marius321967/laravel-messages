<?php

namespace marius321967\Messages;

use Illuminate\Session\SessionManager;

class StoreFlashMessages {

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var MessageHandler
     */
    protected $messageManager;


    public function __construct() {
        $this->sessionManager = app(SessionManager::class);
        $this->messageManager = app(MessageHandler::class);
    }

    public function handle($request, \Closure $next) {
        $response = $next($request);

        if (!empty($flashMessages = $this->messageManager->getFlash())) {
            // Array of data arrays, each representing a message.
            $arrays = [];
            foreach ($flashMessages as $flashMessage) {
                $arrays[] = $flashMessage->toArray();
            }

            $this->sessionManager->flash('flash_messages', $arrays);
        }

        return $response;
    }
}