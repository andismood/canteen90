<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'id_user'=>['required','max:20'],
            'password' => ['required']
        ]);
        $user = User::whereRaw('id_user = ?', [$credentian['id_user']])->first();$user = User::where('id_user', $credentian['id_user'])->first();

        if ($user && Hash::check($credentian['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Nama Pengguna atau kata sandi salah');
    }

    public function logout(Request $request){
        Auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
