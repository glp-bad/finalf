<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\param\ExpenseArticol;
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

    public function insertDetailExpense(ExpenseArticol $p){
        $rezult = DB::insert(
            "INSERT INTO t_cheltuieli_d (id_chlet,id_prod,id_tipm,id_tipcat,nCant,nPretU,nTotalFaraTva,nTotalTva,nProcentTva,id_user,created) values(:id_chlet,:id_prod,:id_tipm,:id_tipcat,:nCant,:nPretU,:nTotalFaraTva,:nTotalTva,:nProcentTva,:id_user,:created);",
            ['id_chlet'=>$p->id_exepense,'id_prod'=>$p->id_product, 'id_tipm'=>$p->id_um,'id_tipcat'=>$p->id_cat_chelt, 'nCant'=>$p->cantitate,
             'nPretU'=>$p->pret_unitar,'nTotalFaraTva'=>$p->total_fara_tva, 'nTotalTva'=>$p->total_tva,'nProcentTva'=>$p->procent_tva, 'id_user'=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow()]
        );
        $returnId = intval( DB::getPdo()->lastInsertId() );

        return $returnId;
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

