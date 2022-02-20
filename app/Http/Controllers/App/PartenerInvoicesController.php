<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Http\Controllers\Controller;
use App\Models\app\ModelInvoiceTemplate;
use App\Models\app\ModelnvoiceDetail;
use App\Models\app\ModelnvoiceNumber;
use App\Models\bussines\BussinesInvoice;
use App\Models\app\ModelParteneri;
use App\Models\app\Modelnvoice;
use App\Models\nomenclatoare\ModelNomTipFactura;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PartenerInvoicesController extends Controller
{
    public function __construct(){}

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

        $id = -1;

        if(isset($request->idInvoice)){
            $id = $request->idInvoice;
        }

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
            $msg->messages= 'App error. Nu se poate sterge antetul. Incercati relogarea in aplicatie.';
            $msg->errorMsg = $e->getMessage();
            $msg->succes = false;
        }


        return $msg->toJson();
    }

    public function deleteInvoiceAntet(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelnvoice = new Modelnvoice($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $modelnvoiceDetail = new ModelnvoiceDetail($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        // dd($request->idPk);

        $id = $request->idPk;

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
            DB::rollBack();
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
        $invoiceDate = MyHelp::getSqlDateFormat($field['name_invoiceDate'], null);
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

}
