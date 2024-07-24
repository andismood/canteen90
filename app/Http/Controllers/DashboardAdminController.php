<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PesananModel;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class DashboardAdminController extends Controller
{
    public function index(){
        $menu = Menu::getAllMenu();
        return view('admin.index', ['data' => $menu]);
    }

    public function tenant()
    {
        $tenant = Tenant::all();
        return view('admin.dashboard.index', ['data' => $tenant]);
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

            PesananModel::create($pesan);
            $data = [
                'message'=>"Data Berhasil disimpan"
            ];
            return $data;
        }
    }
}
