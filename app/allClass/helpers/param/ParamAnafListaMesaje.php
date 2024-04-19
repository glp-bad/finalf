<?php


namespace App\allClass\helpers\param;
use App\allClass\helpers\MyHelp;

class ParamAnafListaMesaje
{



    public $anaf_id;
    public $anaf_cif;
    public $anaf_id_solicitare;
    public $anaf_detalii;
    public $anaf_tip;
    public $anaf_data_creare;
    public $anaf_serial;
    public $anaf_data_creare_data;
    public $emitent_cif = null;
    public $emitent = null;

	public function __construct($mesajAnaf, $serial)
    {
        $this->anaf_id                  = $mesajAnaf['id'];
        $this->anaf_cif                 = $mesajAnaf['cif'];
        $this->anaf_id_solicitare       = $mesajAnaf['id_solicitare'];
        $this->anaf_detalii             = $mesajAnaf['detalii'];
        $this->anaf_tip                 = $mesajAnaf['tip'];
        $this->anaf_data_creare         = $mesajAnaf['data_creare'];
        $this->anaf_serial              = $serial;

        $this->anaf_data_creare_data    = MyHelp::anafConvertStringToSqlDate($this->anaf_data_creare);   // data anaf transformata in data SQL
        //$this->anaf_data_creare_data    = MyHelp::getCarbonDate('YmdHis', $this->anaf_data_creare );
        $this->emitent_cif              = MyHelp::anafGetCifEmitentFromString($this->anaf_detalii); 
        // $this->emitent                  = $mesajAnaf[''];    // se setaza dupa ce avm ciful
    }



	

}
