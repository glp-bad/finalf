<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 23.11.2018
 * Time: 09:34
 */

namespace App;

class MyAppConstants {

    const MY_SESSION = 'my-session';

    const ID_USER =   'ID_USER';
	const ID_AVOCAT = 'ID_AVOCAT';
	const IS_LOGIN  = 'IS_LOGIN';     // use with VUECLI only
    const USER_LOGON = 1;
    const USER_LOGOFF = 0;

	const CLIENT_SQL_UPDATE = 'update';
	const CLIENT_SQL_INSERT = 'insert';
	const CLIENT_SQL_DELETE = 'delete';
    const CLIENT_SQL_SELECT = 'select';

	// ENV vue client
    const VUE_APP_ENV = 'vueClient';



}
