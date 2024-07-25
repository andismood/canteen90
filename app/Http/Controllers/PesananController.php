<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Tenant;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::id();
            $menu = DB::Table('tbl_menu')
                ->join('tbl_pesanan', 'tbl_menu.id_menu', '=', 'tbl_pesanan.id_menu')
                ->where('tbl_pesanan.id_user', '=', $user)
                ->get();
            return view("admin.pesanan.index", ['data' => $menu]);
        }
    }

    public function CekPesanan(){
        if (Auth::check()) {
            $user = Auth::id();
            $menu = DB::Table('tbl_menu')
            ->join('tbl_pesanan', 'tbl_menu.id_menu', '=', 'tbl_pesanan.id_menu')
            ->where('tbl_pesanan.id_user', '=', $user)
            ->get();
            return response()->json([
                'success' => true,
                'user_id' => $user,
                'menu' => $menu
            ]);
        }
    }

    public function getPesanan(){

        // $pesanan = Tenant::with('menu')->get();
        //$pesanan = Pesanan::with('menus')->get();
        // $pesanan = Tenant::with(['menus.pesanan'])->get();
        $pesanan = Tenant::with(['menus.pesanan.member'])
                   ->whereHas('menus.pesanan', function ($query) {
                  $query->whereNotNull('tbl_pesanan.id_pesanan');
                  })->get();
        return response()->json([
            'success' => true,
            'user_id' => "123",
            'menu' => $pesanan
        ]);
    }
}
