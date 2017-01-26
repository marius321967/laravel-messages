<?php

namespace marius321967\Messages;

class InfoMessage {

    protected $message;

    /**
     * Carries info whether message represents a success, error, alert etc.
     * @var string
     */
    protected $notificationType;

    /**
     * @var bool
     */
    protected $shouldEscapeHtml;


    public function __construct($params = []) {
        foreach ($params as $key => $value)
            if (property_exists(get_class($this), $key))
                $this->{$key} = $value;
    }

    public function message() {
        return $this->message;
    }

    public function notificationType() {
        return $this->notificationType;
    }

    /**
     * @return bool
     */
    public function shouldEscapeHtml() {
        return $this->shouldEscapeHtml;
    }

    public function toArray() {
        return [
            'message' => $this->message,
            'notificationType' => $this->notificationType,
            'shouldEscapeHtml' => $this->shouldEscapeHtml,
        ];
    }

    public static function buildFromArray($data) {
        return new self($data);
    }

}