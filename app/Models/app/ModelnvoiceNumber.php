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




}
