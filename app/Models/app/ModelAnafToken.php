<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\WokingMonth;

class ModelAnafToken extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 'anaf_token';
    }

	public function checkMonth(WokingMonth $param){
		$rezult = DB::update(
			"update t_s_luni_inchise 
						set inchisa = :inchisa,
							last_update = :lastUpdate, id_user = :id_user 
	                    where id = :id and id_avocat = :idAvocat;",
			['id'=> $param->id, 'inchisa'=> $param->check, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser, 'idAvocat' => $this->idAvocat]
		);

		return $rezult;
	
    }    

    public function selectEntity($id){
        $rezult = DB::select(
            "
            SELECT  anaf_token.id ,
                    anaf_token.id_avocat ,
                    anaf_token.client_id ,
                    anaf_token.client_secret ,
                    anaf_token.refresh_token ,
                    anaf_token.acces_token ,
                    anaf_token.valid_until ,
                    anaf_token.updated,
                    DATEDIFF(anaf_token.valid_until, now()) valid_day,
                    now() as currentdate 
            FROM  anaf_token 
                 where id = ?;",
            [$id]
        );
        return $rezult;
    }

    public function selectEntityByAvocat(){
        $rezult = DB::select(
            "
            SELECT  anaf_token.id ,
                    anaf_token.id_avocat ,
                    anaf_token.client_id ,
                    anaf_token.client_secret ,
                    anaf_token.refresh_token ,
                    anaf_token.acces_token ,
                    anaf_token.valid_until ,
                    anaf_token.updated,
                    DATEDIFF(anaf_token.valid_until, now()) valid_day,
                    now() as currentdate 
            FROM  anaf_token 
                 where id_avocat = ?;",
            [$this->idAvocat]
        );
        return $rezult;
    }
}
