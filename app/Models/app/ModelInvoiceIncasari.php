<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\param\SaveIncoming;
use Illuminate\Support\Facades\DB;

class ModelInvoiceIncasari extends MyModel {
    public function __construct($idAvocat, $idUser) {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_incasari_facturi';
    }

    public function saveIncoming(SaveIncoming $d){
        $rezult = DB::insert(
            "insert into t_incasari_facturi (id_factura,id_nr,id_tipd,id_incas,data_incas,nSuma,id_user,created) values (:idf, :idnr, :idtipd, :idincas, :dataincas, :suma, :idUser, :created);",
            ["idf"=>$d->id_invoice, "idnr"=>$d->id_nr_invoice, "idtipd"=>$d->name_nomDocumentType, "idincas"=>$d->tipIncasare, "dataincas"=>$d->name_invoiceDate, "suma"=>$d->name_amountRecived, "idUser"=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow()]
        );
        $returnId = intval( DB::getPdo()->lastInsertId() );
    }

    public function selectEntity($id) {
         $rezult = DB::select(
             " 
                  SELECT t_incasari_facturi.id,
                         t_incasari_facturi.id_factura,
                         t_incasari_facturi.id_nr,
                         t_incasari_facturi.id_tipd,
                         t_incasari_facturi.id_incas,
                         t_incasari_facturi.data_incas,
                         t_incasari_facturi.nSuma,
                         t_incasari_facturi.id_user,
                         t_incasari_facturi.created,
                         t_incasari_facturi.last_update
                 FROM t_incasari_facturi
                  where t_incasari_facturi.id = ?;",[$id]
         );

         return $rezult;
    }


}

