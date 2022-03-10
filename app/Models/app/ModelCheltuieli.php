<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\param\Expense;
use Illuminate\Support\Facades\DB;

class ModelCheltuieli extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_cheltuieli';
    }


	public function insertAntet(Expense $param){
			$rezult = DB::insert(
				"INSERT INTO t_cheltuieli(id_avocat,datac,an_datac,id_part,id_tipc,id_tipd,id_tipplata,cNrDoc,salvata,id_user,created) 
						values (:id_avocat,:datac,:an_datac,:id_part,:id_tipc,:id_tipd,:id_tipplata,:cNrDoc,:salvata,:id_user,:created);",
				["id_avocat"=>$this->idAvocat,"datac"=>$param->data_document,"an_datac"=>$param->data_year,"id_part"=>$param->id_partner,
				 "id_tipc"=>$param->id_tip_expense,"id_tipd"=>$param->id_tip_doc,"id_tipplata"=>$param->id_tip_plata,"cNrDoc"=>$param->nr_doc,
				  "salvata"=>0,"id_user"=>$this->idUse,"created"=>MyHelp::getCarbonDateNow()]
			);
        $returnId = intval( DB::getPdo()->lastInsertId() );

	}

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT id, id_avocat, datac, an_datac,
			    id_part, id_tipc, id_tipd, id_tipplata,
			    cNrDoc, salvata, 
			    id_user, created, last_update
			FROM t_cheltuieli where id=:id;",
            ['id'=>$id]
        );

        return $rezult;
    }

}

