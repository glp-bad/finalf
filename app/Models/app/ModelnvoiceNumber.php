<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelnvoiceNumber extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_facturi_numar';
    }


    /*
      @_fnTip tinyint,      -- 1 factura, 2 chitanta
        set @LitereNrFactura  = 'FAGD '

        if @_fnTip = 2 set @LitereNrFactura  = 'CAGD '
            public function insert($id){

            }

    set @cZero = replicate('0',8-@nLung)
    */

    public function getNumber($nTip){
        $checkNrNefolosit = DB::select(
            " 
             SELECT id from t_facturi_numar where id_avocat = :idAvocat and nTip = :nTip and folosit = 0 order by nNr asc limit 1
                    ",["idAvocat"=>$this->idAvocat, "nTip"=>$nTip]
        );

        // avem numar nefolosit
        if(!empty($checkNrNefolosit)){

        }else{
            // generam un numar nou


        }




        dd($checkNrNefolosit);
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT `t_facturi_numar`.`id`,
                    `t_facturi_numar`.`id_avocat`,
                    `t_facturi_numar`.`nTip`,
                    `t_facturi_numar`.`nNr`,
                    `t_facturi_numar`.`cNr`,
                    `t_facturi_numar`.`folosit`,
                    `t_facturi_numar`.`manual`,
                    `t_facturi_numar`.`id_user`,
                    `t_facturi_numar`.`created`,
                    `t_facturi_numar`.`last_update`
              FROM `t_facturi_numar`
                    where id = ?;",[$id]
        );

        return $rezult;
    }


    public static function getObjectInseret(){
        $arrayReturn = [
            'idPk'  => null,
            'adresa' => null,
            'idLocalitate' => 0
        ];

    }



}
