<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use App\Models\app\ModelAnafToken;
use App\Models\app\ModelAnafUrl;
use App\Models\app\ModelnvoiceXml;
use App\Models\bussines\BussinesAnafSpv;
use App\Models\app\ModelAnafListaMesaje;
use App\Models\app\ModelAnafListaMesajeBuffer;
use App\allClass\helpers\param\ParamAnafListaMesaje;




class AnafController extends Controller
{


    private $accesToken = '';   
    private $accesUrl = array();
    private $mediu = MyAppConstants::EFACTURA_MEDIU['test'];
    //private $mediu = MyAppConstants::EFACTURA_MEDIU['prod'];   // url productie
    private $applicatieAnaf = MyAppConstants::EFACTURA_APP['efactura'];
    private $paramInvoiceStandard = 'UBL'; // de la ANAF, nu stiu ce inseamna
    private $cif = '20925958'; // cif cont


    public function __construct(){}


    /** lista de raspunsuri disponibile pentru descarcare */
    public function listaMesajeFactura(Request $request) {
        $idAvocat   = $this->getSession()->get(MyAppConstants::ID_AVOCAT);
        $idUser     = $this->getSession()->get(MyAppConstants::USER_ID_LOGEED);

        $this->getAccesTokenAndLink($request);
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        if(empty($this->accesToken)){
            $msg->succes = false;
            $msg->messages =  'Nu am tokenul inregistrat in baza de date!';
            return $msg->toJson();
        }

        $urlParam = '?zile=60&cif=' . $this->cif;
        $url = $this->accesUrl[MyAppConstants::EFACTURA_METHODS['listaMesajeFactura']] . $urlParam;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($curl, CURLOPT_TIMEOUT, 45);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/xml; charset=UTF-8',
            $this->getAuthorizationBearer(),
            'Cache-Control: no-cache'
        ]);

		$response = curl_exec($curl);
        $responseArray = json_decode($response, TRUE); // "{"eroare":"Nu aveti drept in SPV pentru CIF=1234567","titlu":"Lista Mesaje"}"

        if(isset($responseArray['eroare']))
        {    
            $msg->succes = false;
            $msg->messages = 'Mesaj from SPV. <br> Eroare=> ' . $responseArray['eroare'] . ', <br> Titlu=> ' .  $responseArray['titlu'];    
            return $msg->toJson();
        }

        $bussinesAnafSpv = new BussinesAnafSpv($idAvocat, $idUser);
        $rezultTruncate = $bussinesAnafSpv->truncateMesajeAnafBuffer(); // empty buffer table

        if(!$rezultTruncate){
            $msg->succes = false;
            $msg->messages = 'Alerta. Nu pot sterge datele din tabela buffer! ' . 'BussinesAnafSpv.';    
            return $msg->toJson();
        }


        $modelAnafListaMesajeBuffer = new ModelAnafListaMesajeBuffer($idAvocat, $idUser);
                foreach($responseArray['mesaje'] as $m){
            $paramAnafListaMesaje = new ParamAnafListaMesaje($m, $responseArray['serial']);
            $modelAnafListaMesajeBuffer->insertMessage($paramAnafListaMesaje);
        }

        // transfer from buffer and clean the buffer
        $rezultInsert = $bussinesAnafSpv->insertMesajeAnaf();
        $rezultTruncate = $bussinesAnafSpv->truncateMesajeAnafBuffer();

        if($rezultInsert && $rezultTruncate){
            $msg->succes = true;
            $msg->messages = 'Lista de mesaje de pe SPV a fost importata.';    
            return $msg->toJson();
        }else{
            $msg->succes = false;
            $msg->messages = 'Alerta: insert=' . $rezultInsert . ', truncate: ' . $rezultTruncate . ' Call admin.';    
            return $msg->toJson();
        }


        
        
        
        

        //dd($responseArray);

        
         //"data_creare" => "202312220000"
         //"cif" => "20925958"
         //"id_solicitare" => "4130210920"
         //"detalii" => "Factura cu id_incarcare=4130210920 emisa de cif_emitent=14399840 pentru cif_beneficiar=20925958"
         //"tip" => "FACTURA PRIMITA"
         //"id" => "3172755007"
        
        
    }

    /**
     * upload invoices
     */
    public function upload(Request $request){

        $idAvocat = $this->getSession()->get(MyAppConstants::ID_AVOCAT);
        $idUser = $this->getSession()->get(MyAppConstants::USER_ID_LOGEED);

        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        $this->getAccesTokenAndLink($request);
        if(empty($this->accesToken)){
            $msg->messages =  'Nu am tokenul inregistrat in baza de date!';
            return $msg->toJson();
        }

        // get parameter from request
        //$invoiceId = $request->field["invoiceId"];
        $invoiceId = 5380;      // factura de test

        $modelnvoiceXml = new ModelnvoiceXml($idAvocat, $idUser);
        $invoiceXml = $modelnvoiceXml->selectEntityByInvoiceId($invoiceId);

        $efactura = $invoiceXml[0]->e_factura;
        $paramUpload = '?standard=' . $this->paramInvoiceStandard . '&cif='  . $this->cif . '5'; 
        $urlUpload = $this->accesUrl[MyAppConstants::EFACTURA_METHODS['upload']] . $paramUpload;

                
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $urlUpload);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $efactura);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
		curl_setopt($curl, CURLOPT_TIMEOUT, 45);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, [
			'Content-Type: application/xml; charset=UTF-8',
			$this->getAuthorizationBearer(),
			'Cache-Control: no-cache'
		]);

        $response = curl_exec($curl);
        $responseXML = @simplexml_load_string($response);


        $indexIncarcare = '';

        if (empty($responseXML)) {
            $msg->succes = false;
            $msg->messages = 'Eroare-> Nu am primtr raspuns de la server-ul ANAF.';    
            return $msg->toJson();
        }


        $info = $errors = [];
        $errMsg = '';
        foreach ($responseXML->attributes() as $key => $value) {
            $info[$key] = (string)$value;
            if (strcasecmp('index_incarcare', $key) == 0) {
                $indexIncarcare = trim($value);
            }
        }

        if (isset($responseXML->Errors)) {
            foreach ($responseXML->Errors->attributes() as $k => $v) {
                $errors[$k] = (string)$v;
                $errMsg .= htmlentities(strip_tags($v)) . "<br />";
            }			
        }

        dd([$response   ,$info, $errors, $errMsg, 'indexIncarcare'=>$indexIncarcare]);

        

        
        curl_close($curl);

		

        
        $msg->succes = true;
        $msg->messages = 'URL upload => ' . $urlUpload;
        return $msg->toJson();
        
    }

    public function testOauth(Request $request){
        $this->getAccesTokenAndLink($request);

        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        // $token = $this->getAnafToken($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        if(empty($this->accesToken)){
            $msg->messages =  'Nu am tokenul inregistrat in baza de date!';

        }else{
            $linkTestOuath = 'https://api.anaf.ro/TestOauth/jaxrs/hello?name=GLP';
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $linkTestOuath);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
            curl_setopt($curl, CURLOPT_TIMEOUT, 45);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [$this->getAuthorizationBearer()]);

                                
            $response = curl_exec($curl); 

            $error = curl_error($curl);
            if ($error) {
                $msg->succes = false;
                $msg->messages = "error: " . $error;
                
            }else{
                $msg->succes = true;
                $msg->messages = $response;
            }

            curl_close($curl);

        }


        return $msg->toJson();
    }


    private function getAuthorizationBearer(){
        return "Authorization: Bearer {$this->accesToken}";
    }

    private function getAccesTokenAndLink(Request $request){

        $idAvocat = $this->getSession()->get(MyAppConstants::ID_AVOCAT);
        $idUser = $this->getSession()->get(MyAppConstants::USER_ID_LOGEED);

        $token = $this->getAnafToken($idAvocat, $idUser);
        $this->accesToken = $token[0]->acces_token;

        $this->getAnafUrl($idAvocat, $idUser);
    }

    private function getAnafUrl($idAvocat, $idUser){
        $modelAnafUrl = new ModelAnafUrl($idAvocat, $idUser);

        // selectUrl($app, $mediu, $action)
        $url = $modelAnafUrl->selectUrl($this->applicatieAnaf, $this->mediu);

        foreach($url as $u){
            $this->accesUrl[$u->action] = $u->url;
        }
    }

    private function getAnafToken($idAvocat, $idUser){

        $minimDayForRefreshToken = 5;

        $modelAnafToken = new ModelAnafToken($idAvocat, $idUser);
        $token = $modelAnafToken->selectEntityByAvocat();

        if(empty($token)){
            return null;
        }
        if(empty($token[0]->acces_token)){
            return null;
        }

        if($token[0]->valid_day > $minimDayForRefreshToken ){
            return $token;
        }else{
            // refresh token



        }

        return $token;
    }

   

    /** pentru test */
    public function callbackEfactura(Request $request){
        // doNothing doar pentru test
        //return response('Test API din controller', 200);
        // call https://finalf.badmintonclub.ro.mydev/api/eFacturaTest?idg=TACI

        if(empty($request['idg'])){
            echo 'nimic, lipseste codul';
            //return true;
        }else{
            echo $request['idg'];  
        }
        
    }


}
