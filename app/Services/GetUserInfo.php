<?php

namespace App\Services;

use App\Models\User;
use App\Models\Member;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GetUserInfo {

    public function getUserInfo(){
        $id = Auth::id();
        $usr = User::find($id);
        $type = $usr->id_type_user;
        $tipe = DB::table('mst_type_user')->where('id_type_user', $type)->first();
        $nama_pengguna = "";
        if ($type === "tnt") {
            $tnt = Tenant::where('id_user', $id)->first();
            $nama_pengguna = $tnt->nama_tenant;
        }else if($type === "mbr"){
            $member = Member::find($id);
            $nama_pengguna = $member->nama_member;
        }else{
            $nama_pengguna = $id;
        }
        return ['nama'=>$nama_pengguna, 'tipe'=>$tipe];
    }

}
