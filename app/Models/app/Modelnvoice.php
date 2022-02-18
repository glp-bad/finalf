<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class Modelnvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_factura';
    }


    public function insert($id){
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT `t_factura`.`id`,
                    `t_factura`.`id_nr`,
                    `t_factura`.`data_f`,
                    `t_factura`.`id_part`,
                    `t_factura`.`id_tipfactura`,
                    `t_factura`.`nProcTVA`,
                    `t_factura`.`salvata`,
                    `t_factura`.`id_user`,
                    `t_factura`.`created`,
                    `t_factura`.`last_update`,
                    `t_factura`.`id_avocat`
              FROM  `t_factura`
                    where t_factura.id = ?;",[$id]
        );

        return $rezult;
    }



    public static function getObjectInseretAntet(){
        $arrayReturn = [
            'idPk'  => null,
            'idPartener'  => null,
            'adresa' => null,
            'idLocalitate' => 0
        ];

    }

}
