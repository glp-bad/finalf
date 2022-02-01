<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelnvoiceDetail extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_factura_d';
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             select `t_factura_d`.`id`,
                    `t_factura_d`.`id_factura`,
                    `t_factura_d`.`cText`,
                    `t_factura_d`.`nSumaFaraTva`,
                    `t_factura_d`.`nSumaTVA`,
                    `t_factura_d`.`nTotal`,
                    `t_factura_d`.`id_user`,
                    `t_factura_d`.`created`,
                    `t_factura_d`.`last_update`
                FROM `t_factura_d`
                    where t_factura_d.id = ?;",[$id]
        );

        return $rezult;
    }




}
