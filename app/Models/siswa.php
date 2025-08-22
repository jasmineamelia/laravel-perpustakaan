<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $table = 'siswa';

        protected $primarykey = 'id';

        public $timestamps = null;

    
    protected $fillable =['id','nama_siswa','tanggal_lahir','gender','alamat', 'id_kelas'];
}