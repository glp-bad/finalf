<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 23.11.2018
 * Time: 09:34
 */

namespace App;

class MyAppConstants {

    const VERSION_APP = '1.6.300';

    const MY_SESSION = 'my-session';

    const ID_USER    = 'ID_USER';
	const ID_AVOCAT  = 'ID_AVOCAT';
	const IS_LOGIN   = 'IS_LOGIN';     // use with VUECLI only
    const USER_EMAIL_LOGGED  = 'USER_EMAIL_LOGGED';
    const USER_LOGON = 1;
    const USER_LOGOFF = 0;
    const USER_ID_LOGEED = 'USER_ID_LOGEED';    // session store id from users_login

	const CLIENT_SQL_UPDATE = 'update';
	const CLIENT_SQL_INSERT = 'insert';
	const CLIENT_SQL_DELETE = 'delete';
    const CLIENT_SQL_SELECT = 'select';

	// ENV vue client
    const VUE_APP_ENV = 'vueClient';


    // bussines
    const BUSS_TIP_PARTENER_PERSOANA_FIZICA = 'pf';
    const BUSS_STRING_CUI_WITHOUT_RO = '--';
    const BUSS_STRING_CUI_RO = 'RO';
    const BUSS_NR_FACTURA_DANA  = ['nTip' => 1, 'nrString' => 'FAGD', 'lenghtFillNumber' => 8];
    const BUSS_NR_CHITANTA_DANA = ['nTip' => 2, 'nrString' => 'CAGD', 'lenghtFillNumber' => 8];

    // database
	const DATABASE_ANONIMUS = 'mysql_anonimus';
	const DATABASE_USER_ANONIMUS = 'test@test.com';

}
