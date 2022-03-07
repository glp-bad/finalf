<?php

namespace App\Models\app;
use App\allClass\helpers\MyHelp;
use App\allClass\helpers\MyModel;
use Illuminate\Support\Facades\DB;

class ModelCheltuieli extends MyModel {
    public function __construct($idAvocat, $idUser)
    {
        parent::__construct($idAvocat, $idUser);
        $this->tableName = 't_cheltuieli';
    }

    public function selectEntity($id){
        $rezult = DB::select(
            " 
             SELECT id, id_avocat, datac, an_datac,
			    id_part, id_tipc, id_tipd, id_tipplata,
			    cNrDoc, salvata, 
			    id_user, created, last_update
			FROM t_cheltuieli where id=:id;",
            ['id'=>$id]
        );

        return $rezult;
    }

}

