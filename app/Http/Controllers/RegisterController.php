<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        return view('register',['kelas'=>$kelas]);
    }

    public function store(Request $request)
    {

        $validateData=$request->validate([
            'id_member' => ['required','min:3','max:12','unique:mst_member'],
            'nama' => ['required', 'min:3', 'max:50'],
            'id_kelas'=>'required',
            'password'=> 'required|min:3',
            'konfirmasi-password' => 'required|min:3'
        ]);
        if($validateData['password'] ===  $validateData['konfirmasi-password']){
            //$validateData['password'] = bcrypt($validateData['password']);
            $user['id_user'] = $validateData['id_member'];
            $user['password'] = Hash::make($validateData['password']);
            $user['id_type_user'] = "mbr";
            DB::table('mst_login')->insert($user);
            //$valid['konfirmasi-password'] = Hash::make($validateData['konfirmasi-password']);
            $member['id_member'] = $validateData['id_member'];
            $member['nama_member'] = $validateData['nama'];
            $member['id_kelas'] = $validateData['id_kelas'];
            Member::create($member);
            return redirect('/login')->with('success', 'Registrasi berhasil, Silahkan Login');
        }else{
            return back()->with('error', 'Password yang anda masukan tidak sama');
        }


        //$request->session()->flash('success','Registrasi berhasil, Silahkan Login');

       // dd($validateData);


    }
}
