<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\ParamAnafListaMesaje;


class ModelAnafListaMesaje extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 'anaf_lista_mesaje';
    }


    public function insertMessage(ParamAnafListaMesaje $param){
		$rezult = DB::insert(
			"insert into anaf_lista_mesaje (id_avocat,anaf_id,anaf_cif,anaf_id_solicitare,anaf_detalii,anaf_tip,anaf_data_creare,anaf_serial,anaf_data_creare_data,emitent_cif,emitent) 
             values (:idAvocat, :anaf_id,:anaf_cif,:anaf_id_solicitare,:anaf_detalii,:anaf_tip,:anaf_data_creare,:anaf_serial,:anaf_data_creare_data,:emitent_cif,:emitent);",
			[   'idAvocat' => $this->idAvocat, 
                'anaf_id'               => $param->anaf_id,
                'anaf_cif'              => $param->anaf_cif,             
                'anaf_id_solicitare'    => $param->anaf_id_solicitare,   
                'anaf_detalii'          => $param->anaf_detalii,         
                'anaf_tip'              => $param->anaf_tip,             
                'anaf_data_creare'      => $param->anaf_data_creare,     
                'anaf_serial'           => $param->anaf_serial,          
                'anaf_data_creare_data' => $param->anaf_data_creare_data,
                'emitent_cif'           => $param->emitent_cif,          
                'emitent'               => $param->emitent 
            ]
		);

		$lastIdInserted = DB::getPdo()->lastInsertId();

		return $lastIdInserted;
	}


    public function selectEntity($id){
        $rezult = DB::select(
            "
             SELECT id,
                id_avocat,
                anaf_id,
                anaf_cif,
                anaf_id_solicitare,
                anaf_detalii,
                anaf_tip,
                anaf_data_creare,
                anaf_serial,
                anaf_data_creare_data,
                emitent_cif,
                emitent,
                created_system
                    FROM anaf_lista_mesaje
                 where anaf_lista_mesaje.id = ?;",
            [$id]
        );
        return $rezult;
    }


    public function selectEntityByAnafIf($anafId){
        $rezult = DB::select(
            "
             SELECT id,
                id_avocat,
                anaf_id,
                anaf_cif,
                anaf_id_solicitare,
                anaf_detalii,
                anaf_tip,
                anaf_data_creare,
                anaf_serial,
                anaf_data_creare_data,
                emitent_cif,
                emitent,
                created_system
                    FROM anaf_lista_mesaje
                 where anaf_id = ?;",
            [$anafId]
        );
        return $rezult;
    }

   
}
