<?php

namespace App\Models\app;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use App\allClass\helpers\response\SqlMessageResponse;
use Illuminate\Support\Facades\DB;

class ModelParteneri extends MyModel {
    public function __construct()
    {
        parent::__construct();
        $this->tableName = 't_parteneri';
    }

    public function update(){}
    public function delete(){}
    public function insert(){}
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
