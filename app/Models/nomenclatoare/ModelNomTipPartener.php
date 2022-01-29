<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomTipPartener extends MyModel {
    public function __construct()
    {
        parent::__construct();
        $this->tableName = 't_tip_organizare_juridica';
    }

    public function update(){}
    public function delete(){}
    public function insert(){}


    public function selectForSimpleDropDown(){
        $rezult = DB::select(
            "select id, CONCAT(cTipAbrev, ' (', cTip, ')') as text, 'false' as selected from t_tip_organizare_juridica order by id;"
        );

        return $rezult;
    }

    public function select(){
        // DB::enableQueryLog(); // Enable query log
        // dd(DB::getQueryLog()); // Show results of log
        $rezult = DB::select(
            " select id, cTip, cTipAbrev from t_tip_organizare_juridica order by id;"
        );

        return $rezult;
    }

    public function selectForEdit($idPk){}
}
