<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\MyAppConstants;

class ModelAnafUrl extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 'anaf_url';
    }

	
    public function selectEntity($id){
        $rezult = DB::select(
            "
            SELECT  anaf_url.id ,
                    anaf_url.aplicatie ,
                    anaf_url.mediu ,
                    anaf_url.action ,
                    anaf_url.url ,
                    anaf_url.created ,
                    anaf_url.updated 
                FROM anaf_url  
                 where id = ?;",
            [$id]
        );
        return $rezult;
    }

    public function selectUrl($app, $mediu){
        $rezult = DB::select(
            "
            SELECT  anaf_url.id ,
                    anaf_url.aplicatie ,
                    anaf_url.mediu ,
                    anaf_url.action ,
                    anaf_url.url ,
                    anaf_url.created ,
                    anaf_url.updated 
                FROM anaf_url  
                 where aplicatie = ? AND mediu = ?;",
            [$app, $mediu]
        );
        return $rezult;
    }
}
