<?php

namespace App\Http\Controllers;

use App\Models\pengembalian;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pengembalianController extends Controller
{
    public function pengembalian($id)
    {
        $tgl_kembali = Carbon::now();
                     $peminjaman = pengembalian::find($id);

                     if (!$peminjaman){
                        return response()->json(['status' => false, 'message' => 'peminjaman tidak ditemukan']);

                     }
                     $tenggat = Carbon::parse($peminjaman->tenggat);
                     $denda =0;

                     //hitung denda jika tanggal pengembalian melebihi tenggat waktu
                    if ($tgl_kembali->greaterThan($tenggat)) {
                        $dayslate = $tgl_kembali->diffInDays($tenggat);
                        $denda = $dayslate * 1000; //contoh aja 1000 per hari keterlambatan
                    }

                    //tambahkan catatan pengembalian ke tabel pengembalian
                    $pengembalian = pengembalian::create([
                        'id_peminjaman' => $peminjaman->id,
                        'tgl_kembali' => $tgl_kembali->format('Y-m-d H:i:s'), //pastikan formatnya sesuai dengan tipe data di database
                        'status' => 'kembali',
                        'denda' => $denda
                    ]);

                    if($pengembalian){
                        return response()->json(['status' => true, 'mesage' => 'sukses pengembalian buku', 'denda' => $denda ]);

                    }else{
                        return response()->json(['status' => false, 'mesage' => 'Gagal menambahkan data pengembalian']);
                    }
                }

                public function getALLpengembalian()
                {
                    $pengembalian = pengembalian::all();

                    return response()->json(['status' => true, 'data' => $pengembalian ]);

                }

                //FUNGSI mendapatkan detail buku berdasarkan ID
                public function getpengembalianByid($id)
{
    $pengembalian = pengembalian::find($id); // Temukan data pengembalian berdasarkan ID

    if ($pengembalian) {
        return response()->json(['status' => true, 'data' => $pengembalian]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }
}}