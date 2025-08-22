<?php

namespace App\Http\Controllers; 

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    // ✅ Tambah Siswa
    public function createSiswa(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'alamat' => 'required|string',
            'id_kelas' => 'required|integer',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = Siswa::create ([
            'nama_siswa'           =>$req->get('nama_siswa'),
            'tanggal_lahir'        =>$req->get('tanggal_lahir'),
            'gender'               =>$req->get('gender'),
            'alamat'               =>$req->get('alamat'),
            'id_kelas'             =>$req->get('id_kelas'),
           
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' => 'Sukses menambah siswa']);
        }else {
            return Response()->json(['status'=>false, 'message' => 'Gagal menambah siswa']);
        }
    }
   

    // ✅ Update Siswa
    public function updateSiswa(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'alamat' => 'required|string',
            'id_kelas' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json(['status' => false, 'message' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update($req->all());

        return response()->json(['status' => true, 'message' => 'Sukses update siswa', 'data' => $siswa], 200);
    }

    // ✅ Ambil Siswa berdasarkan ID
    public function getSiswaById($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['status' => false, 'message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $siswa], 200);
    }

    // ✅ Hapus Siswa
    public function deleteSiswa($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['status' => false, 'message' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->delete();

        return response()->json(['status' => true, 'message' => 'Siswa berhasil dihapus'], 200);
    }

    // ✅ Ambil Semua Siswa
    public function getAllSiswa()
    {
        $siswa = Siswa::all();

        return response()->json(['status' => true, 'data' => $siswa], 200);
    }
}

