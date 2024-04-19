<?php

namespace App\Models\bussines;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;


class BussinesAnafSpv extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = null;
    }


    public function insertMesajeAnaf()
    {
        //DB::enableQueryLog(); // Enable query log
        $rezult = DB::insert(
            "insert into anaf_lista_mesaje(id_avocat, anaf_id, anaf_cif, anaf_id_solicitare, anaf_detalii, anaf_tip, anaf_data_creare, anaf_serial, anaf_data_creare_data, emitent_cif, emitent)
                SELECT anaf_lista_mesaje_buffer.id_avocat,
                    anaf_lista_mesaje_buffer.anaf_id,
                    anaf_lista_mesaje_buffer.anaf_cif,
                    anaf_lista_mesaje_buffer.anaf_id_solicitare,
                    anaf_lista_mesaje_buffer.anaf_detalii,
                    anaf_lista_mesaje_buffer.anaf_tip,
                    anaf_lista_mesaje_buffer.anaf_data_creare,
                    anaf_lista_mesaje_buffer.anaf_serial,
                    anaf_lista_mesaje_buffer.anaf_data_creare_data,
                    anaf_lista_mesaje_buffer.emitent_cif,
                    t_parteneri.cNume
                FROM anaf_lista_mesaje_buffer
                    left join t_parteneri on t_parteneri.cui = anaf_lista_mesaje_buffer.emitent_cif and t_parteneri.id_avocat = :idAvocat
                    left join anaf_lista_mesaje as m on m.anaf_id = anaf_lista_mesaje_buffer.anaf_id
                where m.id is null;"
                , ['idAvocat'=> $this->idAvocat]
        );
        return $rezult;
    }


    public function truncateMesajeAnafBuffer()
    {
        //DB::enableQueryLog(); // Enable query log
        $rezult = DB::statement(
            "truncate table anaf_lista_mesaje_buffer;"
                , []
        );

        return $rezult;
    }


}
