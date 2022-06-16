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


class MicroLearningController extends Controller
{
    
    public function index() {
        return view('admin.microLearning.view');
    }

    public function data(Request $request) {
        $result = DB::table('tr_ms_micro_teach AS a')->get();
        return response()->json($result);
    }
}
