<?php


namespace App\allClass\helpers\response;


class PaginateResponse
{
    public static function get($recordCount, $records){
        return ['paginate'=>['records'=>$recordCount], 'records'=>$records ];
    }
}
