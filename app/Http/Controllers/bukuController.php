<?php

namespace App\Http\Controllers;

use App\Models\buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bukuController extends Controller
{
    // Menambahkan buku
   // Menambahkan buku
public function createbuku(Request $req)
{
    $validator = Validator::make($req->all(), [
        'judul_buku' => 'required',
        'penulis'    => 'required',
        'penerbit'   => 'required',
        'kategori'   => 'required',
        'foto'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
    }

    try {
        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Simpan file foto
        $fotoUrl = null;
        if ($req->hasFile('foto')) {
            $file = $req->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fotoName);
            // Simpan URL absolut
            $fotoUrl = url('uploads/' . $fotoName);
        } else {
            return response()->json(['status' => false, 'message' => 'File foto tidak diterima'], 400);
        }

        // Simpan data ke database
        $buku = buku::create([
            'judul_buku' => $req->judul_buku,
            'penulis'    => $req->penulis,
            'penerbit'   => $req->penerbit,
            'kategori'   => $req->kategori,
            'foto'       => $fotoUrl,
        ]);

        return response()->json(['status' => true, 'message' => 'Sukses menambahkan buku', 'data' => $buku], 201);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Gagal menambahkan buku: ' . $e->getMessage()], 500);
    }
}


    // Fungsi untuk mengupdate data buku beserta upload foto baru (jika ada)
    // Fungsi untuk mengupdate data buku beserta upload foto baru (jika ada)
public function updatebuku(Request $req, $id_buku)
{
    $validator = Validator::make($req->all(), [
        'judul_buku' => 'required',
        'penulis'    => 'required',
        'penerbit'   => 'required',
        'kategori'   => 'required',
        'foto'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400);
    }

    $buku = buku::find($id_buku);
    if (!$buku) {
        return response()->json(['status' => false, 'message' => 'Buku tidak ditemukan'], 404);
    }

    // Data untuk update
    $dataUpdate = [
        'judul_buku' => $req->get('judul_buku'),
        'penulis'    => $req->get('penulis'),
        'penerbit'   => $req->get('penerbit'),
        'kategori'   => $req->get('kategori'),
    ];

    // Cek jika ada file foto yang diupload
    if ($req->hasFile('foto')) {
        $file     = $req->file('foto');
        $fotoName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fotoName);
        // Simpan URL absolut
        $dataUpdate['foto'] = url('uploads/' . $fotoName);
    }

    $ubah = $buku->update($dataUpdate);

    if ($ubah) {
        return response()->json(['status' => true, 'message' => 'Sukses update buku']);
    } else {
        return response()->json(['status' => false, 'message' => 'Gagal mengupdate buku'], 500);
    }
}


    // Fungsi untuk mendapatkan detail buku berdasarkan ID
    public function getbukuById($id_buku)
    {
        $buku = buku::find($id_buku);
        if ($buku) {
            return response()->json(['status' => true, 'data' => $buku]);
        } else {
            return response()->json(['status' => false, 'message' => 'Buku tidak ditemukan'], 404);
        }
    }

    // Fungsi untuk menghapus buku
    public function deletebuku($id_buku)
    {
        $buku = buku::find($id_buku);

        if ($buku) {
            $buku->delete();
            return response()->json(['status' => true, 'message' => 'Buku berhasil dihapus']);
        } else {
            return response()->json(['status' => false, 'message' => 'Buku tidak ditemukan'], 404);
        }
    }

    // Fungsi untuk mendapatkan semua buku
    public function getAllbuku()
    {
        $buku = buku::all();
        return response()->json(['status' => true, 'data' => $buku], 200);
    }
}
