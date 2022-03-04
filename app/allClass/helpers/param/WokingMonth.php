<?php


namespace App\allClass\helpers\param;
use App\allClass\helpers\response\ValidateParam;
use App\allClass\helpers\Check;
use App\allClass\helpers\MyHelp;
use App\Models\app\ModelLuniInchise;

class WokingMonth
{
    public $id    = null;
    public $check = 0;
    public $year  = 0;
	public $month = 0;

	public function __construct($id, $check, $year, $month) {
		$this->id    = $id;
		$this->check = $check;
		$this->year  = $year;
		$this->month = $month;
	}

	/**
	 * @param $data '01/01/2000'
	 */
	private function setYearAndMonth($data){
		$dataFormat = MyHelp::getSqlDateFormat($data, null);
		$this->month = intval($dataFormat['month']);
		$this->year = intval($dataFormat['year']);

	}

	public function checkOpenMonth($year, $month, ModelLuniInchise  $modelLuniInchise){
        $this->year = $year;
        $this->month = $month;
        $closeMonth = $modelLuniInchise->selectWorkingMonth($this);

		$open = false;
		$msg = '<b>Luna</b> pentru care vrei sa prelucrezi date <b>nu este inregistrata</b> in baza de date !';

		if(count($closeMonth) > 0){
			if($closeMonth[0]->inchisa == 0){
				$open = true;
			}else{
				$msg = '<b>Luna</b> pentru care vrei sa prelucrezi date este <b>inchisa</b> !';
			}
		}


		return ['open'=>$open, 'msg'=>$msg];
	}

	public function validate() : ValidateParam {
		$returnValid = false;
		$errorMsg = [];

		if(!Check::betweenInterval($this->month,1,12)){
			$errorMsg[] = 'Luna trebuie sa fie in intervalul 1-12';
		}

		if(!Check::betweenInterval($this->year,2020,2050)){
			$errorMsg[] = 'Anul trebuie sa fie in intervalul 2020-2050';
		}

		if(count($errorMsg) == 0){
			$returnValid = true;
		}

		return new ValidateParam( $returnValid, $errorMsg);
	}

}
