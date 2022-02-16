<?php

namespace App\Models\app;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;

class ModelParteneri extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_parteneri';
    }

    public function update($r){
         $rezult = DB::update(
                "update  t_parteneri set 
                            cNume = :cNume,
                            id_tip = :id_tip, 
                            regcom = :regcom, 
                            ro_ = :ro_, 
                            cui = :cui,
                            id_user= :id_user,
                            last_update = :lastUpdate
                            where t_parteneri.id_avocat = :idAvocat and t_parteneri.id =  :id;",
                ['cNume' => $r['cnume'], 'id_tip' => $r['idTip'], 'regcom' => $r['regcom'], 'ro_' => $r['ro'], 'cui' => $r['cui'], 'lastUpdate' => MyHelp::getCarbonDateNow(), 'idAvocat' => $this->idAvocat, 'id' => $r['idPk'], 'id_user'=>$this->idUser]
            );

         return $rezult;
    }

    public function delete(){}
    public function insert($r){
        $rezult = DB::insert(
            "insert into t_parteneri (id_avocat, cNume, id_tip,regcom, ro_, cui, id_user) values (:id_avocat, :cNume, :id_tip,:regcom, :ro_, :cui, :id_user);",
                ['cNume' => $r['cnume'], 'id_tip' => $r['idTip'], 'regcom' => $r['regcom'], 'ro_' => $r['ro'], 'cui' => $r['cui'], 'id_avocat' => $this->idAvocat, 'id_user'=>$this->idUser]
        );

        unset($rezult);

        return DB::getPdo()->lastInsertId();
    }

    public function select(){}

    public function selectForEdit($id){
        $rezult = DB::select(
            " select t_parteneri.cNume,
                            t_parteneri.id_tip, 
                            t_parteneri.regcom, 
                            t_parteneri.ro_, 
                            t_parteneri.cui 
                        from t_parteneri
	                    where t_parteneri.id_avocat = $this->idAvocat and t_parteneri.id = $id;"
        );

        return $rezult;
    }


    public static function getObjectForUpdateInsert(){
        $arrayReturn = [
            'idPk'  => null,
            'cnume' => null,
            'idTip' => 0,
            'regcom' => null,
            'ro'=> null,
            'cui'=>null
        ];

    }


    public function selectForSearchDropDown($wordSearch){

         $rezult = DB::select("
					select a.id, a.caption
					FROM 
					(
	                    SELECT t_parteneri.id,
	                            concat(t_parteneri.cNume,'/ ',t_parteneri.cui) as caption
						from t_parteneri 
	                    where t_parteneri.id_avocat= :idAvocat
	                    order by t_parteneri.cNume   
	                ) a    
	                where a.caption like '%$wordSearch%'",
            ['idAvocat'=> $this->idAvocat]
         );

        return $rezult;
    }

    public function selectForGrid(GridPaginateOrderFilter $gridSet){
        $paginate   = $gridSet->getPaginate();
        $pageNumber = $paginate['offsetPage'];
        $perPage    = $paginate['perPage'];

        $orderBy  = $gridSet->getOrder();
        $filterBy = $gridSet->getFilter();

        $whereFilterBy =  ' where t_parteneri.id_avocat = ' . $this->idAvocat;

        if(!empty($filterBy)){
            $whereFilterBy = ' AND ' .  $filterBy;
        }

        $count = DB::select(
            "select count(*) as c from t_parteneri inner join  t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip $whereFilterBy"
        );

        $rezult = DB::select(
            " select t_parteneri.id, t_parteneri.id_avocat, t_parteneri.cNume,
                            t_tip_organizare_juridica.cTipAbrev, 
                            t_parteneri.id_tip, 
                            t_parteneri.regcom, t_parteneri.ro_, t_parteneri.cui 
                        from t_parteneri
	                    inner join  t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip
	                    $whereFilterBy 
	                    order by $orderBy  LIMIT $perPage OFFSET $pageNumber;"
        );

        return PaginateResponse::get($count[0]->c, $rezult);

    }
}
