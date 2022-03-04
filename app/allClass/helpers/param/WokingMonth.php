<?php


namespace App\allClass\helpers\param;
use App\allClass\helpers\response\ValidateParam;
use App\allClass\helpers\Check;
use App\allClass\helpers\MyHelp;

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
	public function setYearAndMonth($data){
		$dataFormat = MyHelp::getSqlDateFormat($data, null);
		$this->month = intval($dataFormat['month']);
		$this->year = intval($dataFormat['year']);

	}

	public function checkOpenMonth($record){

		$open = false;
		$msg = 'Luna pentru cate vrei sa prelucrezi date nu este inregistrata in baza de date!';

		if(count($record) > 0){
			if($record[0]->inchisa == 0){
				$open = true;
			}else{
				$msg = 'Luna pentru cate vrei sa prelucrezi date este inchisa!';
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
