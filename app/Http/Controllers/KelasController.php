<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }

    public function index(){
        if (Auth::check()) {
            $kelas = Kelas::paginate(10);
            $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
            return view('admin.kelas.index', ['data' => $kelas, 'nama' => $nama, 'tipe' => $tipe]);
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
            'id_kelas' => ['required', 'max:10', 'unique:mst_kelas'],
            'nama_kelas' => ['required', 'max:25'],
            'keterangan' => ['max:200']
        ]);
        $data = [
            'id_kelas' => $request->id_kelas,
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
            'nama_kelas' => ['required', 'max:25'],
            'keterangan' => ['max:200']
        ]);
        $data = [
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
