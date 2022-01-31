<?php


namespace App\allClass\helpers;

use App\MyAppConstants;

abstract class MyModel
{
    protected $id;
    protected $idUser;
    protected $idAvocat;
    protected $tableName;
    protected $lastIdInsert;

    public function __construct($idAvocat, $idUser){
        $this->idAvocat = $idAvocat;
        $this->idUser = $idUser;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getLastIdInserted(){
        return $this->lastIdInsert;
    }

    public function setLastIdInserted($id){
        $this->lastIdInsert = $id;
    }

}
