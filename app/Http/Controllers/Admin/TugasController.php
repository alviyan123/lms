<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Tugas;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Admin;
use App\Models\Master\JadwalKuliah;
use Storage;


class TugasController extends Controller
{
    
    public function index() {
        return view('admin.tugas.view');
    }

    public function data(Request $request) {
        //PESERTA
        if(Auth::user()->role ==4){
            $result = DB::table('sys_tr_tugas AS a')
                        ->select(DB::raw('a.id,b.name AS name_siswa,c.name,c.teach_date_from,c.deadline_date,a.value,d.name AS name_dosen,c.weekend_to,
                                        CASE
                                            WHEN a.uploaded = 0 THEN "BELUM UPLOAD TUGAS"
                                            WHEN a.uploaded = 3 THEN "SUDAH UPLOAD TUGAS"
                                            WHEN a.uploaded = 2 THEN "TELAT UPLOAD DAN SEDANG DIVALIDASI"
                                            WHEN a.uploaded = 1 THEN "SEDANG DIVALIDASI" 
                                        END AS uploaded,a.patch_upload,a.is_value,a.value,c.is_refleksi'))
                        ->join('sys_ms_admins AS b', 'a.user_id', '=', 'b.id')
                        ->join('sys_ms_jadwal_kuliah AS c', 'a.jadwal_id', '=', 'c.id')
                        ->join('sys_ms_admins AS d', 'c.dosen_id', '=', 'd.id')
                        ->orderBy('a.created_at','DESC')
                        ->where([['a.deleted',0],['a.user_id',Auth::user()->id]])
                        ->get();
        }else if(Auth::user()->role ==3){
            $result = DB::table('sys_tr_tugas AS a')
                        ->select(DB::raw('a.id,b.name AS name_siswa,c.name,c.teach_date_from,c.deadline_date,a.value,d.name AS name_dosen,c.weekend_to,
                                        CASE
                                            WHEN a.uploaded =  0 THEN "BELUM UPLOAD TUGAS"
                                            WHEN a.uploaded = 3 THEN "SUDAH UPLOAD TUGAS"
                                            WHEN a.uploaded = 2 THEN "TELAT UPLOAD DAN SEDANG DIVALIDASI"
                                            WHEN a.uploaded = 1 THEN "SEDANG DIVALIDASI" 
                                        END AS uploaded,a.patch_upload,a.is_value,a.value,c.is_refleksi'))
                        ->join('sys_ms_admins AS b', 'a.user_id', '=', 'b.id')
                        ->join('sys_ms_jadwal_kuliah AS c', 'a.jadwal_id', '=', 'c.id')
                        ->join('sys_ms_admins AS d', 'c.dosen_id', '=', 'd.id')
                        ->join('sys_ms_admins AS e', 'b.mentor_id', '=', 'e.id')
                        ->orderBy('a.created_at','DESC')
                        ->where([['a.deleted',0],['e.id',Auth::user()->id]])
                        ->get();
        }else{
            $result = DB::table('sys_tr_tugas AS a')
                        ->select(DB::raw('a.id,b.name AS name_siswa,c.name,c.teach_date_from,c.deadline_date,a.value,d.name AS name_dosen,c.weekend_to,
                                        CASE
                                            WHEN a.uploaded =  0 THEN "BELUM UPLOAD TUGAS"
                                            WHEN a.uploaded = 3 THEN "SUDAH UPLOAD TUGAS"
                                            WHEN a.uploaded = 2 THEN "TELAT UPLOAD DAN SEDANG DIVALIDASI"
                                            WHEN a.uploaded = 1 THEN "SEDANG DIVALIDASI" 
                                        END AS uploaded,a.patch_upload,a.is_value,a.value,c.is_refleksi'))
                        ->join('sys_ms_admins AS b', 'a.user_id', '=', 'b.id')
                        ->join('sys_ms_jadwal_kuliah AS c', 'a.jadwal_id', '=', 'c.id')
                        ->join('sys_ms_admins AS d', 'c.dosen_id', '=', 'd.id')
                        ->orderBy('a.created_at','DESC')
                        ->where('a.deleted',0)
                        ->get();
        }
        return response()->json($result);
    }

    public function upload(Request $request) {

        $tugas =  DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->first(); 
        $user =  Admin::where('id',$tugas->user_id)->first(); 

        $matkul =  JadwalKuliah::where([['deleted',0],['id',$tugas->jadwal_id]])->first(); 
        $newName = str_replace(' ', '_', $user->name);
        $exFile = $request->patch_upload->getClientOriginalExtension();
        $newDate = substr($matkul->teach_date_from,0,10);
        $patch = 'tugas/'.$newName;
        $fileName = $newName.'_'.$matkul->id.'_'.$newDate.'_'.$tugas->id.'.'.$exFile;
        $stsStorage  = Storage::disk('local')->putFileAs(
            $patch,
            $request->patch_upload,
            $fileName
        );    
        if($matkul->deadline_date <= Carbon::now()){
            //TELAT
            $uploaded = 2;
        }else{
            $uploaded = 1;
        }

        $data = [
            'patch_upload'=>'/'.$patch.'/'.$fileName,
            'tgl_upload' => Carbon::now(),
            'uploaded' => $uploaded
        ];
        $savingTugas =  DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->update($data);
        if($savingTugas == true){
            return response()->json(["success" => true,"message" => "Data Berhasil Diupload"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Diupload"]);
        };
        
    }

    public function download(Request $request) {
        $tugas =  DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->first();
        $newFile = str_replace('/', "~\~", $tugas->patch_upload);
        $fixFile = str_replace("~", "", $newFile);
        $pathToFile = storage_path('app' . $fixFile);
        return Storage::disk('local')->download($tugas->patch_upload);
    }
    
    public function nilai(Request $request) {
        $tugas = DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->first();
        if ($tugas->uploaded ==2) {
            $valueUpload = 2;
        } else {
            $valueUpload = 3;
        }
        
        $data = [
            'value' => $request->value,
            'is_value' => 1,
            'uploaded' => $valueUpload
        ];
        $result = DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->update($data);
        if($result == true){
            return response()->json(["success" => true,"message" => "Data Berhasil Dinilai"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Dinilai"]);
        };
    }

    public function tugasPost(Request $request) {
        $tugas =  DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->first(); 
        $user =  Admin::where('id',$tugas->user_id)->first(); 

        $matkul =  JadwalKuliah::where([['deleted',0],['id',$tugas->jadwal_id]])->first(); 
        if($matkul->deadline_date <= Carbon::now()){
            //TELAT
            $uploaded = 2;
        }else{
            $uploaded = 1;
        }
        $data = $request->all();
        $updated_at = ['updated_at' => Carbon::now(),'tgl_upload'=>Carbon::now(),'uploaded'=>$uploaded];
        $data = array_merge($data, $updated_at);
        $result = DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->update($data);
        if($result == true){
            return response()->json(["success" => true,"message" => "Data Berhasil Dinilai"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Dinilai"]);
        };
    }

    
    public function jawabEdit(Request $request) {
        $result =  DB::table('sys_tr_tugas')->where([['deleted',0],['id',$request->id]])->first();
        return response()->json($result);
    }
}
