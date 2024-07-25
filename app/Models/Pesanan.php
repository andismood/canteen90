<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'tbl_pesanan';

    protected $primaryKey = 'id_pesanan';

    protected $fillable = ['no_transaksi', 'id_user','id_tenant','id_menu','harga','catatan_menu','jumlah','total_harga'];


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id_tenant');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_user', 'id_member');
    }


}
