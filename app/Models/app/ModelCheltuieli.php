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


    public function deleteCheltuialaSalvata($idPk){
        $rezult = DB::delete(
            "delete from t_cheltuieli where id = :id and id_avocat = :idAvocat and salvata = :salvata;",
            ['id'=>$idPk, 'idAvocat'=>$this->idAvocat, 'salvata'=>1]
        );

        return $rezult;
    }

    public function deleteAntet($idPk){
        $rezult = DB::delete(
            "delete from t_cheltuieli where id = :id and id_avocat = :idAvocat and salvata = :salvata;",
            ['id'=>$idPk, 'idAvocat'=>$this->idAvocat, 'salvata'=>0]
        );

        return $rezult;
    }

	// daca exista document in lucru
	public function checkWorkingExpense(){
		$rezult = DB::select(
			"SELECT t_cheltuieli.id,
						   t_cheltuieli.id_avocat,
						   t_cheltuieli.datac,
						   t_cheltuieli.an_datac,
						   t_cheltuieli.id_part,
					       concat(t_parteneri.cNume,'/ ',t_parteneri.cui) as partner_name,
						   t_cheltuieli.id_tipc,
					       t_tip_cheltuieli.tipc as tip_cheltuiala,
						   t_cheltuieli.id_tipd,
					       concat(t_tip_document.tipc, ' (', t_tip_document.abrev, ')') as tip_document,
						   t_cheltuieli.id_tipplata,
					       t_tip_plata.tipplata as tip_plata,
						   t_cheltuieli.cNrDoc,
						   t_cheltuieli.salvata
					FROM t_cheltuieli 
						inner join t_parteneri on t_parteneri.id = t_cheltuieli.id_part
					    inner join t_tip_cheltuieli on t_tip_cheltuieli.id = t_cheltuieli.id_tipc
					    inner join t_tip_document on t_tip_document.id = t_cheltuieli.id_tipd
					    inner join t_tip_plata on t_tip_plata.id = t_cheltuieli.id_tipplata
						where t_cheltuieli.id_avocat = :idAvocat and t_cheltuieli.salvata = :salvata;",
			['idAvocat'=>$this->idAvocat, 'salvata'=> 0]
		);

		return $rezult;
	}

	public function insertAntet(Expense $param){
		$rezult = DB::insert(
			"INSERT INTO t_cheltuieli(id_avocat,datac,an_datac,id_part,id_tipc,id_tipd,id_tipplata,cNrDoc,salvata,id_user,created) 
					values (:id_avocat,:datac,:an_datac,:id_part,:id_tipc,:id_tipd,:id_tipplata,:cNrDoc,:salvata,:id_user,:created);",
			["id_avocat"=>$this->idAvocat,"datac"=>$param->data_document,"an_datac"=>$param->data_year,"id_part"=>$param->id_partner,
			 "id_tipc"=>$param->id_tip_expense,"id_tipd"=>$param->id_tip_doc,"id_tipplata"=>$param->id_tip_plata,"cNrDoc"=>$param->nr_doc,
			  "salvata"=>0,"id_user"=>$this->idUser,"created"=>MyHelp::getCarbonDateNow()]
		);

        $returnId = intval( DB::getPdo()->lastInsertId() );

        return $returnId;
	}


	public function saveExpense($id) {
		$rezult = DB::update(
			" 
             update t_cheltuieli
                set salvata = 1,
                	id_user = :idUser,
                	last_update = :lastUpdate  
             where id=:id01 and id_avocat = :idAvocat
             	   and (SELECT COUNT(*) nr_rec from t_cheltuieli_d where t_cheltuieli_d.id_chlet = :id02) > 0;",
			["idUser"=>$this->idUser, ":lastUpdate"=>MyHelp::getCarbonDateNow(), 'id01'=>$id, 'id02'=>$id ,'idAvocat'=>$this->idAvocat]
		);

		return $rezult;
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

