<?php


namespace App\allClass\helpers;

use App\MyAppConstants;

abstract class MyModel
{
    protected $id;
    protected $idAvocat;
    protected $tableName;

    public function __construct(){}

    public function setIdAvocat($id){
        $this->idAvocat = $id;
    }

    public function setId($id){
        $this->id = $id;
    }

    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract public function select();

}
