<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $credentian = $request->validate([
            'id_user'=>['required'],
            'password' => ['required']
        ]);


        if(Auth::attempt($credentian)){
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->with('error','user atau password salah');
    }

    public function logout(Request $request){
        Auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
