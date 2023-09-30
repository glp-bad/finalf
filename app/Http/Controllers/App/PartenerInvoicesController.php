<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Http\Controllers\Controller;
use App\Models\app\ModelInvoiceTemplate;
use App\Models\app\ModelnvoiceDetail;
use App\Models\app\ModelnvoiceNumber;
use App\Models\app\ModelLuniInchise;
use App\allClass\helpers\param\WokingMonth;
use App\Models\bussines\BussinesInvoice;
use App\Models\app\ModelParteneri;
use App\Models\app\Modelnvoice;
use App\Models\nomenclatoare\ModelNomTipFactura;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\IncomingList;
use  App\Models\app\ModelInvoiceIncasari;
use  App\allClass\PrintApp;
use  App\allClass\ToXLSX;
use  App\allClass\ElectronicInvoice;
use DateTime;

use App\allClass\XLSXWriter;

class PartenerInvoicesController extends Controller
{
    public function __construct(){}


    public function reportExcelInvoiceEmitted(Request $request)
    {

        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );

        $sqlDateFormatIn = MyHelp::getSqlDateFormat($request['dataIn'], null);
        $sqlDateFormatSf = MyHelp::getSqlDateFormat($request['dataSf'], null);
        $paramIncomingList = new IncomingList($sqlDateFormatIn['dataFormat'], $sqlDateFormatSf['dataFormat'], $request['idPartner']);

        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $report = $bussinesInvoice->reportFacturiEmise($paramIncomingList);

        $header = array(
            'nr factura'=>'string',
            'tip factura'=>'string',
            'data factura'=>'string',
            'client firma'=>'string',
            'client nume'=>'string',
            'client cf'=>'string',
            'procent tva'=>'price',
            'suma fara tva'=>'price',
            'suma tva'=>'price',
            'suma'=>'price',
        );

        // dd($rows);

        $rows = array();

        foreach ($report as $r){
            $rows[] =  (array) $r;
        }

        $toXls =  new ToXLSX($header, $rows);

        /*
            $writer = new XLSXWriter();

            $writer->writeSheetHeader('Sheet1', $header);
            foreach($rows as $row) {
                $writer->writeSheetRow('Sheet1', $row);
            }
            $path = storage_path() . '/app/' . 'report.xlsx';
            $writer->writeToFile($path);
            $xls = base64_encode(file_get_contents($path));
        */

        $msg->setCustomData(['xls' => $toXls->getBase6fFile(), 'fileName' =>  'facturi_emise.xlsx']);


        return $msg->toJson();
    }


    public function eInvoiceGenerating(Request $request)
    {
        $eInvoices = new ElectronicInvoice();
    }


    public function invoicePrint(Request $request)
    {
        $id = $request->idPk;
        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $antetFactura = $bussinesInvoice->selectInvoicePrintAntet($id);
        $detaliuFactura = $bussinesInvoice->selectInvoicePrintDetail($id);

        // problema test FAGD 00002252

        $ro = 'RO';
        if($antetFactura[0]->ro_ == $ro){
            $antetFactura[0]->cui = trim($ro . $antetFactura[0]->cui);
        }

        if($antetFactura[0]->ro_av == $ro){
            $antetFactura[0]->cui_av = trim($ro . $antetFactura[0]->cui_av);
        }

        $orderNr = 1;
        foreach ($detaliuFactura as $k => $v){
            $detaliuFactura[$k]->nro = $orderNr;
            $orderNr++;
        }

        $arAntet = json_decode(json_encode($antetFactura[0]), true);
        $arDetaliu = json_decode(json_encode($detaliuFactura), true);

        $suma = 0.00;
        $tva = 0.00;
        $totalPlata = 0.00;
        foreach ($arDetaliu as $det){
            $suma   += $det['nSuma'];
            $tva    += $det['nTVA'];
            $totalPlata   += $det['ValoareFactura'];
        }

        $plata = ['suma'=>$suma, 'tva'=>$tva, 'totalPlata'=>$totalPlata];

        $invoicePrintName = $this->getInvoiceFileName($arAntet);
        $htmlView = view('app/invoice')->with(['antet'=> $arAntet, 'servicii'=>$arDetaliu, 'plata'=>$plata]);
        $print = new PrintApp('A4','portrait');
        $pathRezultPrint = $print->print($htmlView);

        $pdf = base64_encode(file_get_contents($pathRezultPrint));
        return json_encode(['pdf' => $pdf, 'fileName' =>  $invoicePrintName]);
    }


    public function invoicesList(Request $request){

        $sqlDateFormatIn = MyHelp::getSqlDateFormat($request['dataIn'], null);
        $sqlDateFormatSf = MyHelp::getSqlDateFormat($request['dataSf'], null);
        $paramIncomingList = new IncomingList($sqlDateFormatIn['dataFormat'], $sqlDateFormatSf['dataFormat'], $request['idPartner']);

        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $bussinesInvoice = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->records  = $bussinesInvoice->selectFacturiEmise($paramIncomingList);

        $count = count($msg->records);
        $total = 0.00;
        $sumaIncasata = 0.00;
        $ramasDeIncasat = 0.00;
        foreach ($msg->records as $r){
            $total += floatval($r->total_factura);
            $sumaIncasata += floatval($r->total_incasat);
            $ramasDeIncasat += floatval($r->rest_de_incasat);
        }

        $msg->setCustomData(['records_count'=>$count, 'total'=>round($total,2), 'sumaIncasata'=>round($sumaIncasata,2), 'ramasDeIncasat'=>round($ramasDeIncasat,2)]);

        return $msg->toJson();
    }

    public function invocesListPartener(Request $request) {
        $gridPaginateOrderFilter = new GridPaginateOrderFilter($request);

        $partnerInvoces = new BussinesInvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        return $partnerInvoces->gridFacturiPartener($gridPaginateOrderFilter);
    }


    /**
     * @param Request $request
     * @return false|string
     * for dropdown list
     */
    public function listPartener(Request $request) {
        $nom = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSearchDropDown($request->wordSearch);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function detailInvoiceList(Request $request) {
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->records  = $modelnvoiceDetail->selectDetailList($request->idInvoice);

        $total = 0.00;
        $sumaFaraTva = 0.00;
        $sumaTva = 0.00;
        foreach ($msg->records as $r){
            $total += floatval($r->nTotal);
            $sumaFaraTva += floatval($r->nSumaFaraTva);
            $sumaTva += floatval($r->nSumaTva);
        }

        $msg->setCustomData(['total'=>round($total,2), 'sumaFaraTva'=>round($sumaFaraTva,2), 'sumaTva'=>round($sumaTva,2)]);

        return $msg->toJson();
    }

    public function nomInvoiceType(Request $request) {
        $nom = new ModelNomTipFactura($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown($request->wordSearch);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function nomInvoiceTemplate(Request $request) {
        $nom = new ModelInvoiceTemplate($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }

    public function checkWorkingInvoice(){
        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $modelnvoice->checkWorkingInvoice();

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }



    public function deleteItemDetailInvoice(Request $request){
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $id = $request->idPk;

        try {
            $deletedCount = $modelnvoiceDetail->deleteItemDetailInvoice($id);
            if($deletedCount != 1){
                throw new \Exception("Factura este salvata. Articolul nu poate fi sters!");
            }

            $msg->succes = true;

        }catch (\Exception $e){
            $msg->messages= 'App error.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }


        return $msg->toJson();
    }

    // sterg factura salvata
    public function deleteInvoice(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $id = $request->idPk;

        // --- check mounth
        $entity = $modelnvoice->selectEntity($id);

        $invoiceDate = MyHelp::getCarbonDate('Y-m-d', $entity[0]->data_f);
        $wokingMonth = new WokingMonth(0,0,0,0);
        $openMonth = $wokingMonth->checkOpenMonth($invoiceDate->year, $invoiceDate->month, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
            return $msg->toJson();
        }

        $modelInvoiceIncasari = new ModelInvoiceIncasari($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $countIncoming = $modelInvoiceIncasari->selectCountIncoming($id);

        if($countIncoming[0]->incasariCount > 0){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= 'Factura are incasari. Stergeti incasarile apoi puteti sterge si factura.';
            return $msg->toJson();
        }

        $idNumber = $entity[0]->id_nr;

        $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $modelnvoiceNumber = new ModelnvoiceNumber($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        try {
            DB::beginTransaction();

            $modelnvoiceDetail->deleteDetailInvoice($id);
            $deleteAntet = $modelnvoice->deleteAntetSave($id);
            if($deleteAntet != 1){
                throw new \Exception("Factura nu poate fi stearsa, nu se poate sterge antetul!");
            }

            $updateCount = $modelnvoiceNumber->updateUseNumber($idNumber,0);
            if($updateCount != 1){
                throw new \Exception("Factura nu poate fi stearsa, nu se poate face update la numarul de factura!");
            }

            DB::commit();

            $msg->succes = true;

        }catch (\Exception $e){
            DB::rollBack();

            $msg->messages = $e->getMessage();
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();


    }

    public function deleteInvoiceAntet(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $id = $request->idPk;

        // --- check mounth
            $entity = $modelnvoice->selectEntity($id);
            $invoiceDate = MyHelp::getCarbonDate('Y-m-d', $entity[0]->data_f);
            $wokingMonth = new WokingMonth(0,0,0,0);
            $openMonth = $wokingMonth->checkOpenMonth($invoiceDate->year, $invoiceDate->month, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
            if(!$openMonth['open']){
                $msg->succes = false;
                $msg->lastId = -1;
                $msg->messages= $openMonth['msg'];
                return $msg->toJson();
            }

        $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));


        try {
            DB::beginTransaction();

                $modelnvoiceDetail->deleteDetailInvoice($id);
                $deleteAntet = $modelnvoice->deleteAntet($id);
                if($deleteAntet != 1){
                    throw new \Exception("Factura nu poate fi stearsa, nu se poate sterge antetul!");
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

    public function saveInvoice(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $idInvoice = $request->id;

        // --- check mounth
        $entity = $modelnvoice->selectEntity($idInvoice);
        $invoiceDate = MyHelp::getCarbonDate('Y-m-d', $entity[0]->data_f);
        $wokingMonth = new WokingMonth(0,0,0,0);
        $openMonth = $wokingMonth->checkOpenMonth($invoiceDate->year, $invoiceDate->month, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
            return $msg->toJson();
        }

        try {
            $saveAntet = $modelnvoice->saveInvoice($idInvoice);

            if($saveAntet != 2){
                throw new \Exception("Factura este salvata deja in baza de date sau nu are articole!");
            }

            $msg->succes = true;
        }catch (\Exception $e){
            $msg->messages=  $e->getMessage();
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();

    }

    public function insertInvoiceArticol(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $invoiceAntet = $modelnvoice->selectEntity($request->idInvoice);

        try {
            if(count($invoiceAntet) != 1){
                throw new \Exception("Articolul nu se poate insera in baza de date. Lipseste factura!");
            }

            $param = $this->checkFieldInvoiceArticol($request->field, $invoiceAntet[0]->nProcTVA, $request->idInvoice);
            $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
            $modelnvoiceDetail->insertDetailInvoice($param['param']);

            $msg->succes = true;

        }catch (\Exception $e){
            $msg->messages= 'App error. Nu se poate inregistra articolul in baza de date.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();
    }

    public function insertInvoiceAntet(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        $param = $this->checkFieldInvoiceAntet($request->field);
        if( count($param['errorMsg']) > 0){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $param['errorMsg'];

            return $msg->toJson();
        }

        $wokingMonth = new WokingMonth(0,0,0,0);
        $dataInvoice = MyHelp::getSqlDateFormat($request->field['name_invoiceDate'], null);
        $openMonth = $wokingMonth->checkOpenMonth(intval($dataInvoice['year']), intval($dataInvoice['month']), new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));
        if(!$openMonth['open']){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $openMonth['msg'];
            return $msg->toJson();
        }

        try {
            $msg->succes = true;
            $modelInvoiceNumber = new ModelnvoiceNumber($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
            $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

            DB::beginTransaction();
                $invoiceNumber = $modelInvoiceNumber->getNumber(MyAppConstants::BUSS_NR_FACTURA_DANA);
                $param['param']['id_invoice_number'] = $invoiceNumber['id'];
                $msg->lastId = $modelnvoice->insertAntet($param['param']);

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();

            $msg->messages= 'Server error.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }

        return $msg->toJson();
    }


    private function checkFieldInvoiceArticol( $field, $procentTva, $idInvoice ){
        $param = ModelnvoiceDetail::getObjectForDetailInvoice();
        $errorMsg = [];

            $sumeTva = MyHelp::getValueFromSumaFaraTva($field['name_sumaArticol'], $procentTva);

            $param['idPk']='';
            $param['idInvoice']             =$idInvoice;
            $param['name_sumaArticol']      =$field['name_sumaArticol'];
            $param['name_articolFactura']   =$field['name_articolFactura'];
            $param['sumaTva']               =$sumeTva['sumaTva'];
            $param['nTotal']                =$sumeTva['total'];

        return ['param'=>$param, 'errorMsg'=>$errorMsg];
    }

    private function checkFieldInvoiceAntet($field){
        $param = Modelnvoice::getObjectInseretAntet();
        $errorMsg = [];

        // ----------------------------------------------------------------------------------
        $dataFormat = MyHelp::getSqlDateFormat($field['name_invoiceDate'], null);
        $invoiceDate = $dataFormat['dataFormat'];
        $param['name_invoiceDate']      = $invoiceDate;

        // ----------------------------------------------------------------------------------
        $param['name_nomPartner']       = intval($field['name_nomPartner']);
            if($param['name_nomPartner']<1){
                $errorMsg[]="Id-ul paretenerului este incorect.";
            }

        // ----------------------------------------------------------------------------------
        $param['name_nomInvoiceType'] = intval($field['name_nomInvoiceType']);
            if($param['name_nomInvoiceType']<1) {
                $errorMsg[] = "Id tip factura incorect.";
            }

        // ----------------------------------------------------------------------------------
        $param['name_tva']              = intval($field['name_tva']);
            if($param['name_tva']<1) {
                $errorMsg[] = "Procent TVA incorect.";
            }

        return ['param'=>$param, 'errorMsg'=>$errorMsg];
    }


    private function getInvoiceFileName($antet){
        $dts = new DateTime($antet['data_f']);

	    $client = str_replace(' ', '', $antet['cClient']);
	    $client = MyHelp::replaceROcharsToEN($client);
        $client = substr($client, 0, 5);
        $dataString  = date_format($dts,"Ymd");
        $invoiceNumber = str_replace(' ', '', $antet['cNr']);

        return $client . '_' . $dataString . '_' . $invoiceNumber . '.pdf';
    }

}
