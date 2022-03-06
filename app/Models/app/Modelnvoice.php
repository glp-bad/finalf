<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class Modelnvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_factura';
    }

    // daca exista factura in lucru
    public function checkWorkingInvoice(){
        $rezult = DB::select(
            " 
                    select t_factura.id, t_factura.data_f, t_factura.id_part, t_factura.id_tipfactura, t_factura.nProcTva,
	                       t_facturi_numar.cNr,
                            concat(t_parteneri.cNume,'/ ',t_parteneri.cui) as cPartener
                    from t_factura
	                inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                    inner join t_parteneri on t_parteneri.id =  t_factura.id_part
                    where t_factura.id_avocat = :idAvocat and t_factura.salvata = :salvata",
                    ['idAvocat'=>$this->idAvocat, 'salvata'=> 0]
        );

        return $rezult;
    }

    // delete antet cand factura este salvata
    public function deleteAntetSave($idPk){
        $rezult = DB::delete(
            "delete from t_factura where id = :id and id_avocat = :idAvocat and salvata = :salvata;",
            ['id'=>$idPk, 'idAvocat'=>$this->idAvocat, 'salvata'=>1]
        );

        return $rezult;
    }

    public function deleteAntet($idPk){
        $rezult = DB::delete(
            "delete from t_factura where id = :id and id_avocat = :idAvocat and salvata = :salvata;",
            ['id'=>$idPk, 'idAvocat'=>$this->idAvocat, 'salvata'=>0]
        );

        return $rezult;
    }

    public function saveInvoice($idInvoice) {

        $rezult = DB::update(
            "update t_factura
                    inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr and t_facturi_numar.id_avocat = :idAvocat01
                    set t_factura.salvata = 1,
	                    t_factura.last_update = :lastUpdate01,
                        t_factura.id_user = :idUser02,
                        t_facturi_numar.folosit = 1,
                        t_facturi_numar.last_update = :lastUpdate02,
                        t_facturi_numar.id_user = :idUser01
                    where t_factura.id = :idInvoice01   
	                    and t_factura.id_avocat = :idAvocat02	
	                    and (SELECT COUNT(*) nr_rec from t_factura_d where t_factura_d.id_factura = :idInvoice02) > 0;",
            [   'idInvoice01'=> $idInvoice,
                'idInvoice02'=> $idInvoice,
                'lastUpdate01' => MyHelp::getCarbonDateNow(), 'lastUpdate02' => MyHelp::getCarbonDateNow(),
                'idUser01'=> $this->idUser, 'idUser02'=> $this->idUser,
                'idAvocat01'=>$this->idAvocat, 'idAvocat02'=>$this->idAvocat]
        );

        return $rezult;
    }

    public function insertAntet(array $insertAntet){
        $rezult = DB::insert(
            "insert into t_factura (id_nr, data_f, id_part, id_tipfactura, nProcTVA, salvata, id_user, created, id_avocat) values (:idNr, :dataF, :idPart, :idTipFactura, :nProcTVA, :salvata, :idUser, :created, :idAvocat);",
            ['idNr'=>$insertAntet['id_invoice_number'], 'dataF'=>$insertAntet['name_invoiceDate'], 'idPart'=>$insertAntet['name_nomPartner'], 'idTipFactura'=>$insertAntet['name_nomInvoiceType'], 'nProcTVA'=>$insertAntet['name_tva'],
              'salvata'=>0,'idUser'=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow(), 'idAvocat'=>$this->idAvocat]
        );
        $returnId = intval( DB::getPdo()->lastInsertId() );

        return $returnId;
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
            'name_invoiceDate'  => null,
            'name_nomPartner' => null,
            'name_nomInvoiceType' => null,
            'name_tva' => null,
            'id_invoice_number' => null
        ];

        return $arrayReturn;
    }

}

