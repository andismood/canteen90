<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tbl_menu';

    protected $primaryKey = 'id_menu';

    protected $fillable = ['nama_menu','id_jenis_menu', 'harga_jual','id_tenant','status_menu','nama_gambar'];

    public function scopegetAllMenu(){
        return DB::select("select * from tbl_menu a
            join mst_jenis_menu b on a.id_jenis_menu = b.id_jenis_menu
            join mst_tenant c on a.id_tenant = c.id_tenant");
    }




}
