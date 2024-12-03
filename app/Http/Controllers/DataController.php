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

                if( Auth::user()->id == 1 ){
                    $data = Orders::where("status", "ACTIVE")
                        ->orderBy("id", "desc")
                        ->get();

                } else {
                    $data = Orders::where("user_id", Auth::user()->id )
                        ->where("status", "ACTIVE")
                        ->orderBy("id", "desc")
                        ->get();

                }

                break;

            case "orders":

                if( Auth::user()->id == 1 ){

                    $data = Orders::whereNot("status", "ACTIVE")
                        ->orderBy("id", "desc")
                        ->get();

                } else {
                    
                    $data = Orders::where("user_id", Auth::user()->id )
                        ->whereNot("status", "ACTIVE")
                        ->orderBy("id", "desc")
                        ->get();

                }

                break;

            case "queued":

                if( Auth::user()->id == 1 ){
                    $data = Scraper::whereIn("status", array("QUEUED","RUNNING"))
                        ->get();
                } else {
                    $data = Scraper::whereIn("status", array("QUEUED","RUNNING"))
                        ->where("user_id", Auth::user()->id )
                        ->get();

                }
                break;

            case "scraped":

                if( Auth::user()->id == 1 ){

                    $data = DB::table("view_scraper")
                        ->whereIn("status", array("PROCESSED"))
                        ->orderBy("order_id", "desc")
                        ->get();

                } else {

                    $data = DB::table("view_scraper")
                        ->whereIn("status", array("PROCESSED"))
                        ->where("user_id", Auth::user()->id )
                        ->orderBy("order_id", "desc")
                        ->get();

                }

                break;

            case "failed":

                if( Auth::user()->id == 1 ){

                    $data = DB::table("view_scraper")
                        ->whereIn("status", array("ERROR"))
                        ->orderBy("order_id", "desc")
                        ->get();

                } else {
                    $data = DB::table("view_scraper")
                        ->whereIn("status", array("ERROR"))
                        ->where("user_id", Auth::user()->id )
                        ->orderBy("order_id", "desc")
                        ->get();

                }
                break;

            case "noimage":

                
                $data = DB::table("view_scraper")
                    ->where(function ($query){
                        $query->where("certImgFront", "https://5starcards.com/wp-content/uploads/2023/09/5-star-cards-logo.png")
                                ->orWhere("certImgBack", "https://5starcards.com/wp-content/uploads/2023/09/5-star-cards-logo.png");
                    })
                    ->orderBy("order_id", "desc")
                    ->get();

                break;

            default:

                $data= [];
                break;
        }

        return $data;

    }

    function download($order_id){

        return view( "download", ["order_id" => $order_id] );

    }

    function data_post( Request $request ){

        switch( $request->action ){

            case "post_items":

                return $this->postItems($request);
                break;

            case "order_cards":

                if( Auth::user()->id == 1 ) {
                    $data = DB::table("view_scraper")
                        ->where("order_id", $request->order_id)
                        ->get();

                } else {
                    $data = DB::table("view_scraper")
                        ->where("order_id", $request->order_id)
                        ->where("user_id", Auth::user()->id )
                        ->get();

                }


                return $data;
                break;

            case "order_downloaded":
                return $this->orderDownloaded( $request->order_id );
                break;

            case "requeue":
                return $this->requeue( $request );
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
        $scrapers = Scraper::where("order_id",$scraper->order_id)
                    ->where("status","QUEUED")
                    ->get();

        if( count($scrapers) == 0 ){

            $order = Orders::find( $scraper->order_id );
            $order->status = "PROCESSED";
            $order->save();

        }

    }

    function orderDownloaded( $order_id ){

        $order = Orders::find($order_id );

        $order->status = "DOWNLOADED";

        $order->save();

        return true;

    }

    function requeue( $request) {

        DB::table("certificates")
            ->where("certificate_number", $request->certificate_number)
            ->delete();
        
        DB::table("scrapers")
            ->where("certificate_number", $request->certificate_number)
            ->update([
                "status" => 'QUEUED'
            ]);

        return ["error" => false, "request" => $request ];

    }


}
