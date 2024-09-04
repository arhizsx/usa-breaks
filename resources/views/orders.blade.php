<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="container-fluid p-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div id="gridContainer"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<div class="modal fade" id="installation_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Order Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card_table">
                    <table class="table table-sm table-bordered table-striped cards_table_ajax">
                        <thead>
                            <tr>
                                <th>Certificate #</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="download_link text-center py-5">
                    <div class="p-3">
                        <i class="fas fa-circle-down fa-beat text-primary fa-9x" style="--fa-beat-scale: 1.2;"></i>
                    </div>
                    <div class="mt-5">
                        <a href="" class="download_link" data-order_id="" class="btn btn-xl btn-primary" style="background: blue; color:white; font-size: 1.2em; padding: 10px 20px 10px 20px; border-radius: 10px;">Download File</a>
                    </div>
                </div>
                <div class="loading text-center py-3">
                    <i class="fas fa-spinner fa-pulse fa-9x"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="d-none btn btn-primary download_zip_btn" data-order_id="">Download</button>
            </div>
        </div>
    </div>
</div>


<script>

    let x= "";
    let modal = "#installation_details";
    let datagrid = "#gridContainer";
    let datasource = '/data/orders';
    let columns = ['id', 'filename', 'certificates', 'status', 'created_at', 'updated_at'];
    let callback = 'callbackAction';

    $(() => {

        $(datagrid).setDatagrid( modal, datasource, columns, callback );

    });

    function callbackAction(data){

        let info = JSON.parse( JSON.stringify(data) );

        console.log(info);

        order_cards = orderCards( info.id );

        $(document).find(".download_zip_btn").removeClass("d-none");
        $(document).find(".card_table").addClass("d-none");
        $(document).find(".download_link").addClass("d-none");
        $(document).find(".loading").removeClass("d-none");
        $(document).find(".download_zip_btn").addClass("d-none");

        $.when( order_cards ).done( function( order_cards ){

            $(document).find(".card_table").removeClass("d-none");
            $(document).find(".download_link").addClass("d-none");
            $(document).find(".loading").addClass("d-none");

            $(document).find(".cards_table_ajax tbody").empty();

            $.each(order_cards, function(k,v){

                title = v["Year"] + " " +
                        v["Brand"] + " " +
                        v["Player"] + " " +
                        v["Card Number"] + " " +
                        v["Variety/Pedigree"] + " " +
                        v["Grade"];

                certificate_number = v["certificate_number"];

                $(document).find(".cards_table_ajax tbody").append(
                    "<tr>" +
                        "<td>" + certificate_number + "</td>" +
                        "<td>" + title + "</td>" +
                    "</tr>"
                );
            });


            $(document).find(".download_zip_btn").attr("data-order_id", info.id);
            $(document).find(".download_link").attr("data-order_id", info.id);

            $(document).find(".download_zip_btn").removeClass("d-none");

        });
    }

    function orderCards(order_id) {

        var defObject = $.Deferred();  // create a deferred object.

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: 'post',
            url: "/data/post",
            data: {
                action: "order_cards",
                order_id, order_id
            },
            success: function(resp){
                defObject.resolve(resp);    //resolve promise and pass the response.
            },
            error: function(){
                console.log("Error in AJAX");
            }
        });

        return defObject.promise();


    }

    $(document).on("click", ".download_zip_btn", function(e){

        e.preventDefault();

        $(document).find(".card_table").addClass("d-none");
        $(document).find(".download_link").addClass("d-none");
        $(document).find(".loading").removeClass("d-none");
        $(document).find(".download_zip_btn").addClass("d-none");

		$.ajax({
			method: 'get',
			url: "/download/" + $(document).find(".download_zip_btn").attr("data-order_id") ,
			success: function(resp){

                $(document).find(".card_table").addClass("d-none");
                $(document).find(".download_link").removeClass("d-none");
                $(document).find(".loading").addClass("d-none");

                $(document).find(".download_link").attr("href", resp.replace("/var/www/scraper/public/", ""));
			},
			error: function(){
				console.log("Error in AJAX");
			}
		});


    });


    $(document).on("click", ".download_link", function(e){

        e.preventDefault();


        var order = orderDownloaded( $(this).data("order_id"), $(this).attr("href") );

        $.when( order ).done( function( order ){

            if( order == true ){

                window.open( $(this).attr("href"), 'jpg');

                $(document).find("#gridContainer").dxDataGrid("instance").refresh();
                $(document).find("#installation_details").modal("hide");

            }

        });

    });

    function orderDownloaded(order_id, url) {

        var defObject = $.Deferred();  // create a deferred object.

        window.open( url, '_blank');

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: 'post',
            url: "/data/post",
            data: {
                action: "order_downloaded",
                order_id, order_id
            },
            success: function(resp){
                defObject.resolve(resp);    //resolve promise and pass the response.
            },
            error: function(){
                console.log("Error in AJAX");
            }
        });

        return defObject.promise();

    }

    $(document).on("hidden.bs.modal", "#installation_details", function(e){

        $(document).find(".download_zip_btn").attr("data-order_id", "");
        $(document).find(".download_link").attr("data-order_id", "");

        console.log($(document).find(".download_zip_btn").data());


    });



</script>
