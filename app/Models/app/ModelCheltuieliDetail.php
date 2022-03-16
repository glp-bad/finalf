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


    public function deleteExpenseArticle($id){
        $rezult = DB::delete(
            "DELETE t_cheltuieli_d
                    FROM t_cheltuieli_d
                    INNER JOIN t_cheltuieli ON t_cheltuieli.id = t_cheltuieli_d.id_chlet
                    where t_cheltuieli_d.id = :id and t_cheltuieli.salvata = :salvata;",
            ['id'=>$id, 'salvata'=> 0 ]
        );

        return $rezult;
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

	public function selectDetailList($idExpense){
		$rezult = DB::select(
			" 
			     select 
			     	t_cheltuieli_d.id, 
			     	@i:=@i+1 row_num,
			     	t_tip_cheltuieli_categorii.cTipCat as tip_cat,
					t_produse.cProd as produs, t_tip_um.cTipabr as um,
					t_cheltuieli_d.nCant as cantitate,
				    t_cheltuieli_d.nPretU as pret_unitar,
				    t_cheltuieli_d.nTotalFaraTva as total_fara_tva,
				    t_cheltuieli_d.nTotalTva as total_tva,
				    t_cheltuieli_d.nTotalFaraTva + t_cheltuieli_d.nTotalTva as total,
				    t_cheltuieli_d.nProcentTva as procent_tva
				 from 
					t_cheltuieli_d 
				    inner join t_tip_cheltuieli_categorii on t_tip_cheltuieli_categorii.id = t_cheltuieli_d.id_tipcat 
				    inner join t_produse on t_produse.id = t_cheltuieli_d.id_prod
				    inner join t_tip_um on t_tip_um.id = t_cheltuieli_d.id_tipm,
				     (SELECT @i:=0) AS R
				   where id_chlet = :idExpense
				   order by id asc;"
			,["idExpense"=>$idExpense]
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

