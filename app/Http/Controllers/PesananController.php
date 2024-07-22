<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
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
}
