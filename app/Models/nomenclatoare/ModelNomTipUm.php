<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomTipUm extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_tip_um';
    }

    public function selectForSimpleDropDown(){
        $rezult = DB::select(
            "select id, concat(cTip, ' (', cTipabr, ')') as text, zecimale, 'false' as selected from t_tip_um order by cTip;"
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " select id, cTip, cTipabr, zecimale, concat(cTip, ' (', cTipabr, ')') as text from t_tip_um where id = ?;",[$id]
        );

        return $rezult;
    }
    // DB::enableQueryLog(); // Enable query log
    // dd(DB::getQueryLog()); // Show results of log
}
