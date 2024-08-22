<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GetUserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $getUserInfo;

    public function __construct(GetUserInfo $getUserInfo)
    {
        $this->getUserInfo = $getUserInfo;
    }

    public function index()
    {
        if (Auth::check()) {
            $member = DB::table('mst_member')
                ->selectRaw('mst_login.id_user, mst_member.nama_member as nama_user, mst_login.id_type_user, mst_type_user.nama_type_user')
                ->join('mst_login', 'mst_member.id_member', '=', 'mst_login.id_user')
                  ->join('mst_type_user', 'mst_login.id_type_user', '=', 'mst_type_user.id_type_user')
                  ->where('mst_login.id_type_user','<>','adm');
            $tenan =  DB::table('mst_tenant')
                 ->selectRaw('mst_login.id_user, mst_tenant.nama_tenant as nama_user, mst_login.id_type_user, mst_type_user.nama_type_user')
                 ->join('mst_login', 'mst_tenant.id_user', '=', 'mst_login.id_user')
                 ->join('mst_type_user', 'mst_login.id_type_user', '=', 'mst_type_user.id_type_user')
                 ->where('mst_login.id_type_user', 'tnt')
                 ->union($member)
                 ->paginate(10);
            $userInfo = $this->getUserInfo->getUserInfo();
            $nama = isset($userInfo['nama']) ? $userInfo['nama'] : '';
            $tipe = isset($userInfo['tipe']) ? $userInfo['tipe'] : '';
            return view("admin.user.index", ['data' =>$tenan, 'nama' => $nama, 'tipe' => $tipe]);
        }
        return view('login.index');
    }

    public function reset($id_user)
    {
        if (Auth::check()) {
        $data = [
            'password' => Hash::make('1234')
        ];
        User::find($id_user)->update($data);
        return redirect()->route('user')->with('success', 'Password berhasil di ubah menjadi : 1234');
        }
        return view('login.index');
    }

    public function ubah(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'id_user' => ['required', 'min:3', 'max:12'],
                'password' => 'required|min:3',
            ]);
            try{
                $id_user = $request['id_user'];
                $data = [
                    'password' => Hash::make($request['password'])
                ];
                $ada = User::find($id_user);
                if(!$ada){
                    return response()->json(['message' => 'User tidak di temukan'], 404);
                }
                $success = $ada->update($data);
                if ($success) {
                    return response()->json([
                        'message' => 'Password berhasil diubah',
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Failed to update password',
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred ' . $e->getMessage()], 500);
            }

        }
        return view('login.index');
    }

}
