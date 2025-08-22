<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('udul_buku'); // Kolom untuk judul buku
            $table->string('penulis'); // Kolom untuk penulis
            $table->string('penerbit'); // Kolom untuk penerbit
            $table->string('kategori'); // Kolom untuk kategori
            $table->string('foto')->nullable(); // Kolom untuk path foto, boleh null
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
}