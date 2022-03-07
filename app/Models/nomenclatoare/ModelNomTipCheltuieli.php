<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomTipCheltuieli extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_tip_cheltuieli';
    }

    public function selectForSimpleDropDown(){
        $rezult = DB::select(
            "select id, tipc as text, 'false' as selected from t_tip_cheltuieli order by id;"
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " select id, tipc from t_tip_cheltuieli where id = ?;",[$id]
        );

        return $rezult;
    }
    // DB::enableQueryLog(); // Enable query log
    // dd(DB::getQueryLog()); // Show results of log
}
