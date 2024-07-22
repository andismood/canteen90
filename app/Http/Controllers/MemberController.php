<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $member= Member::get();
        return view("admin.member.index", ['data' => $member]);
    }

    public function tambah()
    {
        return view("admin.member.form");
    }

    public function simpan(Request $request)
    {
        //simpan ke table member
        $member['id_member'] = $request['id_member'];
        $member['nama_member'] = $request['nama_member'];
        Member::create($member);

        //simpan ke tbl login
        $user['id_user'] = $request['id_member'];
        $user['password'] = Hash::make('123');
        $user['id_type_user'] = "mbr";
        DB::table('mst_login')->insert($user);
        return redirect()->route('member');
    }

    public function edit($id)
    {
        $member = Member::find($id);
        return view('admin.member.form', ['member' => $member]);
    }

    public function update($id, Request $request)
    {
        $data = [
            'id_member' => $request->id_member,
            'nama_member' => $request->nama_member,
        ];

        Member::find($id)->update($data);
        return redirect()->route('member');
    }


    public function hapus($idMember)
    {
        $idLogin = Member::find($idMember);
        $id = $idLogin->id_member;
        DB::table('mst_login')->where('id_user',$id )->delete();
        Member::find($idMember)->delete();
        return redirect()->route('member');
    }
}
