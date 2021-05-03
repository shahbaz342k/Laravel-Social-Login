<?php 

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use App\User;
class LoginController extends Controller { 
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
    /*** Where to redirect users after login. 
    ** @var string 
    */
    protected $redirectTo = '/home';
    
    /*** Create a new controller instance. 
    * * @return void 
    */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToGoogle() {
        //exit('hello redirectToGoogle');
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback() {
        try {
            
           // exit('hello handleGoogleCallback try');
            $user = Socialite::driver('google')->user();
           // dd($user);
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/home');
            } else {
                $newUser = User::create(['name' => $user->name, 'email' => $user->email, 'google_id' => $user->id, 'status' => '1']);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
        catch(Exception $e) {
             //exit('hello handleGoogleCallback catch');
            print_r($e->getMessage());
            exit;
            return redirect('auth/google');
        }
    }

    public function redirectToFacebook() {
        //exit('hello redirectToFacebook');
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() {
        $home_url = 'http://localhost:8000/home';
        try {
            //exit('hello handleFacebookCallback try');
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();
            if ($finduser) {
               // exit('hello handleFacebookCallback try if');
                Auth::login($finduser);
                return redirect($home_url);
            } else {
                //exit('hello handleFacebookCallback try else');
                $newUser = User::create(['name' => $user->name, 'email' => $user->email, 'facebook_id' => $user->id, 'status' => '1']);
                Auth::login($newUser);
                return redirect($home_url);
            }
        }
        catch(Exception $e) {
            echo 'hello handleFacebookCallback catch';
            print_r($e->getMessage());
            exit;
            return redirect('auth/facebook');
        }
    }

} 

?>