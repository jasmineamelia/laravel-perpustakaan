<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userr extends Model
{
    protected $table = 'userr';
    protected $primarykey = 'id';
    public $timestamps = null;
    protected $fillable = ['nama_siswa', 'tanggal_lahir', 'gender', 'alamat', 'id_kelas'];
}
