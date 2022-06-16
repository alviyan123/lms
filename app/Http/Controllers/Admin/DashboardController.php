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
use Carbon\Carbon;
use App\Models\Master\JadwalKuliah;

class DashboardController extends Controller
{
    public function index() {
        $jadwal =  DB::table('sys_ms_jadwal_kuliah AS a')
                    ->select(DB::raw("a.id,a.name,a.teach_date_from,b.name AS dosen_name"))
                    ->leftJoin('sys_ms_admins AS b', 'a.dosen_id', '=', 'b.id')
                    ->where('a.is_display',1)
                    ->get();
        return view('admin.dashboard.view',['jadwal' => $jadwal]);
    }
    
}
