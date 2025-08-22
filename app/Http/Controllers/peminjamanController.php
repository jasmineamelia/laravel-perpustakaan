<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Tambah peminjaman baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'id_buku' => 'required|integer|exists:buku,id_buku',
            'qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $tenggat = Carbon::parse($request->tanggal_pinjam)->addDays(4);

        $peminjaman = Peminjaman::create([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $tenggat,
            'status' => 'Dipinjam',
        ]);

        if ($peminjaman) {
            $detail = DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id,
                'id_buku' => $request->id_buku,
                'qty' => $request->qty,
            ]);

            if (!$detail) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal Menambah Detail Peminjaman'
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Sukses Menambah Peminjaman',
                'data' => $peminjaman
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Menambah Peminjaman'
            ], 500);
        }
    }

    // Menampilkan semua data peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with('detailPeminjaman.buku')->get();

        $data = $peminjamans->map(function ($item) {
            return [
                'id' => $item->id,
                'id_siswa' => $item->id_siswa,
                'tanggal_pinjam' => $item->tanggal_pinjam,
                'tanggal_kembali' => $item->tanggal_kembali,
                'status' => $item->status,
                'detail' => $item->detailPeminjaman->map(function ($detail) {
                    return [
                        'id_buku' => $detail->id_buku,
                        'judul_buku' => $detail->buku->judul ?? null,
                        'qty' => $detail->qty,
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // Menampilkan peminjaman berdasarkan ID
    public function show($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.buku')->find($id);

        if (!$peminjaman) {
            return response()->json([
                'status' => false,
                'message' => 'Peminjaman tidak ditemukan'
            ], 404);
        }

        $data = [
            'id' => $peminjaman->id,
            'id_siswa' => $peminjaman->id_siswa,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
            'status' => $peminjaman->status,
            'detail' => $peminjaman->detailPeminjaman->map(function ($detail) {
                return [
                    'id_buku' => $detail->id_buku,
                    'judul_buku' => $detail->buku->judul ?? null,
                    'qty' => $detail->qty,
                ];
            }),
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // Mengupdate peminjaman berdasarkan ID
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'status' => false,
                'message' => 'Peminjaman tidak ditemukan'
            ], 404);
        }

        $peminjaman->update([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => Carbon::parse($request->tanggal_pinjam)->addDays(4),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil diperbarui',
            'data' => $peminjaman
        ]);
    }

    // Menghapus data peminjaman
    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'status' => false,
                'message' => 'Peminjaman tidak ditemukan'
            ], 404);
        }

        DetailPeminjaman::where('id_peminjaman', $peminjaman->id)->delete();
        $peminjaman->delete();

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil dihapus'
        ]);
    }
}
