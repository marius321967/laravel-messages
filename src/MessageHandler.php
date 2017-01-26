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
    }

    public function getAll() {
        if (is_null($this->messages))
            $this->loadFlashedMessages();

        return $this->messages;
    }

    public function getFlash() {
        return $this->flash_messages;
    }

    public function add($message, $type = 'info', $escape = true) {
        if (is_null($this->messages))
            $this->loadFlashedMessages();

        $message = new InfoMessage([
            'message' => $message,
            'notificationType' => $type,
            'shouldEscapeHtml' => $escape,
        ]);
        $this->messages[] = $message;
    }

    public function flash($message, $type = 'info', $escape = true) {
        $message = new InfoMessage([
            'message' => $message,
            'notificationType' => $type,
            'shouldEscapeHtml' => $escape,
        ]);
        $this->flash_messages[] = $message;
    }

    private function loadFlashedMessages() {
        $flashed = $this->sessionManager->get('flash_messages');
        $flashed = ($flashed) ?: []; // Or empty array.

        foreach ($flashed as &$array) {
            // Replace data array with object.
            $message = InfoMessage::buildFromArray($array);
            $array = $message;
        }
        $this->messages = $flashed;
    }

}