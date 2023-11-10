<?php

namespace App\Models\bussines;
use App\allClass\helpers\GridPaginateOrderFilter;
use App\allClass\helpers\MyModel;
use App\allClass\helpers\param\ListFilter;
use App\allClass\helpers\response\PaginateResponse;
use Illuminate\Support\Facades\DB;
use App\allClass\helpers\param\IncomingList;

class BussinesInvoice extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = null;
    }


    public function selectExepnese(ListFilter $f)
    {
        //DB::enableQueryLog(); // Enable query log
        $rezult = DB::select(
            "select  t_cheltuieli.id,
                            DATE_FORMAT(t_cheltuieli.datac, '%d/%m/%Y') as data_c,
                            t_cheltuieli.cNrDoc as nr_doc,
                            t_tip_plata.tipplata as tip_plata,	
                            concat(t_tip_document.tipc, ' (' ,t_tip_document.abrev, ')') as tipd,
                            t_tip_cheltuieli.tipc,
                            t_parteneri.cNume as nume_furnizor,
                            (select sum(nTotalTva)  from t_cheltuieli_d where id_chlet = t_cheltuieli.id) as total_tva,
                            (select sum(nTotalFaraTva + nTotalTva)  from t_cheltuieli_d where id_chlet = t_cheltuieli.id) as total
                     from 
                      t_cheltuieli 
                        inner join t_parteneri on t_parteneri.id = t_cheltuieli.id_part
                        inner join t_tip_cheltuieli on t_tip_cheltuieli.id = t_cheltuieli.id_tipc
                        inner join t_tip_document on t_tip_document.id = t_cheltuieli.id_tipd
                        inner join t_tip_plata on t_tip_plata.id = t_cheltuieli.id_tipplata
                      where t_cheltuieli.id_avocat = :idAvocat 
                            and t_cheltuieli.salvata = :salvata
                            and t_cheltuieli.datac between :dataIn	and :dataSf
                            and (t_cheltuieli.id_part = :idPartner or 0 = :filterActive)
                      order by t_cheltuieli.datac desc;"
            , ['idAvocat' => $this->idAvocat, 'salvata' => 1, 'dataIn' => $f->data_in, 'dataSf' => $f->data_sf, 'idPartner' => $f->partner_id, 'filterActive' => $f->filterActiv]
        );

        return $rezult;
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


    public function selectFacturiEmise(IncomingList $incomingList){
        $rezult = DB::select(
            "select a.id, t_tip_factura.cTipfactura as tip_factura, a.nr_factura, t_factura.data_f,
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
                              and t_factura.data_f between :dataIn and :dataSf
                              and (t_factura.id_part = :idPartner OR 0 = :filterActive)
                             group by t_factura.id, t_facturi_numar.cNr    
                             
                    ) a
                        inner join t_factura on t_factura.id = a.id
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                        inner join t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip
                        inner join t_tip_factura on  t_tip_factura.id = t_factura.id_tipfactura
                    order by a.nr_factura ASC, t_factura.data_f desc;"
            , ['idAvocat'=>$this->idAvocat, 'dataIn'=>$incomingList->data_in, 'dataSf'=>$incomingList->data_sf, 'idPartner'=>$incomingList->partner_id, 'filterActive'=>$incomingList->filterActiv]
        );

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
                        (select distinct t_factura.id,  t_facturi_numar.cNr as nr_f
                            from t_factura
                                inner join t_factura_d on t_factura_d.id_factura = t_factura.id
                                inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                            where t_factura.id_avocat = $this->idAvocat and t_factura.id_part = {$additionalFilter['id_part']} and t_factura.salvata = 1
                        ) as sume_facturi
                    inner join  t_factura on t_factura.id = sume_facturi.id
                    inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr 
                    $whereFilterBy"
        );

        $rezult = DB::select(
            " select t_factura.id, 
                        t_factura.data_f, 
                        sume_facturi.nr_f,  
                        t_factura.id_part,
                        t_factura.nProcTVA,
                        sume_facturi.nSumaFaraTva, sume_facturi.nSumaTVA, sume_facturi.nTotal
                    from
                        (
                             select t_factura.id, t_facturi_numar.cNr as nr_f, sum(nSumaFaraTva) as nSumaFaraTVA, sum(nSumaTVA) as nSumaTVA, sum(nTotal) as nTotal
                                from t_factura
                                    inner join t_factura_d on t_factura_d.id_factura = t_factura.id
                                    inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                                where t_factura.id_avocat = $this->idAvocat and t_factura.id_part = {$additionalFilter['id_part']} and t_factura.salvata = 1
                                group by t_factura.id, t_facturi_numar.cNr
                        ) as sume_facturi
                    inner join  t_factura on t_factura.id = sume_facturi.id
                    $whereFilterBy
                    order by $orderBy  LIMIT $perPage OFFSET $pageNumber;"
        );

        return PaginateResponse::get($count[0]->c, $rezult);
    }



    public function selectInvoicePrintDetail($id){
        $rezult = DB::select(
            "select 00 as nro,
		                id, id_factura, cText as cExplicf, 
		                nSumaFaraTva as nSuma, nSumaTva as nTVA, nTotal as ValoareFactura
	                from
		                t_factura_d	 
	                where id_factura = :id
	                order by id_factura asc"
            , ['id'=>$id]
        );

        return $rezult;
    }


    public function selectInvoicePrintAntet($id){
        $rezult = DB::select(
            " select t_factura.id as id_factura, t_factura.id_nr, t_factura.data_f, DATE_FORMAT(t_factura.data_f, '%d/%m/%Y') as dataf, t_factura.id_part, t_factura.nProcTva, t_factura.salvata, t_factura.id_tipFactura,
                            t_facturi_numar.cNr, t_facturi_numar.folosit,
                            t_parteneri.cNume as cClient, t_parteneri.regcom, t_parteneri.ro_, if(t_parteneri.id_tip = 7, '--', t_parteneri.cui) as cui,
                            t_tip_organizare_juridica.cTipAbrev as cOrgJ,
                            t_tip_factura.cTipfactura,
                            ifnull(t_avocati_adresa.cAdresa,'-') 	as cAdresa_av,
                            ifnull(av_localitati.cLocalitate,'-') 	as cOras_av,
                            ifnull(t_avocati_banca.cBanca,'-') 		as cBanca_av,
                            ifnull(t_avocati_banca.cSucursala,'-') 	as cSucursala_av,
                            ifnull(t_avocati_banca.cIBAN,'-') 		as cIBAN_av,
                            ifnull(t_parteneri_adrese.cAdresa,'-') as cAdresa_pa,
                            ifnull(pa_localitati.cLocalitate,'-') as cOras_pa,
                            ifnull(t_parteneri_banca.cBanca,'-') as cBanca_pa,
                            ifnull(t_parteneri_banca.cSucursala,'-') as cSucursala_pa,
                            ifnull(t_parteneri_banca.cIBAN,'-')	as cIBAN_pa,
                            t_avocati.cNumeCabinet,
                            t_avocati.ro_	as ro_av,
                            t_avocati.cui	as cui_av,
                            t_avocati.cDecizia,
                            av_judete.cJudet as judet_av,
                            av_judete.cJudetAbrev as judet_abrev_av,
                            pa_judete.cJudet as judet_pa,
                            pa_judete.cJudetAbrev as judet_abrev_pa,
                            t_avocati.contact_name as contact_name_av,
                            t_avocati.contact_phone as contact_phone_av,
                            t_avocati.contact_email as contact_email_av
                            from	
                                t_factura
                                inner join t_tip_factura on t_tip_factura.id = t_factura.id_tipfactura
                                inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                                inner join t_parteneri on t_parteneri.id = t_factura.id_part
                                inner join t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip
                                inner join t_avocati on t_avocati.id = t_factura.id_avocat
                                left join t_avocati_adresa on t_avocati_adresa.id_avocat = t_factura.id_avocat and t_avocati_adresa.activ = 1
                                left join t_localitati as av_localitati on av_localitati.id = t_avocati_adresa.id_localitate
                                left join t_judete as av_judete on av_judete.id = av_localitati.id_judet
                                left join t_avocati_banca on t_avocati_banca.id_avocat = t_factura.id_avocat and t_avocati_banca.activ = 1
                                left join t_parteneri_adrese on t_parteneri_adrese.id_part = t_parteneri.id and t_parteneri_adrese.activ = 1
                                left join t_localitati as pa_localitati on pa_localitati.id = t_parteneri_adrese.id_localitate
                                left join t_judete as pa_judete on pa_judete.id = pa_localitati.id_judet
                                left join t_parteneri_banca on t_parteneri_banca.id_part = t_parteneri.id and t_parteneri_banca.activ = 1
                    where t_factura.id = :id;"
            , ['id'=>$id]
        );

        return $rezult;
    }


    public function selectReceiptIncomePrint($id){
        $rezult = DB::select(
            "select t_incasari_facturi.id, 
                           t_facturi_numar.cNr as invoice_nr,
                           DATE_FORMAT(t_factura.data_f, '%d/%m/%Y') as invoice_date,
                           concat(t_tip_document.tipc ,' (' , t_tip_document.abrev, ')') as receipt_doc,
                           receipt.cNr as receipt_nr,
                           t_incasari_facturi.data_incas,
                           DATE_FORMAT(t_incasari_facturi.data_incas, '%d/%m/%Y') as receipt_date,
                           t_incasari_facturi.nSuma as receipt_suma,
                           t_avocati.cNumeCabinet as av_cabinet,
                           t_avocati.cdecizia as av_decizia,
                           t_avocati.cui as av_cui,
                           t_avocati.Ro_ as av_cui_ro,
                           t_avocati_adresa.cAdresa as av_adresa,
                           av_localitati.cLocalitate as av_localitate,
                           t_avocati_banca.cIBAN as av_iban,
                           t_avocati_banca.cBanca as av_banca,
                           t_avocati_banca.cSucursala as av_sucursala,
                           t_parteneri.cNume as pa_nume,
                           t_parteneri.cui as pa_cui,
                           t_parteneri.Ro_ as pa_cui_ro,
                           t_parteneri.regcom as pa_regcom,
                           t_parteneri_adrese.cAdresa as pa_adresa,
                           pa_localitati.cLocalitate as pa_localitate,
                           t_parteneri_banca.cIBAN as pa_iban,
                           t_parteneri_banca.cBanca as pa_banca,
                           t_parteneri_banca.cSucursala as pa_sucursala
                           
                     from 
                        t_incasari_facturi
                        inner join t_factura on t_factura.id = t_incasari_facturi.id_factura and t_factura.id_avocat = :idAvocat
                        inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                        inner join t_tip_document on t_tip_document.id = t_incasari_facturi.id_tipd
                        inner join t_facturi_numar as receipt on receipt.id = t_incasari_facturi.id_nr
                        inner join t_avocati on t_avocati.id = t_factura.id_avocat
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                        left join t_avocati_adresa on t_avocati_adresa.id_avocat = t_avocati.id and t_avocati_adresa.activ = 1
                        left join t_localitati as av_localitati on av_localitati.id = t_avocati_adresa.id_localitate
                        left join t_avocati_banca on t_avocati_banca.id_avocat = t_avocati.id and t_avocati_banca.activ = 1
                        left join t_parteneri_adrese on t_parteneri_adrese.id_part = t_parteneri.id and t_parteneri_adrese.activ = 1
                        left join t_localitati as pa_localitati on pa_localitati.id = t_parteneri_adrese.id_localitate
                        left join t_parteneri_banca on t_parteneri_banca.id_part = t_parteneri.id and t_parteneri_banca.activ = 1
                     where t_incasari_facturi.id = :id;"
            , ['id'=>$id, "idAvocat" => $this->idAvocat ]
        );

        return $rezult;
    }


    public function reportFacturiEmise(IncomingList $incomingList){
        $rezult = DB::select(
            "select  t_facturi_numar.cNr as f_nr,
                            t_tip_factura.cTipfactura as f_tip,
                            DATE_FORMAT(t_factura.data_f, '%d/%m/%Y') as f_data,
                            t_tip_organizare_juridica.cTipAbrev as f_client_tip, 
                            t_parteneri.cNume as f_client, 
                            concat(if(t_parteneri.Ro_='--','',t_parteneri.Ro_), t_parteneri.cui) as f_client_cf,
                            t_factura.nProcTVA as f_procent_tva,
                            (select sum(t_factura_d.nSumaFaraTva) from t_factura_d where t_factura_d.id_factura = t_factura.id) as f_suma_fara_tva,
                            (select sum(t_factura_d.nSumaTVA) from t_factura_d where t_factura_d.id_factura = t_factura.id) as f_suma_tva,
                            (select sum(t_factura_d.nTotal) from t_factura_d where t_factura_d.id_factura = t_factura.id) as f_suma
                     from t_factura
                        inner join t_facturi_numar on t_facturi_numar.id = t_factura.id_nr
                        inner join t_tip_factura on t_tip_factura.id = t_factura.id_tipfactura
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                        inner join t_tip_organizare_juridica on t_tip_organizare_juridica.id = t_parteneri.id_tip
                      where t_factura.id_avocat = :idAvocat and t_factura.data_f between :dataIn and :dataSf and t_factura.salvata = 1
                            and (t_factura.id_part = :idPartner OR 0 = :filterActive)
                        order by t_factura.data_f asc;"
            , ['idAvocat'=>$this->idAvocat, 'dataIn'=>$incomingList->data_in, 'dataSf'=>$incomingList->data_sf, 'idPartner'=>$incomingList->partner_id, 'filterActive'=>$incomingList->filterActiv]
        );

        return $rezult;
    }


    public function reportIncasari(ListFilter $f){
        $rezult = DB::select(
            "select t_tip_document.tipc as receipt_tipdoc, t_tip_incasare.cIncas as receipt_tipin, 
                           DATE_FORMAT(t_incasari_facturi.data_incas, '%d/%m/%Y') as receipt_date,
                           in_nr.cNr as receipt_nrdoc, 
                           t_incasari_facturi.nSuma as receipt_suma,
                           f_nr.cNr as invoice_nrdoc, t_parteneri.cNume as invoice_client,
                           concat(if(t_parteneri.Ro_='--','',t_parteneri.Ro_), t_parteneri.cui) as invoice_cf,
                           t_factura.nProcTVA as invoice_percent_tva,
                           (select sum(t_factura_d.nSumaFaraTva) from t_factura_d where t_factura_d.id_factura = t_factura.id) as invoice_suma_fara_tva,
                           (select sum(t_factura_d.nSumaTVA) from t_factura_d where t_factura_d.id_factura = t_factura.id) as invoice_suma_tva,
                           (select sum(t_factura_d.nTotal) from t_factura_d where t_factura_d.id_factura = t_factura.id) as invoice_suma
                     from 
                        t_incasari_facturi
                        inner join t_factura on t_factura.id = t_incasari_facturi.id_factura and t_factura.id_avocat = :idAvocat
                        inner join t_facturi_numar as in_nr on in_nr.id = t_incasari_facturi.id_nr
                        inner join t_tip_document on t_tip_document.id = t_incasari_facturi.id_tipd
                        inner join t_tip_incasare on t_tip_incasare.id = t_incasari_facturi.id_incas
                        inner join t_facturi_numar as f_nr on f_nr.id = t_factura.id_nr
                        inner join t_parteneri on t_parteneri.id = t_factura.id_part
                    where t_incasari_facturi.data_incas between :dataIn and :dataSf
                          and (t_factura.id_part = :idPartner OR 0 = :filterActive)  
                    order by t_incasari_facturi.data_incas asc"
            , ['idAvocat'=>$this->idAvocat, 'dataIn'=>$f->data_in, 'dataSf'=>$f->data_sf, 'idPartner'=>$f->partner_id, 'filterActive'=>$f->filterActiv]
        );

        return $rezult;
    }


}
