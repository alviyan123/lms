<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\JadwalKuliah;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Admin;

class JadwalController extends Controller
{
    
    public function index() {
        return view('admin.masterJadwal.view');
    }

    public function data(Request $request) {
        if(Auth::user()->role ==1 || Auth::user()->role ==2 ){
            $result = DB::table('sys_ms_jadwal_kuliah AS a')
                    ->select(DB::raw("a.generated,a.id,a.name,a.teach_date_from,a.teach_date_to,a.deadline_date,b.name AS dosen_name"))
                    ->leftJoin('sys_ms_admins AS b', 'a.dosen_id', '=', 'b.id')
                    ->orderBy('a.created_at','DESC')
                    ->where('a.deleted',0)
                    ->get();
        }else{
            $result = null;
        }
        return response()->json($result);
    }

    public function edit(Request $request) {
        $result = JadwalKuliah::where([['deleted',0],['id',$request->id]])->first();
        return response()->json($result);
    }

    public function save(Request $request) {
            $data = $request->all();
            $data['teach_date_from'] = Carbon::parse($request->teach_date_from);
            $data['teach_date_to'] = Carbon::parse($request->teach_date_to);
            $data['deadline_date'] = Carbon::parse($request->deadline_date);
        if($request->id == null){
            $data['public_id'] = Uuid::generate(4)->string;
            unset($data['id']);
            $result = JadwalKuliah::create($data);
            if($result == true){
                return response()->json(["success" => true,"message" => "Data Jadwal Berhasil Ditambah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data Jadwal Gagal Ditambah"]);
            };
        }else{
            $result = JadwalKuliah::where([['deleted',0],['id',$request->id]])->update($data);
            if($result == true){
                return response()->json(["success" => true,"message" => "Data Jadwal Berhasil Diubah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data Jadwal Gagal Diubah  "]);
            };
        }
    }

    public function delete(Request $request) {
        $result1 = JadwalKuliah::where([['deleted',0],['id',$request->id]])->update(['deleted'=>1]); 
        DB::table('sys_tr_tugas')->where([['deleted',0],['jadwal_id',$request->id]])->update(['deleted'=>1]);       
        if($result1 == true){
            return response()->json(["success" => true,"message" => "Data Berhasil DiHapus"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal DiHapus"]);
        };
    }
    
    public function generate(Request $request) {
        $users = Admin::where([['deleted',0],['role',4]])->get(); 
        if($users == null){
            return response()->json(["success" => false,"message" => "Belum Ada Peserta"]);
        }
        $jadwal = JadwalKuliah::where([['deleted',0],['id',$request->id]])->first();
        foreach ($users as $row) 
        {
            $menu =  array();
            $menu[] = array(
                'public_id' => Uuid::generate(4)->string,
                'user_id' => $row['id'],
                'jadwal_id' => $jadwal->id,
                'value' => 0,
            );
            $result =  DB::table('sys_tr_tugas')->insert($menu);
        }       
        if($result == true){
            JadwalKuliah::where([['deleted',0],['id',$request->id]])->update(['generated'=>1]);
            return response()->json(["success" => true,"message" => "Data Berhasil Generate"]);
        }else{
            return response()->json(["success" => false,"message" => "Data Gagal Generate"]);
        };
    }
}
