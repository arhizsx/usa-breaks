<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Scraper;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{

    function data( $action) {

        switch( $action ){

            case "orders_active":

                $data = Orders::where("user_id", Auth::user()->id )
                            ->where("status", "ACTIVE")
                            ->orderBy("id", "desc")
                            ->get();
                break;

            case "orders":

                $data = Orders::where("user_id", Auth::user()->id )
                            ->whereNot("status", "ACTIVE")
                            ->orderBy("id", "desc")
                            ->get();
                break;

            case "scheduled":

                $data = Scraper::where("status", "QUEUED")
                            ->where("user_id", Auth::user()->id )
                            ->get();
                break;

            case "scraped":

                $data = Scraper::where("status", "PROCESSED")
                            ->where("user_id", Auth::user()->id )
                            ->get();
                break;

            default:

                $data= [];
                break;
        }

        return $data;

    }

    function data_post( Request $request ){

        switch( $request->action ){
            case "post_items";
                return $this->postItems($request);
                break;
            default:
                return ["error"=> true, "message" => "Action not configured"];
        }


        return $request;
    }

    function postItems($request){

        $certificates = preg_split("/\r\n|\n|\r/", $request->certificate_numbers);

        $order = new Orders;

        $order->user_id = Auth::user()->id;
        $order->filename = $request->filename . ".zip";
        $order->certificates = count( $certificates );
        $order->status = "ACTIVE";

        $order->save();


        if( property_exists($order, "id") ){


            return $order;

            foreach( $certificates as $certificate ){

                $scrape = new Scraper;

                $scrape->user_id = Auth::user()->id;
                $scrape->certificate_number = $certificate;
                $scrape->status = "QUEUED";

            }

        }

        return ["error" => false, "filename" => $request->filename, "certificates" => $certificates, "user_id" => $request->user_id, "order" => $order];

    }

}
