<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $primarykey = 'id';
    public $timestamps = false;
    
    
    protected $filliable =[
            'nama_kelas','kelompok'
    ]; 
}