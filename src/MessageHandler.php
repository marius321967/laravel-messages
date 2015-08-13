<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 7/5/15
 * Time: 2:11 PM
 */

namespace marius321967\Messages;


class MessageHandler {

    protected $messages = [];

    protected $flash_messages = [];

    public function __construct() {
        if (\Session::has('flash_messages')) {
            $this->messages = \Session::get('flash_messages');
        }
    }

    public function getAll() {
        return $this->messages;
    }

    public function getFlash() {
        return $this->flash_messages;
    }

    public function add($message, $type = 'info') {
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

}