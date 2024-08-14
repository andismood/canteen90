<?php

namespace App\Http\Controllers;


use DateTime;
use App\Models\Menu;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Member;
use App\Models\Tenant;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $requestDate = now()->format('Y-m-d');
            $memberId = Auth::id();
            $menu = DB::Table('tbl_menu')
                ->join('tbl_pesanan', 'tbl_menu.id_menu', '=', 'tbl_pesanan.id_menu')
                ->whereNull('no_transaksi')
                ->whereDate('tbl_pesanan.created_at','=', $requestDate)
                ->where('tbl_pesanan.id_user', '=', $memberId)
                ->paginate(10);
            return view("admin.pesanan.index", ['data' => $menu]);
        }
        return view('login.index');
    }


    public function hapusPesanan(Request $request){
        if (Auth::check()) {
            $idTenant = $request->input('id_tenant');
            $idMenu = $request->input('id_menu');
            $requestDate = now()->format('Y-m-d');
            $memberId = Auth::id();
            try{
                $result = Pesanan::where('id_user', $memberId)
                    ->where('id_tenant', $idTenant)
                    ->where('id_menu', $idMenu)
                    ->whereNull('no_transaksi')
                    ->whereDate('created_at', $requestDate)
                    ->delete();
                if ($result > 0) {
                    return response()->json(['message' => 'Data berhasil di hapus'], 200);
                } else {
                    return response()->json(['message' => 'No rows were deleted'], 404);
                }
            } catch (\Exception $e) {
                // Handle the exception
                return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
            }

        }
        return view('login.index');
    }


public function cekPilihPesanan(Request $request){
    if (Auth::check()) {
        $id_menu = $request->input('id_menu');
        $requestDate = now()->format('Y-m-d');
        $memberId  = Auth::id();
            $results = Pesanan::where('id_menu', $id_menu)
            ->where('id_user', $memberId)
            ->whereDate('created_at', $requestDate)
            ->whereNull('no_transaksi')
            ->get();
            if ($results->isNotEmpty()) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Anda Sudah Memesan Menu ini !'
                ]);
            }
        $cekMenu = Menu::find($id_menu);
            // cek status menu (1 habis 2 tidak tersedia)
            if($cekMenu->status_menu === "1"){
                return response()->json([
                    'status' => 1,
                    'message' => 'Maaf, Menu yang anda pesan sudah habis !'
                ]);
            }



    }
        return view('login.index');
}

    public function getPesanan(){
        if (Auth::check()) {
            $requestDate = now()->format('Y-m-d');
            $memberId  = Auth::id();
            $member = Member::find($memberId);

            $pesanan = Tenant::whereHas('menus.pesanan', function ($query) use ($requestDate, $memberId) {
                $query->whereNotNull('id_pesanan')
                    ->whereDate('created_at', $requestDate)
                    ->whereNull('no_transaksi')
                    ->where('id_user', $memberId);
            })
            ->with(['menus.pesanan' => function ($query) use ($requestDate, $memberId) {
                $query->whereDate('created_at', $requestDate)
                    ->whereNull('no_transaksi')
                    ->where('id_user', $memberId);
            }, 'menus' => function ($query) {
            }])
            ->get();
            return response()->json([
                'success' => true,
                'user_id' => $memberId,
                'nama_member'=> $member->nama_member,
                'id_kelas'=>$member->id_kelas,
                'menu' => $pesanan
            ]);

        }
        return view('login.index');
    }

    public function KonfirmasiPembayaran(Request $request){
        $rules = [
            'id_tenant' => 'required', // Validasi id_tenant sebagai integer dan pastikan ada di tabel tenants
            'qrcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file qrcode jika ada
        ];

        if (Auth::check()) {
            $jenisBayar = $request->input('jenis_bayar');
            if ($jenisBayar === "cash") {
            } else {
                $request->validate([
                    'qrcode' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tetapkan nullable untuk tidak wajib mengunggah file baru
                ]);
            }
            $idTenant = $request->input('id_tenant');
            $requestDate = now()->format('Y-m-d');
            $memberId  = Auth::id();
            $fileName ="";
            DB::beginTransaction();
            try{
                if ($request->hasFile('qrcode')) {
                    $file = $request->file('qrcode');
                    $fileName = $memberId ."-". time().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('gambar-qris'), $fileName);
                }
                $currentNumber =DB::table('tbl_pembayaran')
                ->select(DB::raw('max(substr(no_transaksi, 3)) AS max_number'))
                ->value('max_number');
                if (empty($currentNumber)) {
                    $no_akhir = "K-00001";
                }else{
                    $numberPart = substr($currentNumber, 2);
                    $number = intval($numberPart);
                    $number++;
                    // Format nomor baru menjadi 4 digit dengan awalan "K-"
                    $no_akhir = "K-" . str_pad($number, 5, '0', STR_PAD_LEFT);
                }

                $result = Pesanan::where(['id_tenant'=> $idTenant, 'id_user'=> $memberId])->whereNull('no_transaksi')->whereDate('created_at', $requestDate)->get();
                $totalHarga = 0;
                foreach($result as $row){
                    $totalHarga += $row->total_harga;
                    Pesanan::where('id_menu', $row->id_menu)
                        ->where('id_tenant', $row->id_tenant)
                        ->where('id_user', $memberId)
                        ->whereNull('no_transaksi')
                        ->whereDate('created_at', $requestDate)
                        ->update(['no_transaksi' => $no_akhir]);
                }
                $bayar = [
                    'no_transaksi'=> $no_akhir,
                    'jumlah_bayar' => 0,
                    'total_bayar'=> $totalHarga,
                    'kembali' => 0,
                    'status_bayar' => "0",
                    'qrcode'=> $fileName ,
                    'jenis_bayar' => $jenisBayar
                ];
                Pembayaran::create($bayar);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => "Data berasil dikonfirmasi "
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'An error occurred ' . $e], 500);
            }

        }
        return view('login.index');
    }

    public function Pembayaran(Request $request){
        if (Auth::check()) {
           $tanggal = $request->input('tgl');
           $flag = $request->input('flag');

            $id = Auth::id();
            $usr = User::find($id);
            $type = $usr->id_type_user;
            if ($type === "tnt") {
                $tenant = Tenant::where('id_user', $id)->first();
                $idTenant = $tenant->id_tenant;
            }
            $query = DB::table('tbl_pembayaran as a')
            ->join('tbl_pesanan as b', 'a.no_transaksi', '=', 'b.no_transaksi')
            ->join('mst_member as c', 'b.id_user', '=', 'c.id_member')
            ->join('mst_tenant as d', 'b.id_tenant','=','d.id_tenant')
            ->select('a.no_transaksi', 'c.id_member', 'c.nama_member', 'id_kelas', 'a.total_bayar', 'a.jenis_bayar', 'd.id_tenant','d.nama_kantin','status_bayar','qrcode')
            ->groupBy('a.no_transaksi', 'c.id_member', 'c.nama_member', 'id_kelas', 'a.total_bayar','a.jenis_bayar', 'd.id_tenant','d.nama_kantin','status_bayar', 'qrcode');
            if ($type === "tnt") {
                $query->where('d.id_tenant', $idTenant);
            }else if($type === "mbr"){
                $query->where('c.id_member', $id);
            }
            if($tanggal != null){
                $query->whereDate('b.created_at', $tanggal);
            }else{
                $requestDate = now()->format('Y-m-d');
                $query->whereDate('b.created_at', $requestDate);
            }
            if($flag != ""){
                $query->where('status_bayar', $flag);
            }
            $results = $query->paginate(25);
            return view("admin.pembayaran.index", ['data' => $results, 'tgl' => $tanggal, 'flag' => $flag]);
        }
        return view('login.index');
    }

    public function lunas(Request $request){
        if (Auth::check()) {
            $memberId  = Auth::id();
            $no = $request->input('no_transaksi');
            $affected =  Pembayaran::where('no_transaksi', $no)
                        ->update(['status_bayar'=>'1','id_user'=>$memberId]);
            if ($affected > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Data berasil dikonfirmasi "
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Data gagal dikonfirmasi "
                ]);
            }

        }
        return view('login.index');
    }

    public function detailPesanan(Request $request)
    {
        if (Auth::check()) {
            $memberId  =$request->input('id_member');
            $no = $request->input('no_transaksi');
            $tenant = $request->input('id_tenant');

            $member = Member::find($memberId);
            $kelas = Kelas::find($member->id_kelas);
            // $pesanan = Tenant::with('menus')->find($tenant);
            $pesanan = Tenant::with(['menus.pesanan' => function ($query) use ($memberId,$no) {
                $query->where('id_user', $memberId)
                ->where('no_transaksi',$no);
            }])->find($tenant);

            foreach ($pesanan->menus as $menu) {
                foreach ($menu->pesanan as $pesan) {
                    if ($pesan->created_at != null) {
                        $dateTime = new DateTime($pesan->created_at);
                        $formattedDateTime = $dateTime->format('d-m-Y H:i:s');
                    }
                }
            }


            return response()->json([
                'success' => true,
                'tanggal'=> $formattedDateTime,
                'nama_member' => $member->nama_member,
                'id_kelas' => $member->id_kelas,
                'keterangan'=> $kelas->keterangan,
                'pesanan' => $pesanan
            ]);

        }
        return view('login.index');
    }

}
