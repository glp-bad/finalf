<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomProduse extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_produse';
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
