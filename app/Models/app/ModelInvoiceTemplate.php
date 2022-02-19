<?php

namespace App\Models\app;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelInvoiceTemplate extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_tip_template_factura';
    }


    public function selectForSimpleDropDown(){
        $rezult = DB::select(
            "select id, ctf as text, 'false' as selected from t_tip_template_factura where id_avocat= :idAvocat order by id;",
            ['idAvocat'=>$this->idAvocat]
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT `t_tip_template_factura`.`id`,
                    `t_tip_template_factura`.`id_avocat`,
                    `t_tip_template_factura`.`ctf`,
                    `t_tip_template_factura`.`id_user`,
                    `t_tip_template_factura`.`created`,
                    `t_tip_template_factura`.`last_update`
                FROM `t_tip_template_factura`
                    where t_tip_template_factura.id = ?;",[$id]
        );

        return $rezult;
    }




}
