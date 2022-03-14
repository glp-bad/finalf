<?php


namespace App\allClass\helpers\param;

use App\allClass\helpers\Check;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\response\ValidateParam;

class ExpenseArticol
{

	public $id_exepense;
	public $id_cat_chelt;
    public $id_product;
    public $id_um;
    public $cantitate;
    public $pret_unitar;
    public $total_fara_tva;
    public $total_tva;
    public $procent_tva;


	public function __construct($id) {
        $this->id_exepense = $id;
    }

    public function setNewExpense(array $f) {
		$this->id_cat_chelt      = intval($f["name_nomCategoriCheltuieli"]);
		$this->id_product        = intval($f["name_nomProducts"]);
        $this->id_um             = intval($f["name_nomUm"]);
        $this->cantitate         = floatval($f["name_cantitate"]);
        $this->pret_unitar       = floatval($f["name_sumaPretUnitarFaraTva"]);
        $this->total_fara_tva    = floatval($f["name_sumaUnitara"]);
        $this->total_tva         = floatval($f["name_sumaTva"]);
        $this->procent_tva       = floatval($f["name_tva"]);
    }

    public function validateArticol() : ValidateParam {
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
