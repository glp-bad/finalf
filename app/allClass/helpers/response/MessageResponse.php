<?php


namespace App\allClass\helpers\response;


class MessageResponse
{
    public $succes;                     // true or false
    public $messages;                   // []

    function __construct($succes, $messages) {
        $this->succes = $succes;
        $this->messages = $messages;
    }

    function toJson(){
        return json_encode($this);
    }
}
