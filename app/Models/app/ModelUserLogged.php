<?php


namespace App\Models\app;
use App\allClass\helpers\MyModel;
use App\MyAppConstants;
use Illuminate\Support\Facades\DB;

class ModelUserLogged extends MyModel {

    private $idUser;
    private $idUserLogin;
    private $lastAction;
    private $logged;
    private $email;

    public function __construct($request)
    {
        parent::__construct($request);
        $this->tableName = 'users_login';
        $this->email = $request->credentials['email'];
        $this->getUserFromDataBase();

        if($this->idUserLogin == null){
            $this->actionType = MyAppConstants::CLIENT_SQL_INSERT;
            // $this->insert();
        }else{
            $this->actionType = MyAppConstants::CLIENT_SQL_UPDATE;
        }



    }

    public function update(){

    }

    public function delete(){
    }

    public function insert(){
        $this->lastAction = now()->toDateTimeString();
        $this->logged = MyAppConstants::USER_LOGON;
        $result = DB::insert( 'insert into users_login (id_user, last_action, logged) values (?,?,?) ', [$this->idUser, $this->lastAction, $this->logged]);
        $this->idUserLogin = DB::getPdo()->lastInsertId();
        $this->actionType - MyAppConstants::CLIENT_SQL_UPDATE;
    }

    public function select(){
    }

    private function getUserFromDataBase(){
        $result = DB::select( 'select users.id, users_login.id as users_login_id, users_login.last_action, users_login.logged from users left join users_login on users.id = users_login.id_user where email = ?', [$this->email]);

        $this->idUser = $result[0]->id;
        $this->idUserLogin = $result[0]->users_login_id;
        $this->lastAction = $result[0]->last_action;
        $this->logged = $result[0]->logged;
    }

}
