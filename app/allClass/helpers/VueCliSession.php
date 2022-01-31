<?php


namespace App\allClass\helpers;


use App\MyAppConstants;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class VueCliSession
{
    private $sessionVariable;
    private $env;

    function __construct() {
        $this->sessionVariable = array();
        $this->env = env('VUE_APP_ENV');
        $this->setVueCliVariable();
    }

    public function put($variable, $value){
        if($this->env != MyAppConstants::VUE_APP_ENV){
            Session::put($variable, $value);
        }
    }

    public function get($variable, $defaultValue = null){
        $returnValue = $defaultValue;

        if($this->env == MyAppConstants::VUE_APP_ENV){
            if (array_key_exists($variable, $this->sessionVariable)) {
                $returnValue = $this->sessionVariable[$variable];
            }
        }else{
            $returnValue = Session::get($variable, $defaultValue);
        }
        return $returnValue;
    }

    public function flush(){
        if($this->env != MyAppConstants::VUE_APP_ENV){
            Session::flush();
        }
    }

    public function logout(){
        if($this->env != MyAppConstants::VUE_APP_ENV) {
            Auth::logout();
        }
    }

    public function authCheck(){
        $authCheckReturn = false;

        if($this->env == MyAppConstants::VUE_APP_ENV){
            $authCheckReturn = $this->sessionVariable[MyAppConstants::IS_LOGIN];
        }else{
            $authCheckReturn = Auth::check();
        }

        return $authCheckReturn;
    }

    private function setVueCliVariable(){
        // for testing vue jsclient serve
        if($this->env == MyAppConstants::VUE_APP_ENV){
            $this->sessionVariable[MyAppConstants::ID_USER] = 3;
            $this->sessionVariable[MyAppConstants::IS_LOGIN] = true;
            $this->sessionVariable[MyAppConstants::USER_ID_LOGEED] = 3;
            $this->sessionVariable[MyAppConstants::ID_AVOCAT] = 6;
            $this->sessionVariable[MyAppConstants::USER_EMAIL_LOGGED] = 'vuejsclient@finalf.com';

        }
    }

}
