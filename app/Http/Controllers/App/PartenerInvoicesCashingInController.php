<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\bussines\BussinesInvoice;
use App\Models\nomenclatoare\ModelNomTipDocument;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class PartenerInvoicesCashingInController extends Controller
{
    public function __construct(){}

	public function nomDocumentTipe(Request $request) {
		$msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
		$nom = new ModelNomTipDocument($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
		$msg->records  = $nom->selectForSimpleDropDown();

		return $msg->toJson();
	}

    public function listaUnpaidInvoices(Request $request) {
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->records  = $bussinesInvoice->selectFacturiNeincasate();
        $msg->setCustomData(null);

        return $msg->toJson();
    }
}
