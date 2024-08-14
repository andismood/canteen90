<?php



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
            Route::post('by-id', 'simpanPesanan')->name('dashboard.by-id.simpan');
        });

        Route::controller(PesananController::class)->prefix('pesanan')->group(function () {
            Route::get('', 'index')->name('pesanan');
            Route::get('cek-pesanan', 'getPesanan')->name('pesanan.cek');
            Route::get('cek-pilihan', 'cekPilihPesanan')->name('pesanan.pilihan');
            Route::post('konfirmasi', 'KonfirmasiPembayaran')->name('pesanan.konfirmasi');
            Route::get('pembayaran', 'Pembayaran')->name('pesanan.bayar');
            Route::post('pembayaran', 'lunas')->name('pesanan.lunas');
            Route::get('detail-pesanan', 'detailPesanan')->name('pesanan.detail');
            Route::delete('hapus-pesanan', 'hapusPesanan')->name('pesanan.hapus');
        });


        Route::controller(JenisMenuController::class)->prefix('jenis-menu')->group(function(){
            Route::get('', 'index')->name('jenis-menu');
            Route::get('tambah', 'tambah')->name('jenis-menu.tambah');
            Route::post('tambah', 'simpan')->name('jenis-menu.tambah.simpan');
            Route::get('edit/{id_jenis_menu}', 'edit')->name('jenis-menu.edit');
            Route::post('edit/{id_jenis_menu}', 'update')->name('jenis-menu.tambah.update');
            Route::get('hapus/{id_jenis_menu}', 'hapus')->name('jenis-menu.hapus');
        });

        Route::controller(MemberController::class)->prefix('member')->group(function () {
            Route::get('', 'index')->name('member');
            Route::get('tambah', 'tambah')->name('member.tambah');
            Route::post('tambah', 'simpan')->name('member.tambah.simpan');
            Route::get('edit/{id}', 'edit')->name('member.edit');
            Route::post('edit/{id}', 'update')->name('member.tambah.update');
            Route::get('hapus/{id}', 'hapus')->name('member.hapus');
        });

        Route::controller(ProfilController::class)->prefix('profil')->group(function () {
            Route::get('', 'index')->name('profil');
            Route::post('edit', 'update')->name('profil.update');
        });

        Route::controller(TenantController::class)->prefix('tenant')->group(function () {
            Route::get('', 'index')->name('tenant');
            Route::get('tambah', 'tambah')->name('tenant.tambah');
            Route::post('tambah', 'simpan')->name('tenant.tambah.simpan');
            Route::get('edit/{id}', 'edit')->name('tenant.edit');
            Route::post('edit/{id}', 'update')->name('tenant.tambah.update');
            Route::get('hapus/{id}', 'hapus')->name('tenant.hapus');
            Route::get('menu/{id_tenant}','menu')->name('tenant.menu-tenant');
            Route::get('tenant-byid', 'getById')->name('tenant.byid');
        });

        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('', 'index')->name('user');
            Route::get('reset/{id}', 'reset')->name('tenant.reset');
        });

        Route::controller(TipeUserController::class)->prefix('tipe-user')->group(function () {
            Route::get('', 'index')->name('tipe-user');
        });

        Route::controller(KelasController::class)->prefix('kelas')->group(function () {
            Route::get('', 'index')->name('kelas');
            Route::get('tambah', 'tambah')->name('kelas.tambah');
            Route::post('tambah', 'simpan')->name('kelas.tambah.simpan');
            Route::post('edit/{id}', 'update')->name('kelas.tambah.update');
            Route::get('edit/{id}', 'edit')->name('kelas.edit');
            Route::get('hapus/{id}', 'hapus')->name('kelas.hapus');
        });

        Route::controller(MenuController::class)->prefix('menu')->group(function () {
            Route::get('', 'index')->name('menu');
            Route::get('tambah', 'tambah')->name('menu.tambah');
            Route::post('tambah', 'simpan')->name('menu.tambah.simpan');
            Route::post('edit/{id}', 'update')->name('menu.tambah.update');
            Route::get('edit/{id}', 'edit')->name('menu.edit');
            Route::get('hapus/{id}', 'hapus')->name('menu.hapus');
            Route::get('by-id', 'getMenuById')->name('menu.by-id');

        });

});


// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');;

// });
