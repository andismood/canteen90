<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'mst_tenant';

    protected $primaryKey = 'id_tenant';

    protected $fillable = ['id_tenant', 'nama_tenant','nama_kantin','url_gambar','id_user'];
}
