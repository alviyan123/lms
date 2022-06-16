<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Admin;

class ParameterLookupController extends Controller
{
    public function lookup(Request $request) 
    {
        if ($request->model == 'Dosen') 
        {
            $data = Admin::where([['deleted',0],['role',3]])->get();
            $parameter = array();
            foreach ($data as $row) 
            {
                $parameter[] = array(
                    'ID' => $row['id'],
                    'Name' =>$row['id'].' - '.$row['name']
                );
            }
            return $parameter;
        }

        if ($request->model == 'User') 
        {
            $data = Admin::where([['deleted',0],['role',4]])->get();
            $parameter = array();
            foreach ($data as $row) 
            {
                $parameter[] = array(
                    'ID' => $row['id'],
                    'Name' =>$row['id'].' - '.$row['name']
                );
            }
            return $parameter;
        }
    }
}