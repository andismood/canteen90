<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMenu extends Model
{
    use HasFactory;

    protected $table = 'mst_jenis_menu';

    protected $primaryKey = 'id_jenis_menu';

    protected $fillable = ['id_jenis_menu','nama_jenis_menu'];
}
