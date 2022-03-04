<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\MyHelp;
use App\allClass\helpers\param\SaveIncoming;
use App\allClass\helpers\param\WokingMonth;
use App\Http\Controllers\Controller;
use App\Models\app\ModelInvoiceIncasari;
use App\Models\app\ModelLuniInchise;
use App\Models\bussines\BussinesInvoice;
use App\Models\nomenclatoare\ModelNomTipDocument;
use App\Models\app\ModelnvoiceNumber;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\IncomingList;

class PartenerInvoicesCashingInController extends Controller
{
    public function __construct(){}



    public function deleteIncomingDoc(Request $request){
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $modelInvoiceIncasari = new ModelInvoiceIncasari($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $id = $request->idPk;


        // --- check mounth
        $wokingMonth = new WokingMonth(0,0,0,0);
        $entity = $modelInvoiceIncasari->selectEntity($id);
        $docDate = MyHelp::getCarbonDate('Y-m-d H:i:s.u', $entity[0]->data_incas);
        $openMonth = $wokingMonth->checkOpenMonth($docDate->year, $docDate->month, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
            return $msg->toJson();
        }


        try {
            $deletedCount = $modelInvoiceIncasari->deleteIncoming($id);
            if($deletedCount != 1){
                throw new \Exception("APP ERROR . Nu am putut sa sterg incasarea!");
            }

            $msg->succes = true;

        }catch (\Exception $e){
            $msg->messages= 'App error. -- incasari.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }


        return $msg->toJson();
    }

    public function incomingList(Request $request){

        $sqlDateFormatIn = MyHelp::getSqlDateFormat($request['dataIn'], null);
        $sqlDateFormatSf = MyHelp::getSqlDateFormat($request['dataSf'], null);
        $paramIncomingList = new IncomingList($sqlDateFormatIn['dataFormat'], $sqlDateFormatSf['dataFormat'], $request['idPartner']);

        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->records  = $bussinesInvoice->selectIncasari($paramIncomingList);

        $nr_records = count($msg->records);
        $total_incasari = 0.00;

        foreach ($msg->records as $r){
            $total_incasari         += floatval($r->suma);
        }

        $msg->setCustomData(['nr_records'=>$nr_records, 'total_incasari'=>round($total_incasari,2)]);

        return $msg->toJson();
    }

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

        // --- check mounth
        $wokingMonth = new WokingMonth(0,0,0,0);
        $openMonth = $wokingMonth->checkOpenMonth($paramSaveIncoming->invoiceYear, $paramSaveIncoming->invoiceMonth, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
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
