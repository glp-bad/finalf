<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelnvoiceXml extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_factura_electronica';
    }

    

    public function insertInvoice(array $inserteInvoice){
        $rezult = DB::insert(
            "insert into t_factura_electronica (id_factura, e_factura, id_user, created) values (:idFactura, :eFactura, :idUser, :created);",
            ['idFactura'=>$inserteInvoice['id_factura'], 'eFactura'=>$inserteInvoice['eFactura'], 'idUser'=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow()]
        );
        $returnId = intval( DB::getPdo()->lastInsertId() );

        return $returnId;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
            select t_factura_electronica.id, 
                   t_factura_electronica.id_factura, 
                   t_factura_electronica.e_factura, 
                   t_factura_electronica.id_user, 
                   t_factura_electronica.created, 
                   t_factura_electronica.updated 
            from t_factura_electronica
                  where t_factura_electronica.id = ?;",[$id]
        );

        return $rezult;
    }

    public function selectEntityByInvoiceId($id){
        $rezult = DB::select(
            " 
            select t_factura_electronica.id, 
                   t_factura_electronica.id_factura, 
                   t_factura_electronica.e_factura, 
                   t_factura_electronica.id_user, 
                   t_factura_electronica.created, 
                   t_factura_electronica.updated 
            from t_factura_electronica
                  where t_factura_electronica.id_factura = ?;",[$id]
        );

        return $rezult;
    }

    public function deleteByInvoiceId($idInvoice){
        $rezult = DB::delete(
            "delete from t_factura_electronica where id_factura = :id;",
            ['id'=>$idInvoice]
        );

        return $rezult;
    }

}

