<?php


namespace App\allClass\helpers;

use App\MyAppConstants;

abstract class MyModel
{
    protected $request;
    protected $actionType;
    protected $tableName;


    public function __construct($request)
    {
        $this->request = $request;
        $this->actionType = $request->actionType;

    }

    protected function getIdFromRequest(){
        return $this->request->id;
    }

    public function action(){
        if($this->actionType == MyAppConstants::CLIENT_SQL_DELETE){
            $this->delete();
        }

        if($this->actionType == MyAppConstants::CLIENT_SQL_UPDATE){
            $this->update();
        }

        if($this->actionType == MyAppConstants::CLIENT_SQL_INSERT){
            $this->insert();
        }

        if($this->actionType == MyAppConstants::CLIENT_SQL_SELECT){
            $this->select();
        }
    }

    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract public function select();

}
