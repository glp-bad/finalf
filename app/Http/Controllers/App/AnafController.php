<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\MyAppConstants;
use \Illuminate\Http\Request;
use App\Models\app\ModelAnafToken;


class AnafController extends Controller
{
    public function __construct(){}



    public function testOauth(Request $request){

                $msg = $this->getSqlMessageResponse(false, "no msg", -1, null, null, false );

        $token = $this->getAnafToken($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        if(empty($token)){
            $msg->messages =  'Nu am tokenul inregisrat in baza de date!';
        }else{

                       
            $linkTestOuath = 'https://api.anaf.ro/TestOauth/jaxrs/hello?name="GLP 6000 merge!"';

            
            $curl = curl_init();

            /*
            curl_setopt($curl, CURLOPT_URL, 'https://example.com/api/endpoint');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                "Authorization: Bearer <token>"
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            */

            curl_setopt($curl, CURLOPT_URL, $linkTestOuath);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
            curl_setopt($curl, CURLOPT_TIMEOUT, 45);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);
            // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: text/plain; charset=UTF-8', "Authorization: Bearer " . trim($token[0]->acces_token)  ]);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer '{$token[0]->acces_token}'", 'Cache-Control: no-cache']);

                                
            $response = curl_exec($curl); 

            $error = curl_error($curl);
            if ($error) {
                dd("error: " . $error);
            }

            curl_close($curl);

            $msg->messages = $response;


        }


        return $msg->toJson();
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
