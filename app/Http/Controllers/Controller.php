<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\allClass\helpers\ControllerHelp as MyAppHelp;
use App\Models\app\ModelLuniInchise;
use App\allClass\helpers\param\WokingMonth;
use App\MyAppConstants;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MyAppHelp;

    protected function isOpenMonth($year, $month){
	    $wokingMonth = new WokingMonth(0,0,0,0);
	    $openMonth = $wokingMonth->checkOpenMonth($year, $month, new ModelLuniInchise($this->getSession()->get(MyAppConstants::ID_AVOCAT), $this->getSession()->get(MyAppConstants::USER_ID_LOGEED)));

	    return $openMonth;
    }
}
