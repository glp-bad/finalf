<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomTipDocument extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_tip_incasare';
    }

    public function selectForSimpleDropDown(){
        $rezult = DB::select(
            "select id, concat(tipc, ' (', abrev, ')') as text, 'false' as selected from t_tip_document order by id;"
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " select id, tipc, abrev, concat(tipc, ' (', abrev, ')') as text from t_tip_document where id = ?;",[$id]
        );

        return $rezult;
    }
    // DB::enableQueryLog(); // Enable query log
    // dd(DB::getQueryLog()); // Show results of log
}
