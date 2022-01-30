<?php


namespace App\allClass\helpers;

use App\allClass\helpers\response\MessageResponse;
use App\allClass\helpers\response\SqlMessageResponse;
use App\MyAppConstants;
use App;

trait ControllerHelp
{
    public function getSession(){
        return App::make(MyAppConstants::MY_SESSION);
    }

    /**
     * @param $succes
     * @param $message              array
     * @return MessageResponse
     */
    public function getMessageResponse($succes, $message){
        return new MessageResponse($succes, $message);
    }


    /**
     * @param $succes
     * @param $messages
     * @param $lastId
     * @param null $records
     * @param null $errorMsg
     * @param bool $admin
     * @return SqlMessageResponse
     */
    public function getSqlMessageResponse($succes, $messages, $lastId, $records=null, $errorMsg=null, $admin=false){
        return new SqlMessageResponse($succes, $lastId, $messages, $records, $errorMsg, $admin);
    }

}
