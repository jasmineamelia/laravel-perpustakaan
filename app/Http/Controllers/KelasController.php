<?php
namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class kelasController extends Controller
{
    public function createkelas(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'nama_kelas'=>'required',
            'kelompok'=>'required',
           
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = kelas::create ([
            'nama_kelas'    =>$req->get('nama_kelas'),
            'kelompok'        =>$req->get('kelompok'),
           
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' => 'Sukses menambah siswa']);
        }else {
            return Response()->json(['status'=>false, 'message' => 'Gagal menambah siswa']);
        }
    }
   
}