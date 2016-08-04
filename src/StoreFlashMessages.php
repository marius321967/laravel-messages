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

        if ($this->sessionManager->has('flash_messages')) {
            $this->messages = $this->sessionManager->get('flash_messages');
        }

        $this->messageManager = app(MessageHandler::class);
    }

    public function handle($request, \Closure $next) {
        $response = $next($request);

        $this->sessionManager->flash('flash_messages',
            $this->messageManager->getFlash());

        return $response;
    }
}