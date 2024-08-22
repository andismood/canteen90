<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Tenant;
use App\Models\JenisMenu;
use Illuminate\Http\Request;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MenuController extends Controller
{

    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }


    public function index()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if ($type === "tnt") {
                $tenant = Tenant::where('id_user', $id)->first();
                $idTenant = $tenant->id_tenant;
            }
            $menu = DB::table('tbl_menu as a')
                ->join('mst_jenis_menu as b', 'a.id_jenis_menu', '=', 'b.id_jenis_menu')
                ->join('mst_tenant as c', 'a.id_tenant', '=', 'c.id_tenant')
                ->select('a.*', 'b.*', 'c.*');
            if ($type === "tnt") {
                $menu->where('c.id_tenant', $idTenant);
            }
            $result = $menu->paginate(10);
            $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
            // $menu = Menu::getAllMenu();
            return view("admin.menu.index", ['data' => $result, 'nama' => $nama, 'tipe' => $tipe]);
        }
        return view('login.index');
    }


    public function tambah()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if ($type === "tnt") {
                $tenant = Tenant::where('id_user', $id)->first();
                $idTenant = $tenant->id_tenant;
                $tenant = Tenant::where('id_tenant',$idTenant)->get();
            }else{
                $tenant = Tenant::get();
            }
            $jenisMenu = JenisMenu::get();
            return view("admin.menu.form", ['jenisMenu' => $jenisMenu, 'tenant' => $tenant]);
        }
        return view('login.index');
    }

    public function edit($idMenu)
    {
        if (Auth::check()) {
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if ($type === "tnt") {
                $tenant = Tenant::where('id_user', $id)->first();
                $idTenant = $tenant->id_tenant;
                $tenant = Tenant::where('id_tenant', $idTenant)->get();
            } else {
                $tenant = Tenant::get();
            }
            $jenisMenu = JenisMenu::get();
            $menu = Menu::find($idMenu);
            return view('admin.menu.form', ['menu' => $menu, 'jenisMenu' => $jenisMenu, 'tenant' => $tenant]);
        }
        return view('login.index');
    }

    public function update($id, Request $request){
        if (Auth::check()) {
        $request->validate([
            'nama_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_menu' => ['required', 'max:35'],
            'id_jenis_menu' => 'required',
            'harga_jual' => ['required', 'max:6'],
            'id_tenant' => 'required',
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
               // $imagePath = 'images/' . $imageName;
           //     $imageUrl = asset($imagePath);
                $data['nama_gambar'] = $imageName;
            } else {
                // Handle upload error
                return redirect()->back()->with('error', 'Failed to upload gambar.');
            }
        }

        Menu::find($id)->update($data);
        return redirect()->route('menu');
        }
        return view('login.index');
    }


    public function simpan(Request $request){
        if (Auth::check()) {
        $request->validate([
            'nama_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_menu'=>['required','max:35'],
            'id_jenis_menu'=> 'required',
            'harga_jual'=>['required', 'max:6'],
            'id_tenant'=> 'required',
        ]);

        if ($request->hasFile('nama_gambar')) {
            $image = $request->file('nama_gambar');
            // Check for upload errors
            if ($image->getError() == UPLOAD_ERR_OK) {
                // Process and save the file
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
               // $imagePath = 'images/' . $imageName;
               // $imageUrl = asset($imagePath);

                $data = [
                    'nama_menu' => $request->nama_menu,
                    'id_jenis_menu' => $request->id_jenis_menu,
                    'harga_jual' => $request->harga_jual,
                    'id_tenant' => $request->id_tenant,
                    'status_menu' => $request->status_menu,
                    'nama_gambar' => $imageName
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
        return view('login.index');
    }

    public function hapus($id_menu)
    {
        if (Auth::check()) {
        Menu::find($id_menu)->delete();
        return redirect()->route('menu');
        }
        return view('login.index');
    }


    public function getMenuById(Request $request)
    {
        if (Auth::check()) {
            $id_menu = $request->input('id_menu');
            $menu = Menu::find($id_menu);
           // $user_id = Auth::id();

            return response()->json([
                'success' => true,
                'user_id'=>$id_menu,
                'menu' => $menu
            ]);
        }
        return view('login.index');
    }


}
