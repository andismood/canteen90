<?php

namespace App\Http\Controllers;

use App\Models\JenisMenu;
use Illuminate\Http\Request;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\Auth;

class JenisMenuController extends Controller
{
    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }

    public function index(){
        if (Auth::check()) {
        $jenisMenu = JenisMenu::get();
        $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
        return view("admin.jenis-menu.index",['data'=> $jenisMenu, 'nama' => $nama, 'tipe' => $tipe]);
        }
        return view('login.index');
    }

    public function tambah()
    {
        if (Auth::check()) {
        return view("admin.jenis-menu.form");
        }
        return view('login.index');
    }

    public function simpan(Request $request)
    {
        if (Auth::check()) {
        $request->validate([
            'nama_jenis_menu' => ['required','max:30']
        ]);
        $data = [
            'nama_jenis_menu' => $request->nama_jenis_menu
        ];
        JenisMenu::create($data);
        return redirect ()->route('jenis-menu');
        }
        return view('login.index');
    }

    public function edit($id)
    {
        if (Auth::check()) {
        $jenisMenu = JenisMenu::find($id);
       // dd($id);
        return view('admin.jenis-menu.form', ['jenisMenu' => $jenisMenu]);
        }
        return view('login.index');
    }

    public function update($id, Request $request)
    {
        if (Auth::check()) {
        $request->validate([
            'nama_jenis_menu' => ['required', 'max:30']
        ]);
        $data = [
            'id_jenis_menu' => $request->id_jenis_menu,
            'nama_jenis_menu' => $request->nama_jenis_menu,
        ];

        JenisMenu::find($id)->update($data);
        return redirect()->route('jenis-menu');
        }
        return view('login.index');
    }


    public function hapus($id_jenis_menu)
    {
        if (Auth::check()) {
        JenisMenu::find($id_jenis_menu)->delete();
        return redirect()->route('jenis-menu');
        }
        return view('login.index');
    }
}
