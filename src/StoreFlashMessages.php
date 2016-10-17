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

        if ($this->sessionManager->has('flash_messages')) {
            $messages = $this->sessionManager->get('flash_messages');
            foreach ($messages as $message)
                $this->messageManager->add($message['message'], $message['type']);
        }
    }

    public function handle($request, \Closure $next) {
        $response = $next($request);

        if (!empty($flashMessages = $this->messageManager->getFlash()))
            $this->sessionManager->flash('flash_messages', $flashMessages);

        return $response;
    }
}