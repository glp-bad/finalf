<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\response\SqlMessageResponse;
use App\allClass\helpers\Check;
use App\Http\Controllers\Controller;
use App\Models\app\ModelParteneri;
use App\Models\nomenclatoare\ModelNomTipPartener;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class ParteneriController extends Controller
{
    public function __construct(){}

    public function partenerGetData(Request $request) {
        $modelPartener = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $modelPartener->selectForEdit($request->idPk);

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function editPartener(Request $request) {
            $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

            if($request->sqlAction == MyAppConstants::CLIENT_SQL_UPDATE){
                $dataUpdate = $this->checkField($request->idPk, $request->field);
                if( count($dataUpdate['errorMsg']) > 0){
                    $msg->succes = false;
                    $msg->lastId = -1;
                    $msg->messages= $dataUpdate['errorMsg'];
                } else {
                    $modelParteneri = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
                    try {
                        $updateCount = $modelParteneri->update($dataUpdate['field']);
                        if($updateCount == 0){
                            $msg->messages= 'Inregistrarea nu a fost gasita! Datele nu s-au actualizat.';
                            $msg->succes = false;

                        }else{
                            $msg->messages= 'Datele s-au actualizat cu succes!';
                            $msg->succes = true;

                        }

                    }catch (\Exception $e){
                        $msg->messages= $e->getMessage();
                        $msg->succes = false;
                    }
                }
            }elseif($request->sqlAction == MyAppConstants::CLIENT_SQL_DELETE){
            }elseif ($request->sqlAction == MyAppConstants::CLIENT_SQL_INSERT){
                $dataUpdate = $this->checkField($request->idPk, $request->field);
                if( count($dataUpdate['errorMsg']) > 0){
                    $msg->succes = false;
                    $msg->lastId = -1;
                    $msg->messages= $dataUpdate['errorMsg'];
                } else {
                    $modelParteneri = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
                    try {
                        $insert = $modelParteneri->insert($dataUpdate['field']);
                        $msg->lastId = $insert;

                        if($insert < 1){
                            $msg->messages= 'Datele nu s-au inregistrat.';
                            $msg->succes = false;

                        }else{
                            $msg->messages= 'Datele s-au inregostrat cu succes!';
                            $msg->succes = true;
                        }

                    }catch (\Exception $e){
                        $msg->messages= $e->getMessage();
                        $msg->succes = false;
                    }


                }

            }

            return $msg->toJson();
    }


    public function gridListParteneri(Request $request) {
        $gridPaginateOrderFilter = new GridPaginateOrderFilter($request);
        $partneriList = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        return $partneriList->selectForGrid($gridPaginateOrderFilter);
    }


    public function nomTipPartener() {
        $nom = new ModelNomTipPartener($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();
        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }

    private function checkField($idPk, $field){

        $arrayReturn = ModelParteneri::getObjectForUpdateInsert();
        $errorMsg = [];

        $arrayReturn['idPk'] = $idPk;

        // -----------------------------------------------------------------------------------------------------
            $nameLength = strlen($field["name_nume"]);
            if($nameLength < 2 || $nameLength > 150){
                $errorMsg[]="Numele trebuie sa aiba intre 2 si 150 de caractere.";
            }
            $arrayReturn['cnume'] = $field["name_nume"];

        // -----------------------------------------------------------------------------------------------------
            if(intval($field["name_nomTipPartener"]) < 1){
                $errorMsg[]="Trebuie sa completezi tipul de partener.";
            }

            $arrayReturn['idTip'] = $field["name_nomTipPartener"];
        // -----------------------------------------------------------------------------------------------------
            $checkCui = true;
            if(!$field["name_skipCheckCode"]){
                $nom = new ModelNomTipPartener($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
                $nomTipPartener = $nom->selectEntity(intval($field["name_nomTipPartener"]));

                //dd($nomTipPartener);

                if(MyAppConstants::BUSS_TIP_PARTENER_PERSOANA_FIZICA == $nomTipPartener[0]->cTipAbrev ){
                    $checkCui = Check::cnp($field["name_cui"]);
                }else{
                    $checkCui = Check::cif($field["name_cui"]);
                }

                if(!$checkCui){
                    $errorMsg[]="CUI invalid.";
                }

            }

            $arrayReturn['cui']= $field["name_cui"];

        // -----------------------------------------------------------------------------------------------------
            $arrayReturn['regcom'] = $field["name_regcom"];

        // -----------------------------------------------------------------------------------------------------
            if($field["name_ro"]){
                $ro = MyAppConstants::BUSS_STRING_CUI_RO;
            }else{
                $ro = MyAppConstants::BUSS_STRING_CUI_WITHOUT_RO;
            }
            $arrayReturn['ro'] = $ro;

        return ['field'=>$arrayReturn, 'errorMsg'=>$errorMsg];

    }

}
