<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Processed') }}
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Card Details</h1>
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

    let x= "";
    let modal = "#card_details";
    let datagrid = "#gridContainer";
    let datasource = '/data/scraped';
    let columns = [
        {
            dataField: 'order_id',
            caption: 'Order #',
            width: 80,
        },
        {
            dataField: 'certificate_number',
            caption: 'Certificate #',
            width: 120,
        },
        {
            dataField: null,
            caption: 'Card',
            cellTemplate(container, options) {
                if (options.data.data != null)  {

                    $('<div>').append(`${options.data.Year} `)
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
            dataField: 'certImgFront',
            caption: 'Front',
            width: 100,
            cellTemplate(container, options) {
                if (options.value != null)  {
                    $('<div>')
                    .append($('<img>', { src: options.value, alt: `Front of ${options.data.certificate_number}` }))
                    .appendTo(container);
                }
            },

        },
        {
            dataField: 'certImgBack',
            caption: 'Back',
            width: 100,
            cellTemplate(container, options) {
                if (options.value != null)  {
                    $('<div>')
                    .append($('<img>', { src: options.value, alt: `Front of ${options.data.certificate_number}` }))
                    .appendTo(container);
                }
            },
        },
        {
            dataField: 'updated_at',
            caption: 'Added At'
        }
    ];

    $(() => {

        $(datagrid).setDatagrid( modal, datasource, columns );

    });


</script>
