<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\param\Expense;
use App\Http\Controllers\Controller;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Models\app\ModelCheltuieli;
use App\Models\nomenclatoare\ModelNomTipCheltuieli;
use App\MyAppConstants;
use \Illuminate\Http\Request;



class CheltuieliController extends Controller
{
    public function __construct(){}




	public function checkWorkingExpense(){
		$modeExpense = new ModelCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

		$succes = true;
		$lastId = -1;
		$messages = null;
		$records  = $modeExpense->checkWorkingExpense();

		return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
	}

	public function insertExpenseAntet(Request $request) {
		$msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
		$paramExpense = new Expense();
		$paramExpense->setNewExpense($request->field);

		$openMonth = $this->isOpenMonth($paramExpense->data_year, $paramExpense->data_month);
		if(!$openMonth['open']){
			$msg->succes = false;
			$msg->lastId = -1;
			$msg->messages= $openMonth['msg'];
			return $msg->toJson();

		}

		try {
			$msg->succes = true;
			$modelCheltuieli =  new ModelCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
			$msg->lastId = $modelCheltuieli->insertAntet($paramExpense);

		}catch (\Exception $e){
			$msg->messages= 'Server error.';
			$msg->errorMsg = $e->getMessage();
			$msg->succes = false;
		}


		return $msg->toJson();
    }

	public function nomTipCheltuieli(Request $request) {
		$nom = new ModelNomTipCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
		$succes = true;
		$lastId = -1;
		$messages = null;
		$records  = $nom->selectForSimpleDropDown();

		return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
	}

}
