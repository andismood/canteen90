<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $member = DB::table('mst_member')
                ->selectRaw('mst_login.id_user, mst_member.nama_member as nama_user, mst_login.id_type_user, mst_type_user.nama_type_user')
               ->join('mst_login', 'mst_member.id_member', '=', 'mst_login.id_user')
               ->join('mst_type_user', 'mst_login.id_type_user', '=', 'mst_type_user.id_type_user');
        $tenan =  DB::table('mst_tenant')
                ->selectRaw('mst_login.id_user, mst_tenant.nama_tenant as nama_user, mst_login.id_type_user, mst_type_user.nama_type_user')
                ->join('mst_login', 'mst_tenant.id_user', '=', 'mst_login.id_user')
                ->join('mst_type_user', 'mst_login.id_type_user', '=', 'mst_type_user.id_type_user')
                ->where('mst_login.id_type_user', 'tnt')
                ->union($member)
                ->get();
        return view("admin.user.index", ['data' => $tenan]);
    }

    public function reset($id_user)
    {
        $data = [
            'password' => Hash::make('1234')
        ];
        User::find($id_user)->update($data);
        return redirect()->route('user');
    }
}
