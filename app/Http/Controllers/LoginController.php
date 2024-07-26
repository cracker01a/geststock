<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function recover_user($email){
        $user = User::where('email' , $email)->first();
        $new_password = False;
        if ($user) {
            if ($user->password == NULL) {
                $new_password = True;
            }
        }
        return Response::json(['response'=>$new_password]);
    }

    public function login(Request $request){

        // Validation
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string|min:8',
        ]);

        $user = User::where('email',$request->email);

        if ($request->confirm_password) {
            $validated = $request->validate([
                'confirm_password' => 'required_with:password|same:password|min:8'
            ]);

            if ($user->first()) {
                $user->update(['password' => bcrypt($request->password)]);
            }
        }

        if ($user->first()) {
            if (!$user->first()->isActive) {
                Session::flash('User unactive');
                return Redirect::back();
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('tableau-de-bord');
        }

        return Redirect::back();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::route('login.index');
    }
}
