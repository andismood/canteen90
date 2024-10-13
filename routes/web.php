<?php



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TipeUserController;
use App\Http\Controllers\JenisMenuController;
use App\Http\Controllers\DashboardAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('dashboard');
    } else {
        return view('home');
    }

});


Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');;

Route::middleware('auth')->group(
    function () {

        Route::controller(DashboardAdminController::class)->prefix('dashboard')->group(function () {
            Route::get('', 'tenant')->name('dashboard');
            Route::get('by-id', 'getMenuById')->name('dashboard.by-id');
            Route::post('by-id', 'simpanPesanan')->name('dashboard.by-id.simpan')->middleware('role:mbr');
        });

        Route::controller(PesananController::class)->prefix('pesanan')->group(function () {
            Route::get('', 'index')->name('pesanan')->middleware('role:adm,mbr');
            Route::get('cek-pesanan', 'getPesanan')->name('pesanan.cek');
            Route::get('cek-pilihan', 'cekPilihPesanan')->name('pesanan.pilihan');
            Route::post('konfirmasi', 'KonfirmasiPembayaran')->name('pesanan.konfirmasi')->middleware('role:adm,tnt,mbr');
            Route::get('pembayaran', 'Pembayaran')->name('pesanan.bayar');
            Route::post('pembayaran', 'lunas')->name('pesanan.lunas')->middleware('role:adm,tnt');
            Route::post('pickup', 'pickup')->name('pesanan.pickup')->middleware('role:adm,tnt');
            Route::get('detail-pesanan', 'detailPesanan')->name('pesanan.detail');
            Route::delete('hapus-pesanan', 'hapusPesanan')->name('pesanan.hapus')->middleware('role:adm,mbr');
        });


        Route::controller(JenisMenuController::class)->prefix('jenis-menu')->group(function(){
            Route::get('', 'index')->name('jenis-menu')->middleware('role:adm');
            Route::get('tambah', 'tambah')->name('jenis-menu.tambah')->middleware('role:adm');;
            Route::post('tambah', 'simpan')->name('jenis-menu.tambah.simpan')->middleware('role:adm');
            Route::get('edit/{id_jenis_menu}', 'edit')->name('jenis-menu.edit')->middleware('role:adm');
            Route::post('edit/{id_jenis_menu}', 'update')->name('jenis-menu.tambah.update')->middleware('role:adm');
            Route::get('hapus/{id_jenis_menu}', 'hapus')->name('jenis-menu.hapus')->middleware('role:adm');
        });

        Route::controller(MemberController::class)->prefix('member')->group(function () {
            Route::get('', 'index')->name('member')->middleware('role:adm');
            Route::get('tambah', 'tambah')->name('member.tambah')->middleware('role:adm');
            Route::post('tambah', 'simpan')->name('member.tambah.simpan')->middleware('role:adm');
            Route::get('edit/{id}', 'edit')->name('member.edit')->middleware('role:adm');
            Route::post('edit/{id}', 'update')->name('member.tambah.update')->middleware('role:adm');
            Route::get('hapus/{id}', 'hapus')->name('member.hapus')->middleware('role:adm');
        });

        Route::controller(ProfilController::class)->prefix('profil')->group(function () {
            Route::get('', 'index')->name('profil')->middleware('role:adm,tnt,mbr');
            Route::post('edit', 'update')->name('profil.update')->middleware('role:adm,tnt,mbr');
        });

        Route::controller(TenantController::class)->prefix('tenant')->group(function () {
            Route::get('', 'index')->name('tenant')->middleware('role:adm');
            Route::get('tambah', 'tambah')->name('tenant.tambah')->middleware('role:adm');
            Route::post('tambah', 'simpan')->name('tenant.tambah.simpan')->middleware('role:adm');
            Route::get('edit/{id}', 'edit')->name('tenant.edit')->middleware('role:adm,tnt');
            Route::post('edit/{id}', 'update')->name('tenant.tambah.update')->middleware('role:adm,tnt');
            Route::get('hapus/{id}', 'hapus')->name('tenant.hapus')->middleware('role:adm');
            Route::get('menu/{id_tenant}','menu')->name('tenant.menu-tenant')->middleware('role:adm,tnt,mbr');
            Route::get('tenant-byid', 'getById')->name('tenant.byid')->middleware('role:adm,tnt,mbr');
        });

        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('', 'index')->name('user')->middleware('role:adm');
            Route::get('reset/{id}', 'reset')->name('user.reset')->middleware('role:adm');
            Route::put('reset', 'ubah')->name('user.ubah');
        });

        Route::controller(TipeUserController::class)->prefix('tipe-user')->group(function () {
            Route::get('', 'index')->name('tipe-user')->middleware('role:adm');
        });

        Route::controller(KelasController::class)->prefix('kelas')->group(function () {
            Route::get('', 'index')->name('kelas')->middleware('role:adm');
            Route::get('tambah', 'tambah')->name('kelas.tambah')->middleware('role:adm');
            Route::post('tambah', 'simpan')->name('kelas.tambah.simpan')->middleware('role:adm');
            Route::post('edit/{id}', 'update')->name('kelas.tambah.update')->middleware('role:adm');
            Route::get('edit/{id}', 'edit')->name('kelas.edit')->middleware('role:adm');
            Route::get('hapus/{id}', 'hapus')->name('kelas.hapus')->middleware('role:adm');
        });

        Route::controller(MenuController::class)->prefix('menu')->group(function () {
            Route::get('', 'index')->name('menu')->middleware('role:adm,tnt');
            Route::get('tambah', 'tambah')->name('menu.tambah')->middleware('role:adm,tnt');
            Route::post('tambah', 'simpan')->name('menu.tambah.simpan')->middleware('role:adm,tnt');
            Route::post('edit/{id}', 'update')->name('menu.tambah.update')->middleware('role:adm,tnt');
            Route::get('edit/{id}', 'edit')->name('menu.edit')->middleware('role:adm,tnt');
            Route::get('hapus/{id}', 'hapus')->name('menu.hapus')->middleware('role:adm,tnt');
            Route::get('by-id', 'getMenuById')->name('menu.by-id')->middleware('role:adm,mbr');

        });

});


// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');;

// });
