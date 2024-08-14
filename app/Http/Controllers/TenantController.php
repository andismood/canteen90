<?php

namespace App\Http\Controllers;


use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
        $tenant = Tenant::paginate(10);
        return view("admin.tenan.index", ['data' => $tenant]);
        }
        return view('login.index');
    }


    public function getById(Request $request){
        if (Auth::check()) {
        $id = $request->input('id_tenant');
        return Tenant::find($id);
        }
        return view('login.index');
    }

    public function tambah()
    {
        if (Auth::check()) {
        return view("admin.tenan.form");
        }
        return view('login.index');
    }

    public function simpan(Request $request)
    {
        if (Auth::check()) {
        $imageName="";
        $imageQr = "";

        $request->validate([
            'nm_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'qrcode_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_tenant'=>['required', 'max:30'],
            'nama_kantin'=>['required', 'max:25'],
            'flag_aktif' => 'required',
            'id_user'=>['required', 'min:3', 'max:12', 'unique:mst_login']
        ]);

        DB::beginTransaction();
        try{
            if ($request->hasFile('qrcode_image')) {
                $qrcode = $request->file('qrcode_image');
                if ($qrcode->getError() == UPLOAD_ERR_OK) {
                    $imageQr = "Q" . time() . '.' . $qrcode->getClientOriginalExtension();
                    $qrcode->move(public_path('privates'), $imageQr);
                }
            }
            if ($request->hasFile('nm_gambar')) {
                $image = $request->file('nm_gambar');
                if ($image->getError() == UPLOAD_ERR_OK) {
                    // Process and save the file
                    $imageName = "L" . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('privates'), $imageName);
                    // $imagePath = 'images/' . $imageName;
                    // $imageUrl = asset($imagePath);

                    $data = [
                        'nama_tenant' => $request->nama_tenant,
                        'nama_kantin' => $request->nama_kantin,
                        'id_user' => $request->id_user,
                        'url_gambar' => $imageName,
                        'qrcode_image' => $imageQr,
                        'flag_aktif' => $request->flag_aktif
                    ];
                    Tenant::create($data);

                    //simpan ke tbl login
                    $user['id_user'] = $request['id_user'];
                    $user['password'] = Hash::make('1234');
                    $user['id_type_user'] = "tnt";
                    DB::table('mst_login')->insert($user);
                    DB::commit();
                    return redirect()->route('tenant');
                } else {
                    // Handle upload error
                    return redirect()->back()->with('error', 'Failed to upload gambar.');
                }
            } else {
                return redirect()->back()->with('error', 'No gambar uploaded.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred '. $e], 500);
        }
}
        return view('login.index');
    }

    public function edit($idUserTenant)
    {
        if (Auth::check()) {
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if($type === "tnt"){
                $tenant = Tenant::where('id_user', $id)->first();
                $id = $tenant->id_tenant;
            }else{
                $id = $idUserTenant;
            }
            $Tenant = Tenant::find($id);
            return view('admin.tenan.form', ['tenant' => $Tenant]);
        }
        return view('login.index');
    }

    public function update($id, Request $request)
    {
        if (Auth::check()) {
        $imageName = "";
        $imageQrNm = "";
        $request->validate([
            'nm_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tetapkan nullable untuk tidak wajib mengunggah file baru
            'qrcode_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'flag_aktif' => 'required',
            'nama_tenant' => ['required', 'max:30'],
            'nama_kantin' => ['required', 'max:25'],
        ]);

        $data = [
            'nama_tenant' => $request->nama_tenant,
            'nama_kantin' => $request->nama_kantin,
            'flag_aktif' => $request->flag_aktif
        ];

        DB::beginTransaction();
        try{
            if ($request->hasFile('qrcode_image')) {
                $qrcode = $request->file('qrcode_image');
                if ($qrcode->getError() == UPLOAD_ERR_OK) {
                    $imageQrNm = "Q" . time() . '.' . $qrcode->getClientOriginalExtension();
                    $qrcode->move(public_path('privates'), $imageQrNm);
                    $data['qrcode_image'] = $imageQrNm;
                }
            }

            if ($request->hasFile('nm_gambar')) {
                $image = $request->file('nm_gambar');
                if ($image->isValid()) { // Check if the image upload is valid
                    $imageName = "L" . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('privates'), $imageName);
                    // Set the image name in the data array
                    $data['url_gambar'] = $imageName;
                } else {
                    // Handle upload error
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Failed to upload gambar.')->withInput();
                }
            }

            // Update tenant
            $tenant = Tenant::find($id);
            if (!$tenant) {
                // Handle case where tenant is not found
                DB::rollBack();
                return redirect()->back()->with('error', 'Tenant not found.')->withInput();
            }

            $tenant->update($data);

            // Commit transaction
            DB::commit();
            //cek type user tenan atau  admin
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if($type === "adm"){
                return redirect()->route('tenant');
            }else{
                return redirect()->back()->with('success', 'data berhasil diubah');
            }

        } catch (\Exception $e) {
            DB::rollBack();
                return redirect()->back()->with('error', 'error karena '.$e->getMessage());
        }
        }
        return view('login.index');

    }


    public function hapus($id_tenant)
    {
        if (Auth::check()) {
        $idLogin = Tenant::find($id_tenant);
        $id = $idLogin->id_user;
        DB::table('mst_login')->where('id_user', $id)->delete();
        Tenant::find($id_tenant)->delete();

        return redirect()->route('tenant');
        }
        return view('login.index');
    }


    public function menu($id_tenant){
        if (Auth::check()) {
        $result = Tenant::where('id_tenant',$id_tenant)->where('flag_aktif','1')->first();
        if($result){

                $menu = DB::table('tbl_menu as a')
                ->join('mst_jenis_menu as b', 'a.id_jenis_menu', '=', 'b.id_jenis_menu')
                ->join('mst_tenant as c', 'a.id_tenant', '=', 'c.id_tenant')
                ->where('c.id_tenant', $id_tenant)
                ->where('status_menu', '<>' , "2")
                ->select('a.*', 'b.*', 'c.*')
                ->get();

            return view('admin.tenan.menu-tenant', ['data' => $menu]);

        }else{
            $tenant = Tenant::where('flag_aktif', '1')->get();
            return view('admin.dashboard.index', ['data' => $tenant]);
        }
}
        return view('login.index');
    }

}
