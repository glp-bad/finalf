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

        $nr_facturi = count($msg->records);
        $total_facturat = 0.00;
        $total_incasari = 0.00;
        $total_ramas_de_incasat = 0.00;
        foreach ($msg->records as $r){
            $total_facturat         += floatval($r->total_factura);
            $total_incasari         += floatval($r->total_incasat);
            $total_ramas_de_incasat += floatval($r->rest_de_incasat);
        }

        $msg->setCustomData(['nr_facturi'=>$nr_facturi, 'total_facturat'=>round($total_facturat,2), 'total_incasari'=>round($total_incasari,2), 'total_ramas_de_incasat'=>round($total_ramas_de_incasat,2)]);

        return $msg->toJson();
    }
}
