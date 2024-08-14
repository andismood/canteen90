<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "mst_kelas";

    public $incrementing = false;

    protected $primaryKey = 'id_kelas';

    protected $fillable = ['id_kelas', 'nama_kelas','keterangan'];

    public $timestamps = false;

    public function members()
    {
        return $this->hasMany(Member::class, 'id_kelas');
    }

}
