<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userr1 extends Model
{
    use HasFactory;

    public $timestamps = null;
    protected $table = 'userr';
    protected $primaryKey = 'id';
    protected $fillable = ['id_buku', 'nama', 'alamat', 'no_tlp', 'role'];
}