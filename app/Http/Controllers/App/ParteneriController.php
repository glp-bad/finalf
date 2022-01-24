<?php

namespace App\Http\Controllers\App;

use App\allClass\helpers\GridPaginateOrderFilter;
use App\Http\Controllers\Controller;
use App\Models\app\ModelParteneri;
use App\MyAppConstants;
use \Illuminate\Http\Request;


class ParteneriController extends Controller
{
    public function __construct(){}

    public function gridListParteneri(Request $request) {
        $gridPaginateOrderFilter = new GridPaginateOrderFilter($request);
        $partneriList = new ModelParteneri();
        $partneriList->setIdAvocat($this->getSession()->get(MyAppConstants::ID_AVOCAT));

        return $partneriList->selectForGrid($gridPaginateOrderFilter);
    }


}
