<?php


namespace App\allClass\helpers\response;

class ValidateParam
{
    public $succes;                     //  true, false
	public $messages;                   // array

    function __construct(bool $succes, array $messages) {
        $this->succes = $succes;
        $this->messages = $messages;
    }

}
