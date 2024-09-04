<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Scraper;
use App\Models\Orders;
use App\Models\Certificate;

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

            case "queued":

                $data = Scraper::whereIn("status", array("QUEUED","RUNNING"))
                            ->where("user_id", Auth::user()->id )
                            ->get();
                break;

            case "scraped":

                $data = DB::table("view_scraper")
                            ->whereIn("status", array("PROCESSED"))
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

            case "post_items":

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


        if( $order->id > 0 ){

            foreach( $certificates as $certificate ){

                $scrape = new Scraper;

                $scrape->order_id =$order->id;
                $scrape->user_id = Auth::user()->id;
                $scrape->certificate_number = $certificate;
                $scrape->status = "QUEUED";

                $scrape->save();

            }

        } else {
            return ["error" => true, "message" => "ORDER NOT CREATED"];
        }

        return ["error" => false, "filename" => $request->filename, "certificates" => $certificates, "user_id" => $request->user_id, "order" => $order];

    }

    function cardUpdate($card_id, $status){

        $scraper = Scraper::find($card_id );
        $scraper->status = $status;
        $scraper->save();

        // UPDATE ORDER
        $scrapers = Scraper::find($scraper->order_id)
                        ->where("status","ACTIVE")
                        ->count();

        if( $scrapers == 0 ){

            $order = Orders::find( $scraper->order_id );
            $order->status = "PROCESSED";
            $order->save();

        }

    }

    function api_test(){
        return "test";

    }
}
