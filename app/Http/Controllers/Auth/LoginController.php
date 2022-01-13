<?php

namespace App\Http\Controllers\Auth;

use App\allClass\helpers\response\MessageResponse;
use App\Http\Controllers\Controller;
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
        $this->middleware('guest')->except('logout');
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

	    if (auth()->attempt($credentials)) {
		    $message = new MessageResponse(true,["log on"]);

	    }else{
		    $message = new MessageResponse(false,["autentificare esuata"]);

	    }

	    // dd(Hash::make('LOIJNSU&^%$A7a67s'));
	    //dd($credentials);
        //dd(auth());
        //dd(Auth::user());
        //dd($request->hasSession());
        //dd($request->user());
        //$areSesiune = $request->hasSession();
        //dd($areSesiune);
        //dd(Auth::user());
        //$idUser = DB::table('t_s_useri')->where('cmail', $email)->value('id_user');
        // Session::put(MyAppConstants::ID_USER, $idUser);
	    // $message = new MessageResponse(true,["log on"]);
	    return json_encode($message);
    }

	public function logout(Request $request){
		Auth::logout();
		return json_encode(new MessageResponse(true,["log off"]));
	}

    function redirectTo(){
        //$user = Auth::user()->getAuthIdentifier();
        //dd($user->getAuthIdentifier());
        //Session::put(MyAppConstants::ID_AVOCAT, $user->getAuthIdentifier());
        $email = Auth::user()->email;
        $idUser = DB::table('t_s_useri')->where('cmail', $email)->value('id_user');
        Session::put(MyAppConstants::ID_USER, $idUser);
    }

    protected function sendLoginResponse(Request $request){
        $message = new MessageResponse(true,["log on"]);
        return json_encode($message);
    }

    protected function sendFailedLoginResponse(Request $request){
        $message = new MessageResponse(false,["autentificare esuata"]);
        return json_encode($message);
    }


}
