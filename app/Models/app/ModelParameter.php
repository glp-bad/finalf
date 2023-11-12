<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\param\Expense;
use Illuminate\Support\Facades\DB;

class ModelParameter extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 'e_parameter';
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " select id, id_avocat, parameter, value, description 
               from e_parameter 
               where id = :id and id_avocat = :idAvocat;"
            ,['id'=>$id , 'idAvocat' => $this->idAvocat]
        );

        return $rezult;
    }

    public function getParameter($param){
        $rezult = DB::select(
            " select parameter, value
               from e_parameter 
               where parameter = :param and id_avocat = :idAvocat;"
            ,['param'=>$param , 'idAvocat' => $this->idAvocat]
        );

        return $rezult;
    }


    public function getBussinesAllParameter(){
        $rezult = DB::select(
            " select parameter, value
               from e_parameter 
               where id_avocat = :idAvocat;"
            ,['idAvocat' => $this->idAvocat]
        );
        
        $arrayReturn = array();
        foreach($rezult as $r => $v){
            $arrayReturn[$v->parameter] = $v->value;
        }

        return $arrayReturn;
    }

}

