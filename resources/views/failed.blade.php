<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Failed') }}
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

<div class="modal fade" id="card_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    let modal = "#card_details";
    let datagrid = "#gridContainer";
    let datasource = '/data/failed';
    let columns = [
        {
            dataField: 'order_id',
            caption: 'Order #',
            width: 80,
        },
        {
            caption: "Action",
            type: "buttons",
            width: 70,
            buttons: [
            {
                text: "Refresh",
                hint: "Refresh",
                class: "btn btn-sm btn-outline-primary",
                onClick: function (e) {
                    requeue( e.row.data );
                    console.log(e.row.data);
                }
            }]  
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
            dataField: 'created_at',
            caption: 'Added At'
        }
    ];
    let callback = 'callbackAction';

    $(() => {

        $(datagrid).setDatagrid( modal, datasource, columns, callback );

    });

    function callbackAction(data){

        let info = JSON.parse( JSON.stringify(data) );

        // $(document).find(".imgFront").attr("src", info.certImgFront );
        // $(document).find(".imgBack").attr("src", info.certImgBack );

        console.log( info );
    }


</script>
