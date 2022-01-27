<?php


namespace App\allClass\helpers\response;


class SqlMessageResponse
{
    public $succes;                     //  true, false
	public $lastId;                     // 0 is not valid, lasta id inserted
    public $messages;                   // string
	public $errorMsg;                   // string
	public $admin;                      // true false, on client show $errorMsg on windows alert
    public $records;                    // data returned

    function __construct($succes, $lastId, $messages, $records, $errorMsg=null, $admin=false) {
        $this->succes = $succes;
        $this->messages = $messages;
	    $this->errorMsg = $errorMsg;
        $this->lastId = $lastId;
	    $this->admin = $admin;
	    $this->records = $records;
    }
}
