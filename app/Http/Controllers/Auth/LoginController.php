<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        $session = Session::all();

        if (Auth()->user()->roles_user == "C01") {
            if (!array_key_exists('details_url_previous', $session)) {
                return route('utilisateur.dashbord');
            } else {
                return $session['details_url_previous'];
            }
        } elseif (Auth()->user()->roles_user == "G02") return route('gestionnaire.dashbord');
        elseif (Auth()->user()->roles_user == "A03") return route('admin.dashbord');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    //Methode pour se connecter
    public function login(Request $request)
    {
        $messages = [
            "email.required" => "Votre adresse mail est requis",
            "email.exists" => "Vous n'avez pas de compte veuillez creer un compte.",
            "password.required" => "Votre mot de passe est requis",
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|exists:users,email_user',
            'password' => 'bail|required'
        ], $messages);


        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "AUTHENTIFIEZ-VOUS",
            "message" => $validator->errors()->first()
        ]);

        $tempUser = User::where('email_user', $request->email)->get()->first();

        if ($tempUser && Hash::check($request->password, $tempUser->password)) {
            if ($tempUser->status_user) {
                Auth::login($tempUser);
                $redirect = null;

                $session = Session::all();

                if ($tempUser->roles_user == "C01") {
                    if (!array_key_exists('details_url_previous', $session)) {
                        $redirect = route('utilisateur.dashbord');
                    } else {
                        $redirect = $session['details_url_previous'];
                    }
                } elseif ($tempUser->roles_user == "G02") {
                    $redirect = route('gestionnaire.dashbord');
                } elseif ($tempUser->roles_user == "A03") {
                    $redirect = route('admin.dashbord');
                }

                return response()->json([
                    "status" => true,
                    "reload" => false,
                    "redirect_to" => $redirect,
                    "title" => "AUTHENTIFIEZ-VOUS",
                    "message" => "Bienvenue " . $tempUser->prenom_user . " " . $tempUser->nom_user . ", Connexion effectuee avec succes"
                ]);
            } else {
                Auth::logout();
                return response()->json([
                    "status" => false,
                    "reload" => true,
                    "redirect_to" => null,
                    "title" => "AUTHENTIFIEZ-VOUS",
                    "message" => "Votre compte a ete desactive. Contactez le service client."
                ]);
            }
        } 
        
        
        else {
            return response()->json([
                "status" => false,
                "reload" => true,
                "redirect_to" => null,
                "title" => "AUTHENTIFIEZ-VOUS",
                "message" => "Informations de connexion sont incorrectes."
            ]);
        }
    }

    //Methode pour se deconnecter
    // public function logout(Request $request)
    // {
    //     //if (Auth::check()) {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/');
    //     //}
    // }
}
