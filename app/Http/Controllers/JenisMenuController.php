<?php

namespace App\Http\Controllers;

use App\Models\JenisMenu;
use Illuminate\Http\Request;

class JenisMenuController extends Controller
{
    public function index(){
        $jenisMenu = JenisMenu::get();
        return view("admin.jenis-menu.index",['data'=>$jenisMenu]);
    }

    public function tambah()
    {
        return view("admin.jenis-menu.form");
    }

    public function simpan(Request $request)
    {
        $data = [
            'nama_jenis_menu' => $request->nama_jenis_menu
        ];
        JenisMenu::create($data);
        return redirect ()->route('jenis-menu');
    }

    public function edit($id)
    {
        $jenisMenu = JenisMenu::find($id);
       // dd($id);
        return view('admin.jenis-menu.form', ['jenisMenu' => $jenisMenu]);
    }

    public function update($id, Request $request)
    {
        $data = [
            'id_jenis_menu' => $request->id_jenis_menu,
            'nama_jenis_menu' => $request->nama_jenis_menu,
        ];

        JenisMenu::find($id)->update($data);

        return redirect()->route('jenis-menu');
    }


    public function hapus($id_jenis_menu)
    {
        JenisMenu::find($id_jenis_menu)->delete();

        return redirect()->route('jenis-menu');
    }
}
