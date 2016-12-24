<?php

namespace marius321967\Messages;

use Illuminate\Session\SessionManager;

class MessageHandler {

    protected $messages;

    protected $flash_messages = [];

    /**
     * @var SessionManager
     */
    protected $sessionManager;


    public function __construct() {
        $this->sessionManager = app(SessionManager::class);

        if ($this->sessionManager->has('flash_messages'))
            $this->messages = $this->sessionManager->get('flash_messages');
    }

    public function getAll() {
        if (is_null($this->messages))
            $this->loadFlashedMessages();

        return $this->messages;
    }

    public function getFlash() {
        return $this->flash_messages;
    }

    public function add($message, $type = 'info') {
        if (is_null($this->messages))
            $this->loadFlashedMessages();

        $this->messages[] = [
            'message' => $message,
            'type' => $type,
        ];
    }

    public function flash($message, $type = 'info') {
        $this->flash_messages[] = [
            'message' => $message,
            'type' => $type,
        ];
    }

    private function loadFlashedMessages() {
        $flashed = $this->sessionManager->get('flash_messages');
        $flashed = ($flashed) ?: []; // Or empty array.
        $this->messages = $flashed;
    }

}