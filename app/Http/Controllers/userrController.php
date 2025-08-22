<?php

namespace App\Http\Controllers;

use App\Models\userr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userrController extends Controller
{
    public function createuser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_buku' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        $save = userr1::create($req->all());

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses menambahkan userr']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan userr']);
        }
    }

    public function updateuserr(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'id_buku' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        $ubah = userr1::where('id', $id)->update($req->all());

        if ($ubah) {
            return response()->json(['status'=> true, 'message'=> 'Sukses update userr']);
        } else {
            return response()->json(['status'=> false, 'message'=> 'Gagal mengupdate userr']);
        }
    }

    // Fungsi mendapatkan detail user berdasarkan ID
    public function getuserrById($id)
    {
        $userr = userr1::find($id);

        if ($userr) {
            return response()->json(['status' => true, 'data' => $userr]);
        } else {
            return response()->json(['status' => false, 'message' => 'User tidak ditemukan']);
        }
    }

    // Fungsi menghapus user
    public function deleteuserr($id)
    {
        $userr = userr1::find($id);

        if ($userr) {
            $userr->delete();
            return response()->json(['status' => true, 'message' => 'User berhasil dihapus']);
        } else {
            return response()->json(['status' => false, 'message' => 'User tidak ditemukan']);
        }
    }

    // Fungsi mendapatkan semua user
    public function userrAll()
    {
        $userr = userr1::all();

        if ($userr->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Tidak ada data user']);
        }

        return response()->json(['status' => true, 'data' => $userr]);
    }
}
