<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\MyHelp;
use App\allClass\helpers\param\ListFilter;
use App\allClass\helpers\param\SaveIncoming;
use App\allClass\helpers\param\WokingMonth;
use App\allClass\ToXLSX;
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
use  App\allClass\PrintApp;
use DateTime;

class PartenerInvoicesCashingInController extends Controller
{
    public function __construct(){}




	public function receiptPrint(Request $request)
	{
		$id = $request->idPk;
		$bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
		$data = $bussinesInvoice->selectReceiptIncomePrint($id);


		$receipt = json_decode(json_encode($data[0]), true);

		if($receipt['av_cui_ro'] == 'RO'){
            $receipt['av_cuiro'] = $receipt['av_cui_ro'] . ' ' . $receipt['av_cui'];
        }else{
            $receipt['av_cuiro'] = $receipt['av_cui'];
        }


        if($receipt['pa_cui_ro'] == 'RO'){
            $receipt['pa_cuiro'] = $receipt['pa_cui_ro'] . ' ' . $receipt['pa_cui'];
        }else{
            $receipt['pa_cuiro'] = $receipt['pa_cui'];
        }


		$htmlView = view('app/receipt')->with(['receipt'=> $receipt]);


		$print = new PrintApp('A4','portrait');
		$pathRezultPrint = $print->printReceipt($htmlView);

		$pdf = base64_encode(file_get_contents($pathRezultPrint));

		$filename = $this->getReceiptFileName($receipt);

		return json_encode(['pdf' => $pdf, 'fileName' =>  $filename]);

	}

    public function deleteIncomingDoc(Request $request) {
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

        $idNumber = $entity[0]->id_nr;
        $modelnvoiceNumber = new ModelnvoiceNumber($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        try {

            DB::beginTransaction();
                $deletedCount = $modelInvoiceIncasari->deleteIncoming($id);
                if($deletedCount != 1){
                    throw new \Exception("APP ERROR . Nu am putut sa sterg incasarea!");
                }

                $updateCount = $modelnvoiceNumber->updateUseNumber($idNumber,0);
                if($updateCount != 1){
                    throw new \Exception("Incasare nu poate fi stearsa, nu se poate face update la numarul de incasare!");
                }

                $msg->succes = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $msg->messages= 'App error. -- incasari.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();
    }


    public function reportIncasari(Request $request){
        $sqlDateFormatIn = MyHelp::getSqlDateFormat($request['dataIn'], null);
        $sqlDateFormatSf = MyHelp::getSqlDateFormat($request['dataSf'], null);
        $param = new ListFilter($sqlDateFormatIn['dataFormat'], $sqlDateFormatSf['dataFormat'], $request['idPartner']);

        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $dataReport = $bussinesInvoice->reportIncasari($param);

        $report = array();
        foreach ($dataReport as $r){
            $record = array();
            $record["receipt_tipdoc"       ] = $r->receipt_tipdoc       ;
            $record["receipt_tipin"        ] = $r->receipt_tipin        ;
            $record["receipt_date"         ] = $r->receipt_date         ;
            $record["receipt_nrdoc"        ] = $r->receipt_nrdoc        ;

            if(floatval($r->invoice_suma) == floatval($r->receipt_suma)){
                $record["receipt_suma_fara_tva"] = $r->invoice_suma_fara_tva;
                $record["receipt_suma_tva"     ] = $r->invoice_suma_tva     ;
                $record["receipt_suma"         ] = $r->invoice_suma         ;

            }else{
                $receipt_tva = MyHelp::getValueFromSumaCuTva($r->receipt_suma, $r->invoice_percent_tva);
                $record["receipt_suma_fara_tva"] = $receipt_tva['sumaFaraTva'];
                $record["receipt_suma_tva"     ] = $receipt_tva['sumaTva'];
                $record["receipt_suma"         ] = $receipt_tva['total'];
            }

            $record["invoice_nrdoc"        ] = $r->invoice_nrdoc        ;
            $record["invoice_client"       ] = $r->invoice_client       ;
            $record["invoice_cf"           ] = $r->invoice_cf           ;
            $record["invoice_percent_tva"  ] = $r->invoice_percent_tva  ;
            $record["invoice_suma_fara_tva"] = $r->invoice_suma_fara_tva;
            $record["invoice_suma_tva"     ] = $r->invoice_suma_tva     ;
            $record["invoice_suma"         ] = $r->invoice_suma         ;

            $report[] = $record;

        }

        $headerExcel = array(
            "receipt_tipdoc"        =>'string',
            "receipt_tipin"         =>'string',
            "receipt_date"          =>'string',
            "receipt_nrdoc"         =>'string',
            "receipt_suma_fara_tva" =>'price',
            "receipt_suma_tva"      =>'price',
            "receipt_suma"          =>'price',
            "invoice_nrdoc"         =>'string',
            "invoice_client"        =>'string',
            "invoice_cf"            =>'string',
            "invoice_percent_tva"   =>'string',
            "invoice_suma_fara_tva" =>'price',
            "invoice_suma_tva"      =>'price',
            "invoice_suma"          =>'price'
        );
        $toXls =  new ToXLSX($headerExcel, $report);
        $msg->setCustomData(['xls' => $toXls->getBase6fFile(), 'fileName' =>  'incasari_lunare.xlsx']);
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

    private function getReceiptFileName($r){
        $dts = new DateTime($r['data_incas']);

        $client = substr($r['pa_nume'], 0, 5);
        $client = str_replace(' ', '', $client);
        $dataString  = date_format($dts,"Ymd");
        $invoiceNumber = str_replace(' ', '', $r['receipt_nr']);

        return $client . '_' . $dataString . '_' . $invoiceNumber . '.pdf';
    }

}
