<?php

namespace App\Models\bussines;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;

class BussinesInvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = null;
    }


    public function gridFacturiPartener(GridPaginateOrderFilter $gridSet){

        $paginate   = $gridSet->getPaginate();
        $pageNumber = $paginate['offsetPage'];
        $perPage    = $paginate['perPage'];

        $orderBy  = $gridSet->getOrder();
        $filterBy = $gridSet->getFilter();
        $additionalFilter = $gridSet->getAdditionlFilter();

        $whereFilterBy =  '';

        if(!empty($filterBy)){
            $whereFilterBy = 'where ' .  $filterBy;
        }

        $count = DB::select(
            "select count(*) as c
                    from
                        (select distinct t_factura.id
                            from t_factura
                                inner join t_factura_d on t_factura_d.id_factura = t_factura.id
                            where t_factura.id_avocat = $this->idAvocat and t_factura.id_part = {$additionalFilter['id_part']} and t_factura.salvata = 1
                        ) as sume_facturi
                    inner join  t_factura on t_factura.id = sume_facturi.id
                    $whereFilterBy"
        );

        $rezult = DB::select(
            " select t_factura.id, 
                        t_factura.data_f, 
                        t_facturi_numar.cNr as nr_f,  
                        t_factura.id_part,
                        t_factura.nProcTVA,
                        sume_facturi.nSumaFaraTva, sume_facturi.nSumaTVA, sume_facturi.nTotal
                    from
                        (
                             select t_factura.id, sum(nSumaFaraTva) as nSumaFaraTVA, sum(nSumaTVA) as nSumaTVA, sum(nTotal) as nTotal
                                from t_factura
                                    inner join t_factura_d on t_factura_d.id_factura = t_factura.id
                                where t_factura.id_avocat = $this->idAvocat and t_factura.id_part = {$additionalFilter['id_part']} and t_factura.salvata = 1
                                group by t_factura.id
                        ) as sume_facturi
                    inner join  t_factura on t_factura.id = sume_facturi.id
                    inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                    $whereFilterBy
                    order by $orderBy  LIMIT $perPage OFFSET $pageNumber;"
        );

        return PaginateResponse::get($count[0]->c, $rezult);
    }


}
