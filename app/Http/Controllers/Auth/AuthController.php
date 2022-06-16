<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use Session;
use Webpatser\Uuid\Uuid;

class AuthController extends Controller
{

    public function index() {
        return view('auth.view');
    }

    public function doAuth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [ 'error' => ["message" => $validator->messages()->first()] ];
            return response()->json($response, 401);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        $exist = Admin::where([['username', $request->username],['deleted',0]])->first();
        if(!$exist){
            $response = [ 'error' => ["message" => "Invalid username, please try again."] ];
            return response()->json($response, 401);
        }
        if(Auth::attempt($credentials)){
            $response = [ 'success' => ["message" => "Authentication successfully."] ];
            return response()->json($response, 200);
        }else{
            $response = [ 'error' => ["message" => "Invalid username or password, please try again."] ];
            return response()->json($response, 401);
        }
    }
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('');
    }
}
