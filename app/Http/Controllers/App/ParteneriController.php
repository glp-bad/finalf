<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\response\SqlMessageResponse;
use App\Http\Controllers\Controller;
use App\Models\app\ModelParteneri;
use App\Models\nomenclatoare\ModelNomTipPartener;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class ParteneriController extends Controller
{
    public function __construct(){}

    public function partenerGetData(Request $request) {
        $modelPartener = new ModelParteneri();
        $modelPartener->setIdAvocat($this->getSession()->get(MyAppConstants::ID_AVOCAT));

        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $modelPartener->selectForEdit($request->idPk);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function editPartener(Request $request) {
            //dd($request->sqlAction, $request->field, $request->idPk, $request->field['name_nume']);


            $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );

            if($request->sqlAction == MyAppConstants::CLIENT_SQL_UPDATE){
                if($this->checkField($request->field)){
                    $msg->messages= 'este un succes update-tul';
                }else{
                    $msg->succes = false;
                    $msg->lastId = -1;
                    $msg->messages= 'faild';
                }

            }elseif($request->sqlAction == MyAppConstants::CLIENT_SQL_DELETE){
            }elseif ($request->sqlAction == MyAppConstants::CLIENT_SQL_INSERT){
                if($this->checkField($request->field)){
                    $msg->succes = false;
                    $msg->lastId = -1;
                    $msg->messages= 'faild';
                }else{
                    $msg->succes = false;
                    $msg->lastId = -1;
                    $msg->messages= 'faild';
                }
            }

            return $msg->toJson();
    }


    public function gridListParteneri(Request $request) {
        $gridPaginateOrderFilter = new GridPaginateOrderFilter($request);
        $partneriList = new ModelParteneri();
        $partneriList->setIdAvocat($this->getSession()->get(MyAppConstants::ID_AVOCAT));

        return $partneriList->selectForGrid($gridPaginateOrderFilter);
    }


    public function nomTipPartener(Request $request) {
        $nom = new ModelNomTipPartener();
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();
        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }

    private function checkField($field){
        $field["name_nume"];
        $field["name_nomTipPartener"];
        $field["name_cui"];
        $field["name_ro"];
        $field["name_skipCheckCode"];
        $field["name_regcom"];

        return true;

    }

}
