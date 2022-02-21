<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelInvoiceIncasari extends MyModel {
    public function __construct($idAvocat, $idUser) {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_incasari_facturi';
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

