<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\WokingMonth;

class ModelLuniInchise extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_s_luni_inchise';
    }

	public function checkMonth(WokingMonth $param){
		$rezult = DB::update(
			"update t_s_luni_inchise 
						set inchisa = :inchisa,
							last_update = :lastUpdate, id_user = :id_user 
	                    where id = :id and id_avocat = :idAvocat;",
			['id'=> $param->id, 'inchisa'=> $param->check, 'lastUpdate' => MyHelp::getCarbonDateNow(),'id_user'=>$this->idUser, 'idAvocat' => $this->idAvocat]
		);

		return $rezult;
	}


	public function insertMonth(WokingMonth $param){
		$rezult = DB::insert(
			"insert into t_s_luni_inchise (id_avocat, nLuna, nAn, inchisa, id_user) values (:idAvocat, :luna, :yearWork, :inchisa, :id_user);",
			['idAvocat' => $this->idAvocat, 'luna' =>$param->month, 'yearWork' => $param->year, 'inchisa' => 0, 'id_user'=>$this->idUser]
		);

		$lastIdInserted = DB::getPdo()->lastInsertId();

		return $lastIdInserted;
	}


	public function selectWorkingMonth(WokingMonth $param){
		$rezult = DB::select(
			"select inchisa
                        from
                            t_s_luni_inchise
                    where nAn = :yearWork and nLuna = :monthWork and id_avocat = :idAvocat;"
			, ['yearWork'=>$param->year , 'monthWork'=> $param->month, 'idAvocat' => $this->idAvocat]
		);

		return $rezult;
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
