<?php


namespace App\allClass\helpers\param;

use App\allClass\helpers\Check;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\response\ValidateParam;

class SaveIncoming
{
    public $id_invoice              =null;
    public $id_nr_invoice           =null;

    public $name_manualNumber       =null;
    public $name_nrDoc              =null;
    public $name_invoiceDate        =null;
    public $name_nomDocumentType    =null;
    public $name_amountRecived      =null;
    public $tipIncasare             =null;

    public function setIncomingInvoice($idInvoice, $idNrInvoice, array $f) {
        $sqlDateFormat = MyHelp::getSqlDateFormat($f["name_invoiceDate"], null);
        $this->name_invoiceDate = $sqlDateFormat['dataFormat'];

        $this->name_nomDocumentType    =$f["name_nomDocumentType"];
        $this->name_amountRecived      =$f["name_amountRecived"];
        $this->tipIncasare             =$f["tipIncasare"];

        $this->name_manualNumber       =$f["name_manualNumber"];

        if($this->name_manualNumber){
            $this->name_nrDoc              =$f["name_nrDoc"] . '_'  . $sqlDateFormat['objDate']->format('Y');
        }else{
            $this->name_nrDoc              =$f["name_nrDoc"];
        }

        $this->id_invoice = $idInvoice;
        $this->id_nr_invoice = $idNrInvoice;
    }

    public function validate() : ValidateParam {
        $returnValid = false;
        $errorMsg = [];

        if($this->name_manualNumber){
            if(Check::betweenInterval(strlen($this->name_nrDoc),2,20)){
                $returnValid = true;
            }else{
                $returnValid = false;
                $errorMsg[] = 'Numarul de document nu este corect, trebuie sa aiba maxim 20 de caractere';
            }
        }else{
            $returnValid = true;
        }






        return new ValidateParam( $returnValid, $errorMsg);
    }

}
