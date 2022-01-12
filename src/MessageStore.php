<?php

namespace marius321967\Messages;

/**
 * A container within a stateful context: 
 * - some messages must be shown in current response
 * - other messages must be stored for next response
 * 
 * @since 6.0.0
 */
class MessageStore {

    private $activeMessages = [];

    private $flashMessages = [];

    public function getActiveMessages(): array {
        return $this->activeMessages;
    }

    public function getFlashedMessages(): array {
        return $this->flashMessages;
    }

    /**
     * Add message to be displayed in current response.
     * @param string $message
     * @param string $type
     * @param boolean $trusted Whether message can be rendered unsanitized
     */
    public function add(string $message, string $type = 'info', bool $trusted = true) {
        $this->addContainer(new Message($message, $type, $trusted));
    }

    public function addContainer(Message $message) {
        $this->activeMessages[] = $message;
    }

    /**
     * @param string $message
     * @param string $type
     * @param boolean $trusted Whether message can be rendered unsanitized
     */
    public function flash(string $message, string $type = 'info', bool $trusted = true) {
        $this->flashMessages[] = new Message($message, $type, $trusted);
    }

}