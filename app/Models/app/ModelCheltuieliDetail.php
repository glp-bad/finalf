<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelCheltuieliDetail extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_cheltuieli_d';
    }

    public function deleteDetailExpense($idExpense){
        $rezult = DB::delete(
            "delete from t_cheltuieli_d where id_chlet = :idExpense;",
            ['idExpense'=>$idExpense]
        );
        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT id,
    				id_chlet,
    				id_prod,
    				id_tipm,
    				id_tipcat,
    				nCant,
    				nPretU,
    				nTotalFaraTva,
    				nTotalTva,
    				nProcentTva,
    				id_user,
    				created,
    				last_update
			 FROM t_cheltuieli_d 
				where id=:id;",
            ['id'=>$id]
        );

        return $rezult;
    }

}

