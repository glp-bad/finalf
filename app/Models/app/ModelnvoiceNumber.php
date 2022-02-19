<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelnvoiceNumber extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_facturi_numar';
    }


    /*
      @_fnTip tinyint,      -- 1 factura, 2 chitanta
        set @LitereNrFactura  = 'FAGD '

        if @_fnTip = 2 set @LitereNrFactura  = 'CAGD '
            public function insert($id){

            }

    set @cZero = replicate('0',8-@nLung)
    */

    public function getNumber(array $bussinesNumber){

            $checkNrNefolosit = DB::select(
                " 
                 SELECT id, cNr from t_facturi_numar where id_avocat = :idAvocat and nTip = :nTip and folosit = 0 order by nNr asc limit 1
                        ",["idAvocat"=>$this->idAvocat, "nTip"=>$bussinesNumber['nTip']]
            );

            $returnId = 0;
            $invoiceNumberString = null;

            // avem numar nefolosit
            if(!empty($checkNrNefolosit)){
                $returnId = $checkNrNefolosit[0]->id;
                $invoiceNumberString = $checkNrNefolosit[0]->cNr;
            }else{
                $lastNumber = DB::select(
                    " 
                            SELECT max(nNr) number from t_facturi_numar where id_avocat = :idAvocat and nTip = :nTip
                        ",["idAvocat"=>$this->idAvocat, "nTip"=>$bussinesNumber['nTip']]
                );

                $invoiceNumber = $lastNumber[0]->number+1;
                $invoiceNumberString = $this->getInvoiceNumber($invoiceNumber, $bussinesNumber);

                $rezult = DB::insert(
                    "insert into t_facturi_numar (id_avocat, nTip, nNr, cNr, folosit, manual, id_user, created) values (:idAvocat, :nTip, :nNr, :cNr, :folosit, :manual, :idUser, :created);",
                    ['idAvocat'=>$this->idAvocat, 'nTip'=>$bussinesNumber['nTip'], 'nNr'=>$invoiceNumber, 'cNr'=>$invoiceNumberString, 'folosit'=> 0, 'manual'=> 0, 'idUser'=>$this->idUser, 'created'=>MyHelp::getCarbonDateNow()]
                );
                $returnId = intval( DB::getPdo()->lastInsertId() );
             }

        return ['id'=>$returnId, 'cNr'=>$invoiceNumberString];
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

    private function getInvoiceNumber($number, array $bussinesNumber){
        return  $bussinesNumber['nrString'] . ' ' . str_pad($number, $bussinesNumber['lenghtFillNumber'], "0", STR_PAD_LEFT);
    }

    public static function getObjectInseret(){
        $arrayReturn = [
            'idPk'  => null,
            'adresa' => null,
            'idLocalitate' => 0
        ];

    }



}
