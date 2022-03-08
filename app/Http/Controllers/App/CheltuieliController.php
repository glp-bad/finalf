<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Models\app\ModelLuniInchise;
use App\Models\nomenclatoare\ModelNomTipCheltuieli;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use App\allClass\helpers\param\WokingMonth;


class CheltuieliController extends Controller
{
    public function __construct(){}



	public function nomTipCheltuieli(Request $request) {
		$nom = new ModelNomTipCheltuieli($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
		$succes = true;
		$lastId = -1;
		$messages = null;
		$records  = $nom->selectForSimpleDropDown();

		return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
	}
}
