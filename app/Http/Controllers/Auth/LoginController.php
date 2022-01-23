<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\app\ModelUserLogged;
use App\MyAppConstants;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $loginsSession = array();

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except('login');
        // $this->readSessionFile();
    }


    /**
     *not used
     */
    private function readSessionFile(){
            //$file = 'D:\bin\xampp8\htdocs\finalf\storage\framework\sessions\vPLqQjz8JCfARxYl4FlzVjFbhBKUb1s6APy9aUgC';
            $file = 'D:\bin\xampp8\htdocs\finalf\storage\framework\sessions';

            $this->loginsSession = array();

            $files = scandir($file);
            foreach($files as $f){
                if($f[0] != '.'){
                    $fileName = $file . '\\' . $f;
                    $contents = file_get_contents($fileName);
                    $this->loginsSession = unserialize($contents);
                }
            }

    }

    /**
     * same browser and token dont expire
     * @param $credentials
     * @return bool
     */
    private function userAllReadyLogin($credentials){
        $returnValue = false;
        $autUser = Auth::user();

        if($autUser != null &&  Hash::check( $credentials['password'], $autUser->password ) &&  $credentials['email'] == $autUser->email ){
            $returnValue = true;
        }

        return $returnValue;
    }

    public function login(Request $request){

        // $email = Auth::user()->email;
        /*
        if ($request->hasSession()) {
            $request->session()->put('auth.password_confirmed_at', time());
        }
        */
        //dd(auth());

	    $request->validate([
		    'email' => 'required',
		    'password' => 'required'
	    ]);

	    $credentials = $request->except(['_token']);
        $message = null;

        if(!$this->userAllReadyLogin($credentials)){        //check login on database
            $userRequest = (object) [
                'actionType' => MyAppConstants::CLIENT_SQL_INSERT,
                'credentials' => $credentials
            ];

            $userLogged = new ModelUserLogged($userRequest);
        }

        // dd(Auth::user());
        // $password = Hash::make('LOIJNSU&^%$A7a67s');

        dd($userLogged->action());

        if (auth()->attempt($credentials)) {
		    $message = $this->getMessageResponse(true,["log on"]);

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', now()->toDateTimeString());
                $request->session()->put('auth.isLogon', $this->getSession()->authCheck());
            }

            // dd($this->getSession()->get(MyAppConstants::ID_USER));
            // dd($this->getSession());
            // dd(Session::getHandler());

	    }else{
		    $message = $this->getMessageResponse(false,["autentificare esuata"]);
	    }

        // $this->readSessionFile();
        //dd(Auth::check());
	    //dd(Hash::make('LOIJNSU&^%$A7a67s'));
	    //dd($credentials);
        //dd(auth());
        //dd(Auth::user());
        //dd($request->hasSession());
        //dd($request->user());
        //$areSesiune = $request->hasSession();
        //dd($areSesiune);
        //dd(Auth::user());
        //$idUser = DB::table('t_s_useri')->where('cmail', $email)->value('id_user');

	    $this->getSession()->put(MyAppConstants::ID_USER, 99);

        // dd(Session::getId());
        // dd($mySession);
        // $message = new MessageResponse(true,["log on"]);

	    return $message->toJson();
    }


	public function logout(Request $request){
        // dd(Auth::check(), Auth::user(), dd($this->guard()));
        // dd(Session::get(MyAppConstants::ID_USER, -1));

        // $mySession = $this->getSession();
        // dd($this->getSession()->get(MyAppConstants::ID_USER));

        // dd(Session::all());

        // $this->getSession()->flush();        // delete token
        $this->getSession()->logout();

        // dd($this->loginsSession);

		$messageResponse = $this->getMessageResponse(true,["log off"]);
		return $messageResponse->toJson();
	}

    function redirectTo(){
        //$user = Auth::user()->getAuthIdentifier();
        //dd($user->getAuthIdentifier());
        //Session::put(MyAppConstants::ID_AVOCAT, $user->getAuthIdentifier());
        //$email = Auth::user()->email;
        //$idUser = DB::table('t_s_useri')->where('cmail', $email)->value('id_user');
        //Session::put(MyAppConstants::ID_USER, $idUser);
    }

    /*
    protected function sendLoginResponse(Request $request){
        $message = new MessageResponse(true,["log on"]);
        return json_encode($message);
    }

    protected function sendFailedLoginResponse(Request $request){
        $message = new MessageResponse(false,["autentificare esuata"]);
        return json_encode($message);
    }
    */

}
