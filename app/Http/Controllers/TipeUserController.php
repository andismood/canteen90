<?php

namespace App\Http\Controllers;

use App\Models\TipeUser;
use Illuminate\Http\Request;

class TipeUserController extends Controller
{
    public function index()
    {
        $tipe = TipeUser::get();

        return view("admin.tipe-user.index", ['data' => $tipe]);
    }
}
