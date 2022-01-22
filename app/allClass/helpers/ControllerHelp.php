<?php


namespace App\allClass\helpers;

use App\allClass\helpers\response\MessageResponse;
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

}
