<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelnvoiceDetail extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_factura_d';
    }

    // getObjectForDetailInvoice
    public function insertDetailInvoice(array $a){
        $rezult = DB::insert(
            "insert into t_factura_d (id_factura, cText, nSumaFaraTva, nSumaTva, nTotal, id_user, created) values (:idFactura, :cText, :sumaFaraTva, :sumaTva, :total, :idUser, :created);",
            ['idFactura'=>$a['idInvoice'], 'cText'=>$a['name_articolFactura'], 'sumaFaraTva'=>$a['name_sumaArticol'], 'sumaTva'=>$a['sumaTva'], 'total'=>$a['nTotal'], 'idUser'=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow()]
        );
        $returnId = intval( DB::getPdo()->lastInsertId() );

        return $returnId;
    }

    public function deleteDetailInvoice($idPk){
        $rezult = DB::delete(
            "delete from t_factura_d where id_factura = :idFactura;",
            ['idFactura'=>$idPk]
        );

        return $rezult;
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

    public static function getObjectForDetailInvoice()
    {
        $arrayReturn = [
            'idPk' => null,
            'idInvoice' => null,
            'name_sumaArticol' => null,
            'name_articolFactura' => null,
            'sumaTva' => null,
            'nTotal' => null
        ];

        return $arrayReturn;
    }

}
