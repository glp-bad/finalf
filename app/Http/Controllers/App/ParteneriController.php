<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\response\SqlMessageResponse;
use App\allClass\helpers\Check;
use App\Http\Controllers\Controller;
use App\Models\app\ModelPartenerContBanca;
use App\Models\app\ModelParteneri;
use App\Models\app\ModelPartenerAdrese;
use App\Models\nomenclatoare\ModelNomLocalitati;
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


    public function editAdressPartener(Request $request) {

        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        $modelPartenerAdrese = new ModelPartenerAdrese($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        $dataInsert = $this->checkFieldAdress($request->idPk, $request->idPartner, $request->field);


        if( count($dataInsert['errorMsg']) > 0){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $dataInsert['errorMsg'];

            return $msg->toJson();
        }

        //  -------------------------------------------------------------------------------


        if($request->sqlAction == MyAppConstants::CLIENT_SQL_UPDATE){
            try {
                $insert = $modelPartenerAdrese->update($dataInsert['field']);
                $msg->lastId = $insert;

                if($insert < 1){
                    $msg->messages= 'Datele nu s-au inregistrat.';
                    $msg->succes = false;

                }else{
                    $msg->messages= 'Datele s-au inregistrat cu succes!';
                    $msg->succes = true;
                }

            }catch (\Exception $e){
                $msg->messages= 'Server error.';
                $msg->errorMsg = $e->getMessage();
                $msg->succes = false;
            }

        }elseif($request->sqlAction == MyAppConstants::CLIENT_SQL_INSERT){
            try {
                $insert = $modelPartenerAdrese->insert($dataInsert['field']);
                $msg->lastId = $insert;

                if($insert < 1){
                    $msg->messages= 'Datele nu s-au inregistrat.';
                    $msg->succes = false;

                }else{
                    $msg->messages= 'Datele s-au inregistrat cu succes!';
                    $msg->succes = true;
                }

            }catch (\Exception $e){
                $msg->messages= 'Server error.';
                $msg->errorMsg = $e->getMessage();
                $msg->succes = false;
            }
        }
           return $msg->toJson();
    }

    public function gridListParteneri(Request $request) {
        $gridPaginateOrderFilter = new GridPaginateOrderFilter($request);
        $partneriList = new ModelParteneri($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
        return $partneriList->selectForGrid($gridPaginateOrderFilter);
    }

    public function listaAdrese(Request $request) {
        $modelPartenerAdrese = $this->getModelPartenerAdrese();

        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $modelPartenerAdrese->selectAdresePartener(intval($request['idPartner']));

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }

    public function listBancCont(Request $request) {
        $modelPartenerBancCount = $this->getModelPartenerBancCount();

        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $modelPartenerBancCount->selectConturiPartener(intval($request['idPartner']));

        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }


    public function setBancCont(Request $request) {
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );
        $modelPartenerBancCount = $this->getModelPartenerBancCount();
        $modelPartenerBancCount->setDefaultCont(intval($request->idPk), intval($request->idPartner));

        return $msg->toJson();
    }

	public function setActivAdress(Request $request) {
        $msg = $this->getSqlMessageResponse(true, "no msg", -1, null, null, false );

		$modelPartenerAdrese = $this->getModelPartenerAdrese();
		$modelPartenerAdrese->setDefaultAdress(intval($request->idPk), intval($request->idPartner));

        return $msg->toJson();
	}

    public function editAccountPartener(Request $request) {
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        $dataInsert = $this->checkFieldAccount($request->idPk, $request->idPartner, $request->field);
        if( count($dataInsert['errorMsg']) > 0){
            $msg->succes = false;
            $msg->lastId = -1;
            $msg->messages= $dataInsert['errorMsg'];

            return $msg->toJson();
        }

        //  -------------------------------------------------------------------------------
            $modelPartenerBancCount = $this->getModelPartenerBancCount();
            try {
                $msg->succes = true;

                if($request->sqlAction == MyAppConstants::CLIENT_SQL_UPDATE){
                    $msg->lastId = $modelPartenerBancCount->update($dataInsert['field']);
                    if($msg->lastId < 1){
                        $msg->messages= 'Datele nu au putut fi modificate.';
                        $msg->succes = false;
                    }else{
                        $msg->messages= 'Datele au fost modificate.';
                    }
                }elseif($request->sqlAction == MyAppConstants::CLIENT_SQL_INSERT) {
                    $msg->lastId = $modelPartenerBancCount->insert($dataInsert['field']);
                    if($msg->lastId < 1){
                        $msg->messages= 'Datele nu s-au inregistrat.';
                        $msg->succes = false;
                    }else{
                        $msg->messages= 'Datele s-au inregistrat.';
                    }
                }

            }catch (\Exception $e){
                $msg->messages= 'Server error.';
                $msg->errorMsg = $e->getMessage();
                $msg->succes = false;
            }

        return $msg->toJson();

    }


	public function nomLocalitati(Request $request) {

		$nom = new ModelNomLocalitati($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
		$succes = true;
		$lastId = -1;
		$messages = null;
		$records  = $nom->selectForSearchDropDown($request->wordSearch);

		return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
	}

    public function nomTipPartener() {
        $nom = new ModelNomTipPartener($this->getSession()->get(MyAppConstants::ID_AVOCAT), null);
        $succes = true;
        $lastId = -1;
        $messages = null;
        $records  = $nom->selectForSimpleDropDown();
        return json_encode(new SqlMessageResponse($succes, $lastId, $messages, $records));
    }

    private function getModelPartenerAdrese(){
    	return new ModelPartenerAdrese($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
    }


    private function getModelPartenerBancCount(){
        return new ModelPartenerContBanca($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));
    }


    private function checkFieldAccount($idPk, $idPartener, $field){

        $arrayReturn = ModelPartenerContBanca::getObjectForUpdateInsert();
        $errorMsg = [];

        $arrayReturn['idPk'] = $idPk;


        // -----------------------------------------------------------------------------------------------------
        $sucursalaLength = strlen($field["name_sucursala"]);
        if($sucursalaLength < 1 || $sucursalaLength > 30){
            $errorMsg[]="Sucursala trebuie sa aiba intre 1 si 30 de caractere.";
        }
        $arrayReturn['sucursala'] = $field["name_sucursala"];


        // -----------------------------------------------------------------------------------------------------
        $bancaLength = strlen($field["name_banca"]);
        if($bancaLength < 1 || $bancaLength > 30){
            $errorMsg[]="Banca trebuie sa aiba intre 1 si 30 de caractere.";
        }
        $arrayReturn['banca'] = $field["name_banca"];


        // -----------------------------------------------------------------------------------------------------
        $checkIabn = Check::iban($field["name_inputIban"]);

        if(!$checkIabn){
            $errorMsg[]="IABN invalid.";
        }

        $arrayReturn['iban'] = $field["name_inputIban"];



        // -----------------------------------------------------------------------------------------------------
        if(intval($idPartener)<1){
            $errorMsg[]="Trebuie sa alegi un partener ca sa poti adauga un cont!";
        }

        $arrayReturn['idPartener'] = $idPartener;

        return ['field'=>$arrayReturn, 'errorMsg'=>$errorMsg];
    }

    private function checkFieldAdress($idPk, $idPartener, $field){
        $arrayReturn = ModelPartenerAdrese::getObjectForUpdateInsert();
        $errorMsg = [];

        $arrayReturn['idPk'] = $idPk;

        // -----------------------------------------------------------------------------------------------------
        $adressaLength = strlen($field["name_adresa"]);
        if($adressaLength < 6 || $adressaLength > 200){
            $errorMsg[]="Adresa trebuie sa aiba intre 6 si 200 de caractere.";
        }
        $arrayReturn['adresa'] = $field["name_adresa"];

        // -----------------------------------------------------------------------------------------------------
        $arrayReturn['idLocalitate'] = $field["name_nomLocalitati"];

        if(intval($arrayReturn['idLocalitate'])<1){
            $errorMsg[]="Trebuie sa alegi o localitate.";
        }

        // -----------------------------------------------------------------------------------------------------
        $arrayReturn['idPartener'] = $idPartener;

        if(intval($arrayReturn['idPartener'])<1){
            $errorMsg[]="Trebuie sa alegi un partener ca sa poti adauga o adresa!";
        }


        return ['field'=>$arrayReturn, 'errorMsg'=>$errorMsg];

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
