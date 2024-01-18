<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\WokingMonth;

class ModelAnafUploadInvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 'anaf_send_factura';
    }

	public function selectEntity($id){
        $rezult = DB::select(
            "
            select id, id_factura 
            from anaf_send_factura;
              where id = ?;
            ", [$id]
        );
        return $rezult;
    }

    public function selectEntityByIdInvoice($idInvoice){
        $rezult = DB::select(
            "
            select id, id_factura 
                from anaf_send_factura;
            where id_factura = ?;",
            [$idInvoice]
        );
        return $rezult;
    }


    public function checkSendInvoice($idInvoice){
        $rezult = DB::select(
            "
            select count(*) as send
            FROM  anaf_send_factura
               where id_factura = ?;",
            [$idInvoice]
        );
        return $rezult;
    }
}
