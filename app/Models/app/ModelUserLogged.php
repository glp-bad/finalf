<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\MyHelp;
use App\MyAppConstants;
use Illuminate\Support\Facades\DB;

class ModelUserLogged extends MyModel {

    private $idUserLogin;
    private $lastAction;
    private $logged;
    private $email;

    public function __construct($email, $idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser, $email);

        $this->tableName = 'users_login';
        $this->email = $email;

        ModelUserLogged::setDBConnection($email);

        $this->getUserFromDataBase();

        if($this->idUserLogin == null && $this->idUser != null){
            $this->insert();
        }else{

        }
    }

    public function update(){
    }

    public function selectForEdit($idPk){
    }

    public function getIdUserLogged(){
        return $this->idUserLogin;
    }

    public function isAllreadyLogin(){
        $return = false;
        if($this->logged == 1){
            $return = true;
        }
        return $return;
    }

    public static function logInOut($idUserLogin, $onOff, $emailLogin = null){

    	ModelUserLogged::setDBConnection($emailLogin);

        $result = DB::update( 'update users_login set logged = ?, last_action = ? where id_user = ?', [$onOff , MyHelp::getCarbonDateNow(),  $idUserLogin]);
    }

    public static function setDBConnection($email){
	    if($email && $email == MyAppConstants::DATABASE_USER_ANONIMUS){
		    DB::setDefaultConnection(MyAppConstants::DATABASE_ANONIMUS);
	    }
    }

    public function delete(){}
    public function select(){}

    public function expireLogIn(){

        if($this->idUser != null) {

            if(empty($this->lastAction)){
                $this->lastAction = now()->toDateTimeString();
            }

            $lastAction = MyHelp::getCarbonDate('Y-m-d H:i:s', $this->lastAction);

            $limitTime = $lastAction->diffInMinutes(MyHelp::getCarbonDateNow());

            if ($limitTime > env('SESSION_LIFETIME')) {
                self::logInOut($this->idUserLogin, MyAppConstants::USER_LOGOFF);
                $this->logged = MyAppConstants::USER_LOGOFF;
            }
        }
    }

    public function insert(){
        $this->lastAction = now()->toDateTimeString();
        $this->logged = MyAppConstants::USER_LOGOFF;
        $result = DB::insert( 'insert into users_login (id_user, last_action, logged) values (?,?,?) ', [$this->idUser, $this->lastAction, $this->logged]);
        $this->idUserLogin = DB::getPdo()->lastInsertId();
    }


    private function getUserFromDataBase(){

        $result = DB::select( 'select users.id, users_login.id as users_login_id, users_login.last_action, users_login.logged, users.name 
                                        from users 
                                        left join users_login on users.id = users_login.id_user 
                                       where users.email = ?', [$this->email]
        );

        if($result ) {
            $this->idUser       = $result[0]->id;
            $this->idUserLogin  = $result[0]->id;
            $this->lastAction   = $result[0]->last_action;
            $this->logged       = $result[0]->logged;
        }
    }

}
