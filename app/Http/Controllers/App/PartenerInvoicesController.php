<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Http\Controllers\Controller;
use App\Models\app\ModelnvoiceNumber;
use App\Models\bussines\BussinesInvoice;
use App\Models\app\ModelParteneri;
use App\Models\nomenclatoare\ModelNomTipFactura;
use App\MyAppConstants;
use \Illuminate\Http\Request;


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

    public function nomInvoiceType(Request $request) {
        $nom = new ModelNomTipFactura($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown($request->wordSearch);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function insertInvoiceAntet(Request $request) {
        $invoiceNumber = new ModelnvoiceNumber($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $invoiceNumber->getNumber(MyAppConstants::BUSS_NR_FACTURA_DANA['nTip']);
    }

}
