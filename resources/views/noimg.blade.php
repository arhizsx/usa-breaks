<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('No Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="container-fluid p-0">
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

<div class="modal fade" id="card_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a id="check_psa" target="_blank" href="" class="btn btn-danger my-3 py-3 form-control">Check PSA</a>
                <a id="requeue"href="#" class="btn btn-success my-3 py-3 form-control">Re-Queue</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    let modal = ""; 
    let datagrid = "#gridContainer";
    let datasource = '/data/noimage';
    let columns = [
        {
            dataField: 'order_id',
            caption: '#',
            width: 60,
        },
        {
            dataField: 'certImgFront',
            caption: 'Front',
            width: 50,
            cellTemplate(container, options) {
                if (options.value != null)  {
                    $('<div>')
                    .append($('<img>', { 
                        src: options.value, 
                        alt: `Front of ${options.data.certificate_number}`, 
                        width: '100%', // ensures the image fits within the cell
                        maxWidth: '50px',  // Limiting the width
                        objectFit: 'contain' // Ensure it scales down but keeps aspect ratio                        
                    }))                    
                    .appendTo(container);
                }
            },

        },
        {
            dataField: 'certImgBack',
            caption: 'Back',
            width: 50,
            cellTemplate(container, options) {
                if (options.value != null)  {
                    $('<div>')
                    .append($('<img>', { 
                        src: options.value, 
                        alt: `Back of ${options.data.certificate_number}`, 
                        width: '100%', // ensures the image fits within the cell
                        maxWidth: '50px',  // Limiting the width
                        objectFit: 'contain' // Ensure it scales down but keeps aspect ratio                     
                    }))
                    .appendTo(container);
                }
            },
        },
        {
            caption: "Action",
            type: "buttons",
            width: 150,
            buttons: [
                {
                    text: "Refresh",
                    hint: "Refresh",
                    cssClass: "btn btn-sm btn-primary text-white",
                    onClick: function (e) {
                        requeue( e.row.data );
                        console.log(e.row.data);
                    }
                },
                {
                    text: "Tag",
                    hint: "Tag as NO IMAGE",
                    cssClass: "btn btn-sm btn-dark text-white",
                    visible: function(e){
                        if( e.row.data.cert_status != 'NO IMAGE'){
                            return true;
                        } else {
                            return false;
                        }
                    },
                    onClick: function (e) {
                        requeue( e.row.data );
                        console.log(e.row.data);
                    }
                },
                
            ]  
        },
        {
            dataField: 'certificate_number',
            caption: 'Cert #',
            width: 80,
            cellTemplate(container, options) {
                if (options.value != null)  {
                    $('<div>')
                    .append($('<a>', { 
                        text: options.value, 
                        href: `https://www.psacard.com/cert/${options.value}/psa`, 
                        target: '_blank',
                    }))
                    .appendTo(container);
                }
            },
        },
        {
            dataField: 'cert_status',
            caption: 'Status',
            width: 100,
        },
        {
            dataField: null,
            caption: 'Card',
            cellTemplate(container, options) {
                if (options.data.data != null)  {

                    $('<div>')
                            .css({
                                "white-space": "normal",  // Allows wrapping to new lines
                                "word-wrap": "break-word", // Breaks long words
                                "overflow": "visible",     // No overflow restriction
                            })
                            .append(`${options.data.Year} `)
                            .append(`${options.data.Brand} `)
                            .append(`${options.data.Player} `)
                            .append(`${options.data['Card Number']} `)
                            .append(`${options.data['Variety/Pedigree']} `)
                            .append(`${options.data['Grade']} `)
                            .appendTo(container);
                }
            },
        },
        {
            dataField: 'updated_at',
            caption: 'Added At',
            width: '150',
        }
    ];
    let callback = '';

    $(() => {

        $(datagrid).setDatagrid( modal, datasource, columns, callback );

    });

    function callbackAction(data){

        let info = JSON.parse( JSON.stringify(data) );


        $(document).find("#card_details").find("#check_psa").attr("href", "https://www.psacard.com/cert/" + info.certificate_number + "/psa" )

        console.log( info );
    }

    function requeue(data){

        console.log("REQUEUE");

        var certificate = postRequeue(data.certificate_number);

        $.when( certificate ).done( function( certificate ){

            console.log( certificate );
            $("#gridContainer").dxDataGrid("instance").refresh(); // rebind the grid  

        });

    }

    console.log($('meta[name="csrf-token"]').attr('content'));

    function postRequeue(data){

        var defObject = $.Deferred();  // create a deferred object.


        $.ajax({
            type: 'post',
            url: "/data/post",
            data: {
                certificate_number: data,
                action: "requeue",
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(resp){
                defObject.resolve(resp);    //resolve promise and pass the response.
            },
            error: function(){
                console.log("Error in AJAX");
            }
        });

        return defObject.promise();

    }

</script>
