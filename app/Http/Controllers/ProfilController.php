<?php

namespace App\Http\Controllers;

use view;
use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }

    public function index()
    {
        if(Auth::check()){
            $Id = Auth::id();
            $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
            if($tipe->id_type_user === 'adm'){
                return view("admin.profil.adm", ['user' => $Id, 'nama' => $nama, 'tipe' => $tipe]);
            }else if($tipe->id_type_user === 'mbr'){
                $member = Member::find($Id);
                $kelas = Kelas::get();
                return view("admin.profil.index", ['member' => $member, 'kelas' => $kelas, 'nama' => $nama, 'tipe' => $tipe]);
            }else{
                return view('login.index');
            }
        }
        return view('login.index');
    }
    public function update(Request $request){
        if (Auth::check()) {
            $request->validate([
                'nama_member' => ['required', 'min:3', 'max:50'],
                'id_kelas' => 'required',
            ]);
            $memberId = Auth::id();
            $data = [
                'nama_member' => $request->nama_member,
                'id_kelas' => $request->id_kelas,
            ];

            $isUpdate = Member::find($memberId)->update($data);;
            if ($isUpdate) {
                return redirect()->route('profil')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('profil')->with('error', 'Data gagal diubah');
            }
        }
        return view('login.index');
    }
}
