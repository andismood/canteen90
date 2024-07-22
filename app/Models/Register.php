<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //use HasFactory;
    protected $table = "mst_member";

    public $timestamps = false;

    protected $fillable = [
        'id_member',
        'nama_member',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
