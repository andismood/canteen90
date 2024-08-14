<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(){
        if (Auth::check()) {
        $kelas = Kelas::paginate(10);
        return view('admin.kelas.index', ['data' => $kelas]);
        }
        return view('login.index');
    }
    public function tambah()
    {
        if (Auth::check()) {
        return view("admin.kelas.form");
        }
        return view('login.index');
    }
    public function simpan(Request $request){
        if (Auth::check()) {
        $request->validate([
            'kode_kelas' => ['required', 'max:10', 'unique:mst_kelas'],
            'nama_kelas' => ['required', 'max:25'],
            'keterangan' => ['max:200']
        ]);
        $data = [
            'id_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'keterangan' => $request->keterangan
        ];
        Kelas::create($data);
        return redirect()->route('kelas');
        }
        return view('login.index');
    }
    public function edit($id)
    {
        if (Auth::check()) {
        $kelas = Kelas::find($id);
        return view('admin.kelas.form', ['kelas' => $kelas]);
        }
        return view('login.index');
    }
    public function update($id, Request $request)
    {
        if (Auth::check()) {
        $request->validate([
            'kode_kelas' => ['required', 'max:10', 'unique:mst_kelas'],
            'nama_kelas' => ['required', 'max:25'],
            'keterangan' => ['max:200']
        ]);
        $data = [
            'id_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'keterangan' => $request->keterangan
        ];

        Kelas::find($id)->update($data);

        return redirect()->route('kelas');
        }
        return view('login.index');
    }


    public function hapus($id_kelas)
    {
        if (Auth::check()) {
        Kelas::find($id_kelas)->delete();
        return redirect()->route('kelas');
         }
        return view('login.index');
    }
}
