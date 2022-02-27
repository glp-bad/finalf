<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\param\SaveIncoming;
use App\Http\Controllers\Controller;
use App\Models\app\ModelInvoiceIncasari;
use App\Models\bussines\BussinesInvoice;
use App\Models\nomenclatoare\ModelNomTipDocument;
use App\Models\app\ModelnvoiceNumber;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartenerInvoicesCashingInController extends Controller
{
    public function __construct(){}


    public function saveIncoming(Request $request) {
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $idNrDocument = null;

        $paramSaveIncoming = new SaveIncoming();
        $paramSaveIncoming->setIncomingInvoice($request['id_factura'], $idNrDocument  ,$request['field']);

        $validateParam = $paramSaveIncoming->validate();

        if(!$validateParam->succes){
            $msg->succes = $validateParam->succes;
            $msg->lastId = -1;
            $msg->messages= $validateParam->messages;
            return $msg->toJson();
        }

         try {
            $msg->succes = true;
            $modelInvoiceNumber = new ModelnvoiceNumber($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

            DB::beginTransaction();

                if($paramSaveIncoming->name_manualNumber){
                    $invoiceNumber = $modelInvoiceNumber->insertCustomNumber(MyAppConstants::BUSS_NR_CHITANTA_DANA, $paramSaveIncoming->name_nrDoc);
                }else{
                    $invoiceNumber = $modelInvoiceNumber->getNumber(MyAppConstants::BUSS_NR_CHITANTA_DANA);
                }
                $paramSaveIncoming->id_nr_invoice = $invoiceNumber['id'];
                $modelInvoiceIncasari = new ModelInvoiceIncasari($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

                $modelInvoiceIncasari->saveIncoming($paramSaveIncoming);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            $msg->messages= 'Server error. Numarul de chitanta exista deja in baza de date !!!';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();
    }

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
