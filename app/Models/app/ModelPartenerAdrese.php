<?php

namespace App\Models\app;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;

class ModelPartenerAdrese extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_parteneri_adrese';
    }



    public function update($r){
        $rezult = DB::update(
            "update t_parteneri_adrese 
                            set cAdresa = :cAdresa, 
                                id_localitate= :id_localitate,
                                id_user= :id_user,
                                last_update = :lastUpdate
                    where id= :id;
            ",
             ['id' => $r['idPk'], 'cAdresa' => $r['adresa'], 'id_localitate' => $r['idLocalitate'], 'id_user'=>$this->idUser, 'lastUpdate'=> MyHelp::getCarbonDateNow()]
        );

        return $rezult;
    }

    public function insert($r){
        $rezult = DB::insert(
            "insert into t_parteneri_adrese (id_part, cAdresa, id_localitate, activ, id_user) values (:id_part, :cAdresa, :id_localitate, :activ, :id_user);",
            ['id_part' => $r['idPartener'], 'cAdresa' => $r['adresa'], 'id_localitate' => $r['idLocalitate'], 'activ' => 0, 'id_user'=>$this->idUser]
        );

        $lastIdInserted = DB::getPdo()->lastInsertId();
        $this->setDefaultAdress($lastIdInserted, $r['idPartener']);
        unset($rezult);

        return $lastIdInserted;
    }


    public function selectEntity($id){
        $rezult = DB::select(
            " SELECT `t_parteneri_adrese`.`id`,
                        `t_parteneri_adrese`.`id_part`,
                        `t_parteneri_adrese`.`cAdresa`,
                        `t_parteneri_adrese`.`id_localitate`,
                        `t_parteneri_adrese`.`activ`,
                        `t_parteneri_adrese`.`id_user`,
                        `t_parteneri_adrese`.`created`,
                        `t_parteneri_adrese`.`last_update`
                     FROM `t_parteneri_adrese`
	                 where t_parteneri.id = :id;"
            , ['id'=>$id]
        );

        return $rezult;
    }

	public function setDefaultAdress($id, $idPartner){

		// DB::rollback();
		DB::beginTransaction();

			$rezult = DB::update(
				"update t_parteneri_adrese 
						set activ = 0, 
							last_update = :lastUpdate, id_user = :id_user  
	                    where t_parteneri_adrese.id_part = :id_part and activ = 1;",
				['id_part'=> $idPartner, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser]
			);


			$rezult = DB::update(
				"update t_parteneri_adrese 
						set activ = 1,
							last_update = :lastUpdate, id_user = :id_user 
	                    where t_parteneri_adrese.id = :id;",
				['id'=> $id, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser]
			);

		DB::commit();

		return $rezult;
	}

    public function selectAdresePartener($idPartener){
        $rezult = DB::select(
            " SELECT t_parteneri_adrese.id,
		                    t_parteneri_adrese.id_part,
		                    t_parteneri_adrese.cAdresa,
                            concat(t_localitati.cLocalitate,'/ ',t_judete.cJudetAbrev, ' (', t_localitati_tip.cTip ,')') as localitate,
                            t_parteneri_adrese.activ,
		                    t_parteneri_adrese.id_localitate
                    FROM t_parteneri_adrese
		                inner join t_localitati on t_localitati.id = t_parteneri_adrese.id_localitate
		                inner join t_localitati_tip on t_localitati_tip.id = t_localitati.id_tip
                        inner join t_judete on t_judete.id = t_localitati.id_judet
                    where t_parteneri_adrese.id_part = :idPartener
                    order by activ desc;"
                , ['idPartener'=>$idPartener]
        );

        return $rezult;
    }

    public static function getObjectForUpdateInsert(){
        $arrayReturn = [
            'idPk'  => null,
            'idPartener'  => null,
            'adresa' => null,
            'idLocalitate' => 0
        ];

    }

}
