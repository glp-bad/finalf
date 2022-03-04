<?php

namespace App\Models\bussines;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\IncomingList;

class BussinesInvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = null;
    }


    public function selectIncasari(IncomingList $incomingList){


        //DB::enableQueryLog(); // Enable query log
        $rezult = DB::select(
            "select t_incasari_facturi.id,
		                concat('( ', t_tip_document.abrev, ' ) ', t_tip_document.tipc) as tip_document,
                        t_tip_incasare.cIncas as tip_incasare,
		                DATE_FORMAT(t_incasari_facturi.data_incas, '%d/%m/%Y') as data_i,
                        t_facturi_numar.cNr as numar_chitanta, t_incasari_facturi.nSuma as suma,
                        t_parteneri.cNume as nume_client,
                        facturi_nr.cNr as numar_factura
                    from 
		                t_incasari_facturi
                        inner join t_facturi_numar on t_facturi_numar.id = t_incasari_facturi.id_nr
                        inner join t_tip_document on t_tip_document.id = t_incasari_facturi.id_tipd
                        inner join t_tip_incasare on t_tip_incasare.id = t_incasari_facturi.id_incas
                        inner join t_factura on t_factura.id = t_incasari_facturi.id_factura
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                        inner join t_facturi_numar as facturi_nr on facturi_nr.id = t_factura.id_nr
                    where t_factura.id_avocat = :idAvocat and (t_incasari_facturi.data_incas between :dataIn and :dataSf)
			                and (t_parteneri.id = :idPartner OR 0 = :filterActive)
		            order by t_incasari_facturi.data_incas desc;"
            , ['idAvocat'=>$this->idAvocat, 'dataIn'=>$incomingList->data_in, 'dataSf'=>$incomingList->data_sf, 'idPartner'=>$incomingList->partner_id, 'filterActive'=>$incomingList->filterActiv]
        );


        //dd(DB::getQueryLog()); // Show results of log

        return $rezult;
    }

    public function selectFacturiNeincasate(){
        $rezult = DB::select(
            " select a.id, t_tip_factura.cTipfactura as tip_factura, a.nr_factura, t_factura.data_f,
 							DATE_FORMAT(t_factura.data_f, '%d/%m/%Y') as data_f_view, 
	                        t_parteneri.cNume as client_name, t_tip_organizare_juridica.cTipAbrev as client_tip_firma, concat(if(t_parteneri.Ro_='--','',t_parteneri.Ro_), t_parteneri.cui) as client_cod_fiscal, 
	                        a.total_factura, a.total_incasat,
                            a.total_factura - a.total_incasat as rest_de_incasat 
                    from
                    (
                        select t_factura.id, t_facturi_numar.cNr as nr_factura,
                             sum(t_factura_d.nTotal) as total_factura,
                             IFNULL((select SUM(nSuma)
                                              from
                                               t_incasari_facturi
                                                 where id_factura = t_factura.id),0)  as total_incasat
                             from t_factura 
                                inner join t_facturi_numar  on t_factura.id_nr = t_facturi_numar.id
                                inner join t_factura_d on t_factura.id = t_factura_d.id_factura
                        where t_factura.salvata =1
                              and t_facturi_numar.id_avocat = :idAvocat
                             group by t_factura.id, t_facturi_numar.cNr    
                             having total_factura - total_incasat <> 0 and total_factura > 0  
                    ) a
                        inner join t_factura on t_factura.id = a.id
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                        inner join t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip
                        inner join t_tip_factura on  t_tip_factura.id = t_factura.id_tipfactura
                    order by t_factura.data_f desc;"
            , ['idAvocat'=>$this->idAvocat]
        );

        return $rezult;
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
