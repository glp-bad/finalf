<?php

namespace App\Models\nomenclatoare;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelNomLocalitati extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_tip_organizare_juridica';
    }

    public function update(){}
    public function delete(){}
    public function insert(){}


    public function selectForSearchDropDown($wordSearch){

    	if(empty($wordSearch)) {
		    $rezult = DB::select("
	                    SELECT t_localitati.id,
	                            concat(t_localitati.cLocalitate,'/ ',t_judete.cJudetAbrev, ' (', t_localitati_tip.cTip ,')') as caption
						from t_localitati 
							 inner join t_localitati_tip on t_localitati_tip.id = t_localitati.id_tip
	                         inner join t_judete on t_judete.id = t_localitati.id_judet
	                    order by t_localitati.cLocalitate   
	            ");

	    }else {
		    $rezult = DB::select("
					select a.id, a.caption
					FROM 
					(
	                    SELECT t_localitati.id,
	                            concat(t_localitati.cLocalitate,'/ ',t_judete.cJudetAbrev, ' (', t_localitati_tip.cTip ,')') as caption
						from t_localitati 
							 inner join t_localitati_tip on t_localitati_tip.id = t_localitati.id_tip
	                         inner join t_judete on t_judete.id = t_localitati.id_judet
	                    order by t_localitati.cLocalitate   
	                ) a    
	                where a.caption like '%$wordSearch%'
            ");

	    }

        return $rezult;
    }

}
