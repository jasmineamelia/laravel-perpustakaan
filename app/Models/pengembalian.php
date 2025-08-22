<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_buku';
    protected $primarykey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_peminjaman','tgl_pengembalian','denda', 'status'];
}