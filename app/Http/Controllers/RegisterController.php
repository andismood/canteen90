<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }

    public function store(Request $request)
    {
        $validateData=$request->validate([
            'id_member' => ['required','min:3','max:12','unique:mst_member'],
            'nama' => 'required|min:2',
            'password'=> 'required|min:3',
            'konfirmasi-password' => 'required|min:3'
        ]);

        //$validateData['password'] = bcrypt($validateData['password']);
        $user['id_user'] = $validateData['id_member'];
        $user['password'] = Hash::make($validateData['password']);
        $user['id_type_user'] ="mbr";
        DB::table('mst_login')->insert($user);
        //$valid['konfirmasi-password'] = Hash::make($validateData['konfirmasi-password']);
        $member['id_member'] = $validateData['id_member'];
        $member['nama_member'] = $validateData['nama'];
        Register::create($member);

        //$request->session()->flash('success','Registrasi berhasil, Silahkan Login');

       // dd($validateData);
        return redirect('/login')->with('success', 'Registrasi berhasil, Silahkan Login');

    }
}
