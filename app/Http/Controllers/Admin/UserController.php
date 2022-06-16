<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use Webpatser\Uuid\Uuid;

class UserController extends Controller
{
    
    public function index() {
        // dd(Auth::user());
        return view('admin.user.view');
    }

    public function data(Request $request) {
        if(Auth::user()->role ==1){
            $result = Admin::select('id','name','username','phone','envoy','address','generation',
                                    DB::raw('(CASE WHEN role = 1 THEN "SUPERADMIN"
                                                WHEN role = 2 THEN "PANITIA"
                                                WHEN role = 3 THEN "DOSEN"
                                                ELSE "PESERTA" 
                                               END) AS role'))->where('deleted',0)->get();
        }else if(Auth::user()->role ==2){
            $result = Admin::select('id','name','username','phone','envoy','address','generation',
                                    DB::raw('(CASE WHEN role = 1 THEN "SUPERADMIN"
                                                WHEN role = 2 THEN "PANITIA"
                                                WHEN role = 3 THEN "DOSEN"
                                                ELSE "PESERTA" 
                                            END) AS role'))->where([['deleted',0],['role','!=',1]])->get();
        }else{
            $result = Admin::select('id','name','username','phone','envoy','address','generation',
                                    DB::raw('(CASE WHEN role = 1 THEN "SUPERADMIN"
                                                WHEN role = 2 THEN "PANITIA"
                                                WHEN role = 3 THEN "DOSEN"
                                                ELSE "PESERTA" 
                                            END) AS role'))->where('id',Auth::user()->id)->get();
        }
        return response()->json($result);
    }

    public function edit(Request $request) {
        $result = Admin::where([['deleted',0],['id',$request->id]])->first();
        return response()->json($result);
    }

    public function save(Request $request) {
        if($request->id == null){
            $data = $request->all();
            $data['public_id'] = Uuid::generate(4)->string;
            unset($data['id']);
            $password = ['password' => Hash::make(123)];
            $data = array_merge($data, $password);
            $result = Admin::create($data);
            if($result == true){
                return response()->json(["success" => true,"message" => "Data User Berhasil Ditambah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data User Gagal Ditambah"]);
            };
        }else{
            if (!$request->passwordConfirm) {
                $result = Admin::where([['deleted',0],['id',$request->id]])->update($request->all());
            }else{
                if($request->password == $request->passwordConfirm){
                    $result = Admin::where([['deleted',0],['id',$request->id]])->update(['password'=>Hash::make($request->password)]);
                }else{
                    return response()->json(["success" => false,"message" => "Password Tidak Sama !"]);
                }
            }
            
            if($result == true){
                return response()->json(["success" => true,"message" => "Data User Berhasil Diubah"]);
            }else{
                return response()->json(["success" => false,"message" => "Data User Gagal Diubah"]);
            };
        }
    }

    public function delete(Request $request) {
        $result = Admin::where([['deleted',0],['id',$request->id]])->update(['deleted'=>1]);        
        if($result == true){
            return response()->json(["success" => true,"message" => "Data User Berhasil DiHapus"]);
        }else{
            return response()->json(["success" => false,"message" => "Data User Gagal DiHapus"]);
        };
    }
    
}
