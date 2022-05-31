<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\MyHelp;

class ModelNomProduse extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_produse';
    }

	public function insert($productName){
		$rezult = DB::insert(
			"insert into t_produse (id_avocat, cProd, id_user) values (:idAvocat, :product_name, :idUser);",
			['idAvocat' => $this->idAvocat, 'product_name' => $productName, 'idUser'=>$this->idUser]
		);

		$lastIdInserted = DB::getPdo()->lastInsertId();
		return $lastIdInserted;
	}

	public function update($id, $productName){
		$rezult = DB::update(
			"update t_produse 
                            set cProd = :product_name, 
                                id_user= :idUser,
                                last_update = :lastUpdate
                    where id= :id and id_avocat = :idAvocat;
            ",
			['id'=>$id, 'idAvocat' => $this->idAvocat, 'product_name' => $productName, 'idUser'=>$this->idUser, 'lastUpdate'=> MyHelp::getCarbonDateNow()]
		);

		return $rezult;
	}

	public function selectAllProduct(){
		$rezult = DB::select("
                    select id, cProd as product_name 
                        from t_produse
                    where t_produse.id_avocat= :idAvocat
                    order by t_produse.cProd ASC ",
			['idAvocat'=> $this->idAvocat]
		);

		return $rezult;
	}

    public function selectForSearchDropDown($wordSearch){
        $rezult = DB::select("
	                    SELECT t_produse.id,
	                            t_produse.cProd as caption
						from t_produse 
	                    where t_produse.id_avocat= :idAvocat
	                        and t_produse.cProd like '%$wordSearch%'
	                    order by t_produse.cProd",
            ['idAvocat'=> $this->idAvocat]
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            "SELECT id, id_avocat, cProd,
					       id_user, created, last_update
					FROM t_produse where id = ?;"
            , ['id'=>$id]
        );

        return $rezult;
    }



}
