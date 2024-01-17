<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use App\Models\app\ModelAnafToken;
use App\Models\app\ModelAnafUrl;


class AnafController extends Controller
{


    private $accesToken = '';   
    private $accesUrl = array();
    private $mediu = MyAppConstants::EFACTURA_MEDIU['test'];
    //private $mediu = MyAppConstants::EFACTURA_MEDIU['prod'];   // url productie
    private $applicatieAnaf = MyAppConstants::EFACTURA_APP['efactura'];


    public function __construct(){}


    public function listaMesajeFactura(Request $request){
        $this->getAccesTokenAndLink($request);
        $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );
        

        if(empty($this->accesToken)){
            $msg->messages =  'Nu am tokenul inregistrat in baza de date!';
        }else{

            $msg->succes = true;
            $msg->messages = 'Raspund din metoda => ' . $this->accesUrl[MyAppConstants::EFACTURA_METHODS['listaMesajeFactura']];    

        }

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
