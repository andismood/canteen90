<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }

    public function index()
    {
        if (Auth::check()) {
        $member= Member::paginate(10);
            $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
        return view("admin.member.index", ['data' => $member, 'nama' => $nama, 'tipe' => $tipe]);
        }
        return view('login.index');
    }

    public function tambah()
    {
        if (Auth::check()) {
        $kelas = Kelas::get();
        return view("admin.member.form",['kelas' => $kelas]);
        }
        return view('login.index');
    }

    public function simpan(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'id_member'=>['required','min:3','max:12','unique:mst_member'],
                'nama_member' => ['required', 'min:3', 'max:50'],
                'id_kelas' => 'required',
            ]);
            try{
                DB::beginTransaction();
                //simpan ke table member
                $member['id_member'] = $request['id_member'];
                $member['nama_member'] = $request['nama_member'];
                $member['id_kelas'] = $request['id_kelas'];
                Member::create($member);

                //simpan ke tbl login
                $user['id_user'] = $request['id_member'];
                $user['password'] = Hash::make('1234');
                $user['id_type_user'] = "mbr";
                DB::table('mst_login')->insert($user);
                DB::commit();
                return redirect()->route('member');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal menyimpan data '.$e->getMessage());
            }

        }
        return view('login.index');
    }

    public function edit($id)
    {
        if (Auth::check()) {
        $member = Member::find($id);
        $kelas = Kelas::get();
        return view('admin.member.form', ['member' => $member, 'kelas'=> $kelas]);
        }
        return view('login.index');
    }

    public function update($id, Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'nama_member' => ['required', 'min:3', 'max:50'],
                'id_kelas' => 'required',
            ]);
            $data = [
                'nama_member' => $request->nama_member,
                'id_kelas' => $request->id_kelas,
            ];
            Member::find($id)->update($data);
            return redirect()->route('member');
        }
        return view('login.index');
    }


    public function hapus($idMember)
    {
        if (Auth::check()) {
            try{
                DB::beginTransaction();
                $idLogin = Member::find($idMember);
                $id = $idLogin->id_member;
                DB::table('mst_login')->where('id_user', $id)->delete();
                Member::find($idMember)->delete();
                DB::commit();
                return redirect()->route('member');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal menyimpan data ' . $e->getMessage());
            }

        }
        return view('login.index');
    }
}
