<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\MyHelp;
use App\allClass\helpers\param\Expense;
use App\allClass\helpers\param\ExpenseArticol;
use App\Http\Controllers\Controller;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Models\app\ModelCheltuieli;
use App\Models\app\ModelCheltuieliDetail;
use App\Models\nomenclatoare\ModelNomCategoriCheltuilei;
use App\Models\nomenclatoare\ModelNomProduse;
use App\Models\nomenclatoare\ModelNomTipCheltuieli;
use App\Models\nomenclatoare\ModelNomTipUm;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CheltuieliController extends Controller
{
    public function __construct(){}




	public function detailExpenseList(Request $request) {
		$msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
		$modelExpenseDetail = new ModelCheltuieliDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

		$id = -1;

		if(isset($request->idExpense)){
			$id = $request->idExpense;
		}

		$msg->records  = $modelExpenseDetail->selectDetailList($id);


		$total = 0.00;
		$sumaFaraTva = 0.00;
		$sumaTva = 0.00;
		foreach ($msg->records as $r){
			//$total += floatval($r->nTotal);
			//$sumaFaraTva += floatval($r->nSumaFaraTva);
			//$sumaTva += floatval($r->nSumaTva);
		}


		// $msg->setCustomData(['total'=>round($total,2), 'sumaFaraTva'=>round($sumaFaraTva,2), 'sumaTva'=>round($sumaTva,2)]);

		return $msg->toJson();
	}

    public function insertExpenseArticol (Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelExpense = new ModelCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $expenseAntet = $modelExpense->selectEntity($request->idExpense);

        try {
            if(count($expenseAntet) != 1){
                throw new \Exception("Articolul nu se poate insera in baza de date. Lipseste cheltuiala!");
            }

            $param = new ExpenseArticol($request->idExpense);
            $param->setNewExpense($request->field);
            $modelExpenseDetail = new ModelCheltuieliDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
            $modelExpenseDetail->insertDetailExpense($param);

            $msg->succes = true;

        }catch (\Exception $e){
            $msg->messages= 'App error. Nu se poate inregistra articolul in baza de date.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();
    }

    public function deleteAntetExpense (Request $request){
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelExpense = new ModelCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $id = $request->idPk;

        // --- check mounth
        $entity = $modelExpense->selectEntity($id);
        $dataDocument = MyHelp::getCarbonDate('Y-m-d H:i:s.u', $entity[0]->datac);

        $openMonth = $this->isOpenMonth($dataDocument->year, $dataDocument->month);
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
            return $msg->toJson();
        }

        $modelExpenseDetail =  new ModelCheltuieliDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        try {
            DB::beginTransaction();

            $modelExpenseDetail->deleteDetailExpense($id);
            $deleteAntet = $modelExpense->deleteAntet($id);
            if($deleteAntet != 1){
                throw new \Exception("Cheltuiala nu poate fi stearsa, nu se poate sterge antetul!");
            }

            DB::commit();

            $msg->succes = true;

        }catch (\Exception $e){
            DB::rollBack();

            $msg->messages= 'App error. Nu se poate sterge antetul. Incercati relogarea in aplicatie.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }
        return $msg->toJson();
    }

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

    public function nomCategoriCheltuieli(Request $request) {
        $nom = new ModelNomCategoriCheltuilei($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    /**
     * @param Request $request
     * @return false|string
     * for dropdown list
     */
    public function listProducts(Request $request) {
        $nom = new ModelNomProduse($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSearchDropDown($request->wordSearch);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function nomTipUm(Request $request) {
        $nom = new ModelNomTipUm($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


}
