<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class AnafController extends Controller
{
    public function __construct(){}

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
