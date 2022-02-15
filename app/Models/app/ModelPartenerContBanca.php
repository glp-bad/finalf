<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelPartenerContBanca extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_parteneri_banca';
    }

    public function update($r){
        $rezult = DB::update(
            "update t_parteneri_banca 
                            set cBanca = :banca,
                                cSucursala= :sucursala ,
                                cIBAN= :iban,
                                id_user= :id_user,
                                last_update = :lastUpdate
                    where id= :id;
            ",
             ['id' => $r['idPk'], 'banca' => $r['banca'], 'sucursala' => $r['sucursala'],'iban' => $r['iban'], 'id_user'=>$this->idUser, 'lastUpdate'=> MyHelp::getCarbonDateNow()]
        );

        return $rezult;
    }

    public function insert($r){
        $rezult = DB::insert(
            "insert into t_parteneri_banca (id_part, cBanca, cSucursala, cIBAN, activ, id_user) values (:id_part, :banca, :sucursala, :iban, :activ, :id_user);",
            ['id_part' => $r['idPartener'], 'banca' => $r['banca'], 'sucursala' => $r['sucursala'],'iban' => $r['iban'], 'activ' => 1, 'id_user'=>$this->idUser]
        );

        $lastIdInserted = DB::getPdo()->lastInsertId();
        $this->setDefaultCont($lastIdInserted, $r['idPartener']);
        unset($rezult);

        return $lastIdInserted;
    }

	public function setDefaultCont($id, $idPartner){

		// DB::rollback();
		DB::beginTransaction();

			$rezult = DB::update(
				"update t_parteneri_banca 
						set activ = 0, 
							last_update = :lastUpdate, id_user = :id_user  
	                    where id_part = :id_part and activ = 1;",
				['id_part'=> $idPartner, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser]
			);


			$rezult = DB::update(
				"update t_parteneri_banca 
						set activ = 1,
							last_update = :lastUpdate, id_user = :id_user 
	                    where id = :id;",
				['id'=> $id, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser]
			);


		DB::commit();

		return $rezult;
	}

    public function selectConturiPartener($idPartener){

        $rezult = DB::select(
            "SELECT id, id_part, cBanca, cSucursala, cIBAN, activ                    
                    FROM 
                          t_parteneri_banca 
                    where id_part = :idPartener
                    order by activ desc"
                , ['idPartener'=>$idPartener]
        );

        return $rezult;
    }


    public function selectEntity($id){
        $rezult = DB::select(
            " SELECT `t_parteneri_banca`.`id`,
                        `t_parteneri_banca`.`id_part`,
                        `t_parteneri_banca`.`cBanca`,
                        `t_parteneri_banca`.`cSucursala`,
                        `t_parteneri_banca`.`cIBAN`,
                        `t_parteneri_banca`.`activ`,
                        `t_parteneri_banca`.`id_user`,
                        `t_parteneri_banca`.`created`,
                        `t_parteneri_banca`.`last_update`
                    FROM `badminto_finalf`.`t_parteneri_banca` 
	                where t_parteneri.id = :id;"
            , ['id'=>$id]
        );

        return $rezult;
    }

    public static function getObjectForUpdateInsert(){
        $arrayReturn = [
            'idPk'  => null,
            'idPartener'  => null,
            'banca' => null,
            'sucursala' => null,
            'iban' => null
        ];

    }

}
