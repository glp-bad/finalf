<?php


namespace App\allClass\helpers\param;

use App\allClass\helpers\Check;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\response\ValidateParam;

class Expense
{

	public $data_document;
	public $data_year;
	public $data_month;
	public $id_partner;
	public $id_tip_expense;
	public $id_tip_doc;
	public $id_tip_plata;
	public $nr_doc;

	public function setNewExpense(array $f) {
        $sqlDateFormat = MyHelp::getSqlDateFormat($f["name_dataCheltuiala"], null);

        $this->data_document    = $sqlDateFormat['dataFormat'];
        $this->data_year        = intval($sqlDateFormat['year']);
		$this->data_month       =  intval($sqlDateFormat['month']);
		$this->id_partner       = intval($f["name_nomPartner"]);
		$this->id_tip_expense   = intval($f["name_nomTypeCheltuieli"]);
		$this->id_tip_doc       = intval($f["name_nomDocumentType"]);
		$this->id_tip_plata     = intval($f["tipPlata"]);
		$this->nr_doc           = $f["name_nrDoc"];

    }

    public function validate() : ValidateParam {
        $returnValid = false;
        $errorMsg = [];

        /*
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
        */

	    $returnValid = true;

        return new ValidateParam( $returnValid, $errorMsg);
    }

}
