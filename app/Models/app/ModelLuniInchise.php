<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelLuniInchise extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_s_luni_inchise';
    }

    public function selectMonthList($year){
	    $rezult = DB::select(
            "select id, nLuna, inchisa
                        from
                            t_s_luni_inchise
                    where nAn = :year and id_avocat = :idAvocat
                    order by nLuna desc;"
            , ['year'=>$year , 'idAvocat' => $this->idAvocat]
        );

        return $rezult;
    }

    public function selectEntity($id){
        $rezult = DB::select(
            "
               select   
                    id,
                    id_avocat,
                    nLuna,
                    nAn,
                    inchisa,
                    created,
                    last_update,
                    id_user
                FROM t_s_luni_inchise
                 where id = ?;",
            [$id]
        );
        return $rezult;
    }
}
