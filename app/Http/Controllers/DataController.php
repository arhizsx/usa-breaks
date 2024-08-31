<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{

    function data( $action) {

        $data = DB::table("users")->get();

        return $data;

    }

}
