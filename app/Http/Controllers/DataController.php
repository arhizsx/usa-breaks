<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Scraper;

class DataController extends Controller
{

    function data( $action) {

        switch( $action ){

            case "orders":

                $data = Scraper::where("status", "SCHEDULED")->get();
                break;

            case "scheduled":

                $data = Scraper::where("status", "SCHEDULED")->get();
                break;

            case "scraped":

                $data = Scraper::where("status", "PROCESSED")->get();
                break;

            default:

                $data= [];
                break;
        }

        return $data;

    }

    function data_post( Request $request ){


        return $request;

    }


}
