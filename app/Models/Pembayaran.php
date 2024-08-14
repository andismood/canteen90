<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = "tbl_pembayaran";

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = ['no_transaksi', 'jumlah_bayar', 'total_bayar','kembali','status_bayar','jenis_bayar','qrcode'];
}
