<?php

namespace App\Http\Controllers;


use App\Models\Menu;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        $tenant = Tenant::get();
        return view("admin.tenan.index", ['data' => $tenant]);
    }

    public function tambah()
    {
        return view("admin.tenan.form");
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nm_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);
        if ($request->hasFile('nm_gambar')) {
            $image = $request->file('nm_gambar');
            if ($image->getError() == UPLOAD_ERR_OK) {
                // Process and save the file
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = 'images/' . $imageName;
                $imageUrl = asset($imagePath);

                $data = [
                    'nama_tenant' => $request->nama_tenant,
                    'nama_kantin' => $request->nama_kantin,
                    'id_user' => $request->id_user,
                    'url_gambar' => $imageUrl
                ];

                Tenant::create($data);

                //simpan ke tbl login
                $user['id_user'] = $request['id_user'];
                $user['password'] = Hash::make('123');
                $user['id_type_user'] = "tnt";
                DB::table('mst_login')->insert($user);

                return redirect()->route('tenant');
            } else {
                // Handle upload error
                return redirect()->back()->with('error', 'Failed to upload gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'No gambar uploaded.');
        }




    }

    public function edit($id)
    {
        $idTenant = Tenant::find($id);
        return view('admin.tenan.form', ['tenant' => $idTenant]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nm_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tetapkan nullable untuk tidak wajib mengunggah file baru
        ]);

        $data = [
            'nama_tenant' => $request->nama_tenant,
            'nama_kantin' => $request->nama_kantin
        ];

        if ($request->hasFile('nm_gambar')) {
            $image = $request->file('nm_gambar');
            if ($image->getError() == UPLOAD_ERR_OK) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = 'images/' . $imageName;
                $imageUrl = asset($imagePath);
                $data['url_gambar'] = $imageUrl;

            } else {
                // Handle upload error
                return redirect()->back()->with('error', 'Failed to upload gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'No gambar uploaded.');
        }

        Tenant::find($id)->update($data);
        return redirect()->route('tenant');
    }


    public function hapus($id_tenant)
    {
        $idLogin = Tenant::find($id_tenant);
        $id = $idLogin->id_user;
        DB::table('mst_login')->where('id_user', $id)->delete();
        Tenant::find($id_tenant)->delete();

        return redirect()->route('tenant');
    }


    public function menu($id_tenant){
        $menu =  DB::select("select * from tbl_menu a
            join mst_jenis_menu b on a.id_jenis_menu = b.id_jenis_menu
            join mst_tenant c on a.id_tenant = c.id_tenant where c.id_tenant= ? ", [$id_tenant]);
        return view('admin.tenan.menu-tenant', ['data' => $menu]);
    }

}
