<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\app\ModelUserLogged;
use App\Models\app\User;
use App\MyAppConstants;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Session;
use \Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;


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
     * @param Request $request befor login
     */
    public function loginCheck() {

        if($this->getSession()->authCheck()){
            $message = $this->getMessageResponse(true,["you are already logged in"]);
        }else{
            $message = $this->getMessageResponse(false, ["you are not logged in"]);
        }

        return $message->toJson();
    }

    public function login(Request $request) {

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

        $userLogged = new ModelUserLogged($credentials['email'], null, null);

        // dd(Auth::user());
        // $password = Hash::make('LOIJNSU&^%$A7a67s');
        $userLogged->expireLogIn();

       if($userLogged->isAllreadyLogin()){
            // $user->tokens()->where('id', $tokenId)->delete();
            // $this->readSessionFile();

            // dd($this->loginsSession);
            $message = $this->getMessageResponse(false, ["You are already logged in to another browser. Please logout."]);

        }else {
            if (auth()->attempt($credentials)) {

                ModelUserLogged::logInOut($userLogged->getIdUserLogged(), MyAppConstants::USER_LOGON);

                $message = $this->getMessageResponse(true, ["log on"]);

                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', now()->toDateTimeString());
                    $request->session()->put(MyAppConstants::USER_EMAIL_LOGGED, $credentials['email']);
                    $request->session()->put(MyAppConstants::USER_ID_LOGEED, $userLogged->getIdUserLogged());

                    // hardcore
                    $request->session()->put(MyAppConstants::ID_AVOCAT, 6);
                }
                // dd($this->getSession()->get(MyAppConstants::ID_USER));
                // dd($this->getSession());
                // dd(Session::getHandler());

                $this->getSession()->put(MyAppConstants::ID_USER, 99);

            } else {
                $message = $this->getMessageResponse(false, ["Incorrect credentials. Try again."]);
            }
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
        ModelUserLogged::logInOut($this->getSession()->get(MyAppConstants::USER_ID_LOGEED), MyAppConstants::USER_LOGOFF);

        // $this->getSession()->flush();
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
