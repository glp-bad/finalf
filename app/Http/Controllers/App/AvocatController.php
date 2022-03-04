<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\app\ModelLuniInchise;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use App\allClass\helpers\param\WokingMonth;


class AvocatController extends Controller
{
    public function __construct(){}


	public function insertMonth(Request $request){
		$msg = $this->getSqlMessageResponse(false, null, -1, null, null, false );
		$workinMonth = new WokingMonth(null, null, $request->field['name_year'],$request->field['name_month']);

		$validateParam = $workinMonth->validate();

		if(!$validateParam->succes){
			$msg->succes = $validateParam->succes;
			$msg->lastId = -1;
			$msg->messages= $validateParam->messages;
			return $msg->toJson();
		}

		try {
			$msg->succes = true;
			$modelLuniInchise = new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
			$modelLuniInchise->insertMonth($workinMonth);

		}catch (\Exception $e){
			$msg->messages= 'Server error. Luna este deja inregistrata in baza de date!';
			$msg->errorMsg = $e->getMessage();
			$msg->succes = false;

		}

		return $msg->toJson();
	}

    public function checkMonth(Request $request){
	    $msg = $this->getSqlMessageResponse(false, null, -1, null, null, false );

	    $check = 0;
	    if($request->field['checkValue']){
		    $check = 1;
	    }
	    $workinMonth = new WokingMonth($request->idPk, $check,0,0);

	    $modelLuniInchise = new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

	    try {
		    $updateCount = $modelLuniInchise->checkMonth($workinMonth);

		    if($updateCount == 0) {
			    $msg->messages= 'Inregistrarea nu a fost gasita! Datele nu s-au actualizat.';
			    $msg->succes = false;

		    } else {
			    $msg->messages= 'Datele s-au actualizat cu succes!';
			    $msg->succes = true;

		    }

	    }catch (\Exception $e){
		    $msg->messages= $e->getMessage();
		    $msg->succes = false;
	    }

	    return $msg->toJson();
    }

    public function monthList(Request $request) {
        $msg = $this->getSqlMessageResponse(false, null, -1, null, null, false );
        $modelLuni =  new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->succes = true;

	    // $request->yearList = 2020;

        $msg->records  = $modelLuni->selectMonthList($request->yearList);

        return $msg->toJson();
    }

}
