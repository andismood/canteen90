<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\JenisMenu;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::getAllMenu();
        return view("admin.menu.index", ['data' => $menu]);
    }



    public function tambah()
    {
        $tenant = Tenant::get();
        $jenisMenu = JenisMenu::get();
        return view("admin.menu.form",['jenisMenu'=>$jenisMenu, 'tenant' => $tenant]);
    }

    public function edit($id)
    {
        $tenant = Tenant::get();
        $jenisMenu = JenisMenu::get();
        $idMenu = Menu::find($id);
        return view('admin.menu.form', ['menu' => $idMenu,'jenisMenu' => $jenisMenu, 'tenant' => $tenant]);
    }

    public function update($id, Request $request){
        $request->validate([
            'nama_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tetapkan nullable untuk tidak wajib mengunggah file baru
        ]);
        $data = [
            'nama_menu' => $request->nama_menu,
            'id_jenis_menu' => $request->id_jenis_menu,
            'harga_jual' => $request->harga_jual,
            'id_tenant' => $request->id_tenant,
            'status_menu' => $request->status_menu
        ];
        if ($request->hasFile('nama_gambar')) {
            $image = $request->file('nama_gambar');
            if ($image->getError() == UPLOAD_ERR_OK) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = 'images/' . $imageName;
                $imageUrl = asset($imagePath);
                $data['nama_gambar'] = $imageUrl;
            } else {
                // Handle upload error
                return redirect()->back()->with('error', 'Failed to upload gambar.');
            }
        }

        Menu::find($id)->update($data);
        return redirect()->route('menu');

    }


    public function simpan(Request $request){
        $request->validate([
            'nama_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        if ($request->hasFile('nama_gambar')) {
            $image = $request->file('nama_gambar');
            // Check for upload errors
            if ($image->getError() == UPLOAD_ERR_OK) {
                // Process and save the file
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = 'images/' . $imageName;
                $imageUrl = asset($imagePath);

                $data = [
                    'nama_menu' => $request->nama_menu,
                    'id_jenis_menu' => $request->id_jenis_menu,
                    'harga_jual' => $request->harga_jual,
                    'id_tenant' => $request->id_tenant,
                    'status_menu' => $request->status_menu,
                    'nama_gambar' => $imageUrl
                ];

                Menu::create($data);
                return redirect()->route('menu');
            } else {
                // Handle upload error
                return redirect()->back()->with('error', 'Failed to upload gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'No gambar uploaded.');
        }

    }

    public function hapus($id_menu)
    {
        Menu::find($id_menu)->delete();
        return redirect()->route('menu');
    }

    public function getMenuById(Request $request)
    {
        if (Auth::check()) {
            $id_menu = $request->input('id_menu');
            $menu = Menu::find($id_menu);
            $user_id = Auth::id();

            return response()->json([
                'success' => true,
                'user_id'=>$id_menu,
                'menu' => $menu
            ]);
        }
    }

}
