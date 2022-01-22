<?php


namespace App\allClass\scheduledTasks;


use Illuminate\Support\Facades\DB;

class CheckUserLogin
{
    public function __invoke()
    {
        DB::insert('insert into users_login (id_user) value (?)', [4447]);
    }
}
