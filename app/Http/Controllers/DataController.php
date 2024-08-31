<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Scraper;

class DataController extends Controller
{

    function data( $action) {

        $data = Scraper::where("status", "SCHEDULED")->get();

        return $data;

    }

}
