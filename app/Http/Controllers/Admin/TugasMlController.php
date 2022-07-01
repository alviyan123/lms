<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Admin;
use Storage;
use App\Models\Master\MicroLearning;


class TugasMlController extends Controller
{
    
    public function index() {
        return view('admin.tugasMl.view');
    }

    public function data(Request $request) {
        if(Auth::user()->role ==4){
            $result = DB::table('sys_tr_tugas_ml AS a')
            ->select(DB::raw('a.id,b.name AS name_jadwal,c.name,b.teach_date_from,b.deadline_date,a.value,a.is_value,d.name AS name_mentor,a.uploaded'))
            ->join('sys_ms_jadwal_ml AS b','a.jadwal_id','=', 'b.id')
            ->join('sys_ms_admins AS c', 'a.user_id', '=', 'c.id')
            ->join('sys_ms_admins AS d', 'c.mentor_id', '=', 'd.id')
            ->where([['a.user_id','=',Auth::user()->id],['a.deleted',0]])
            ->get();
        }else if(Auth::user()->role == 3){
            $result = DB::table('sys_tr_tugas_ml AS a')
            ->select(DB::raw('a.id,b.name AS name_jadwal,c.name,b.teach_date_from,b.deadline_date,a.value,a.is_value,d.name AS name_mentor,a.uploaded'))
            ->join('sys_ms_jadwal_ml AS b','a.jadwal_id','=', 'b.id')
            ->join('sys_ms_admins AS c', 'a.user_id', '=', 'c.id')
            ->join('sys_ms_admins AS d', 'c.mentor_id', '=', 'd.id')
            ->where([['c.mentor_id','=',Auth::user()->id],['a.deleted',0]])
            ->get();
        }else {
            $result = DB::table('sys_tr_tugas_ml AS a')
            ->select(DB::raw('a.id,b.name AS name_jadwal,c.name,b.teach_date_from,b.deadline_date,a.value,a.is_value,d.name AS name_mentor,a.uploaded'))
            ->join('sys_ms_jadwal_ml AS b','a.jadwal_id','=', 'b.id')
            ->join('sys_ms_admins AS c', 'a.user_id', '=', 'c.id')
            ->join('sys_ms_admins AS d', 'c.mentor_id', '=', 'd.id')
            ->where('a.deleted',0)
            ->get();
        }
        return response()->json($result);
    }

    public function detail($action,$id) {
        $result = DB::table('sys_tr_tugas_ml AS a')
                ->select(DB::raw('a.id,b.soal,a.jawaban'))
                ->join('sys_ms_jadwal_ml AS b','a.jadwal_id','=', 'b.id')
                ->where('a.id', $id)
                ->first();
        return view('admin.tugasMl.detail',compact('result','action'));
    }

    public function jawaban(Request $request) {
        $tugas =  DB::table('sys_tr_tugas_ml')->where([['deleted',0],['id',$request->id]])->first(); 
        $matkul =  MicroLearning::where([['deleted',0],['id',$tugas->jadwal_id]])->first(); 
        if($matkul->deadline_date <= Carbon::now()){
            //TELAT
            $uploaded = 2;
        }else{
            $uploaded = 1;
        }
        $data = [
            'jawaban' => $request->jawaban,
            'tgl_upload' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'uploaded' => $uploaded
        ];
        $result = DB::table('sys_tr_tugas_ml AS a')->where('id',$request->id)->update($data);
        if($result == true){
            return response()->json(["success" => true,"message" => "Data Berhasil Dijawab"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Dijawab"]);
        };    
    }
    public function nilai(Request $request) {
        $tugas =  DB::table('sys_tr_tugas_ml')->where([['deleted',0],['id',$request->id]])->first(); 
        $matkul =  MicroLearning::where([['deleted',0],['id',$tugas->jadwal_id]])->first(); 
        $data = [
            'value' => $request->value,
            'is_value' => 1
        ];
        $result = DB::table('sys_tr_tugas_ml AS a')->where('id',$request->id)->update($data);
        if($result == true){
            return response()->json(["success" => true,"message" => "Data Berhasil Dinilai"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Dinilai"]);
        };    
    }
}
