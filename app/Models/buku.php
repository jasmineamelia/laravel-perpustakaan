<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi
    protected $table = 'buku';

    // Tentukan kolom primary key
    protected $primaryKey = 'id_buku'; // Perbaiki 'primarykey' menjadi 'primaryKey'

    // Nonaktifkan fitur timestamps jika tabel tidak memiliki kolom 'created_at' dan 'updated_at'
    public $timestamps = false;

    // Tentukan kolom yang dapat diisi mass-assignment
    protected $fillable = ['judul_buku', 'penulis', 'penerbit', 'kategori','foto'];

}