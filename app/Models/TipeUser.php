<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeUser extends Model
{
    use HasFactory;

    protected $table = 'mst_type_user';

    protected $fillable = ['id_type_user', 'nama_type_user'];
}
