<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function index(){
        if (Auth::check()) {
            $menu = Menu::getAllMenu();
            return view('admin.index', ['data' => $menu]);
        }
        return view('login.index');
    }

    public function tenant()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            $query = Tenant::where('flag_aktif', '1');
            if ($type === "tnt") {
                $tnt = Tenant::where('id_user', $id)->first();
                $idTenant = $tnt->id_tenant;
                $query->where('id_tenant', $idTenant);
            }
        $tenant = $query->get();
        return view('admin.dashboard.index', ['data' => $tenant]);
        }
        return view('login.index');
    }


    public function getMenuById(Request $request)
    {
        if (Auth::check()) {
            $id_menu = $request->input('id_menu');
            $menu = Menu::find($id_menu);
            $user_id = Auth::id();

            return response()->json([
                'success' => true,
                'user_id'=> $user_id,
                'menu' => $menu
            ]);
        }
        return view('login.index');
    }

    public function simpanPesanan(Request $request){
        if (Auth::check()) {
            $pesan = [
            'id_user' => Auth::id(),
            'id_menu' => $request->id_menu,
            'id_tenant' => $request->id_tenant,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'catatan_menu' => $request->catatan_menu
            ];

            Pesanan::create($pesan);
            $data = [
                'message'=>"Data Berhasil disimpan"
            ];
            return $data;
        }
        return view('login.index');
    }
}
