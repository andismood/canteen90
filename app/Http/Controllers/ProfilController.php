<?php

namespace App\Http\Controllers;

use view;
use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $memberId = Auth::id();
            $member = Member::find($memberId);
            $kelas = Kelas::get();
            return view("admin.profil.index", ['member' => $member, 'kelas' => $kelas]);
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
