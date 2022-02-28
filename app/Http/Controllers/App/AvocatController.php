<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\app\ModelLuniInchise;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class AvocatController extends Controller
{
    public function __construct(){}

    public function monthList(Request $request) {
        $msg = $this->getSqlMessageResponse(false, null, -1, null, null, false );
        $modelLuni =  new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED));

        $msg->succes = true;
        // $request->year
        $msg->records  = $modelLuni->selectMonthList(2019);

        return $msg->toJson();
    }

}
