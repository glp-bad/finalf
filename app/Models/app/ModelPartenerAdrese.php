<?php

namespace App\Models\app;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;

class ModelPartenerAdrese extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_parteneri_adrese';
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " SELECT `t_parteneri_adrese`.`id`,
                        `t_parteneri_adrese`.`id_part`,
                        `t_parteneri_adrese`.`cAdresa`,
                        `t_parteneri_adrese`.`id_localitate`,
                        `t_parteneri_adrese`.`activ`,
                        `t_parteneri_adrese`.`id_user`,
                        `t_parteneri_adrese`.`created`,
                        `t_parteneri_adrese`.`last_update`
                     FROM `t_parteneri_adrese`
	                 where t_parteneri.id = :id;"
            , ['id'=>$id]
        );

        return $rezult;
    }

    public function selectAdresePartener($idPartener){
        $rezult = DB::select(
            " SELECT t_parteneri_adrese.id,
		                    t_parteneri_adrese.id_part,
		                    t_parteneri_adrese.cAdresa,
                            concat(t_localitati.cLocalitate,'/ ',t_judete.cJudetAbrev, ' (', t_localitati_tip.cTip ,')') as localitate,
                            t_parteneri_adrese.activ,
		                    t_parteneri_adrese.id_localitate
                    FROM t_parteneri_adrese
		                inner join t_localitati on t_localitati.id = t_parteneri_adrese.id_localitate
		                inner join t_localitati_tip on t_localitati_tip.id = t_localitati.id_tip
                        inner join t_judete on t_judete.id = t_localitati.id_judet
                    where t_parteneri_adrese.id_part = :idPartener
                    order by activ desc;"
                , ['idPartener'=>$idPartener]
        );

        return $rezult;
    }

}