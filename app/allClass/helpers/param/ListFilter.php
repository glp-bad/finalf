<?php


namespace App\allClass\helpers\param;

class ListFilter
{
    public $data_in             = null;
    public $data_sf             = null;
    public $partner_id          = 0;
    public $filterActiv        = 0;

    public function __construct($dataIn, $dataSf, $idPartner)
    {
        $this->data_in = $dataIn;
        $this->data_sf = $dataSf;
        $this->partner_id = $idPartner;

        if($this->partner_id > 0){
           $this->filterActiv = 1;
        }
    }

}
