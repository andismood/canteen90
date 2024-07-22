<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_pesanan';

    protected $primaryKey = 'id_pesanan';

    protected $fillable = ['no_transaksi', 'id_user','id_tenant','id_menu','harga','catatan_menu','jumlah','total_harga'];
}
