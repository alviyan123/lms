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


class MicroLearningController extends Controller
{
    
    public function index() {
        return view('admin.microLearning.view');
    }

    public function data(Request $request) {
        $result = DB::table('sys_ms_jadwal_ml AS a')->get();
        return response()->json($result);
    }

    public function save(Request $request) {
        $data = $request->all();
        $data['teach_date_from'] = Carbon::parse($request->teach_date_from);
        $data['teach_date_to'] = Carbon::parse($request->teach_date_to);
        $data['deadline_date'] = Carbon::parse($request->deadline_date);

        if($request->id == null){
            $data['public_id'] = Uuid::generate(4)->string;
            unset($data['id_micro_learning']);
            $result = MicroLearning::create($data);
            if($result == true){
                return response()->json(["success" => true,"message" => "Data Jadwal Berhasil Ditambah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data Jadwal Gagal Ditambah"]);
            };
        }else{
            $result = DB::table('sys_ms_jadwal_ml AS a')->where([['deleted',0],['id',$request->id]])->update($data);
            if($result == true){
                return response()->json(["success" => true,"message" => "Data Jadwal Berhasil Diubah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data Jadwal Gagal Diubah  "]);
            };
        }
    }

    public function generate(Request $request) {
        $users = Admin::where([['deleted',0],['role',4]])->get(); 
        if($users == null){
            return response()->json(["success" => false,"message" => "Belum Ada Peserta"]);
        }
        $jadwal = MicroLearning::where([['deleted',0],['id',$request->id]])->first();
        foreach ($users as $row) 
        {
            $menu =  array();
            $menu[] = array(
                'public_id' => Uuid::generate(4)->string,
                'user_id' => $row['id'],
                'jadwal_id' => $jadwal->id,
                'value' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );
            $result =  DB::table('sys_tr_tugas_ml')->insert($menu);
        }       
        if($result == true){
            MicroLearning::where([['deleted',0],['id',$request->id]])->update(['generated'=>1]);
            return response()->json(["success" => true,"message" => "Data Berhasil Generate"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Generate"]);
        };
    }
}
