<?php

namespace marius321967\Messages;

/**
 * Container
 */
class Message {

    private $message;
    private $type;
    private $trusted;

    /**
     * @param string $message
     * @param string $type
     * @param bool $trusted Whether message can be rendered unsanitized
     */
    public function __construct(string $message, string $type, bool $trusted) {
        $this->message = $message;
        $this->type = $type;
        $this->trusted = $trusted;
    }
    
    public function message(): string {
        return $this->message;
    }

    public function type(): string {
        return $this->type;
    }

    /**
     * Whether message can be rendered unsanitized
     * @return boolean
     */
    public function trusted(): bool {
        return $this->trusted;
    }

}