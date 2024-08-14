<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'mst_tenant';

    protected $primaryKey = 'id_tenant';

    protected $fillable = ['id_tenant', 'nama_tenant','nama_kantin','url_gambar','id_user','qrcode_image','flag_aktif'];

    public function menus(){
        return $this->hasMany(Menu::class, 'id_tenant', 'id_tenant');
    }

    public function pesanan()
    {
        return $this->hasManyThrough(Pesanan::class, Menu::class, 'id_tenant', 'id_menu', 'id_tenant', 'id_menu');
    }

}
