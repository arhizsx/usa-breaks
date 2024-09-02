
$.fn.setDatagrid = function( modal, datasource, columns, callback=false){

    let whatmodal = modal;

    $( this ).dxDataGrid({
        dataSource: datasource,
        rowAlternationEnabled: true,
        selection: {
            mode: 'single',
        },
        showBorders: true,
        columnHidingEnabled: true,
        columnAutoWidth: true,
        export: {
            enabled: true,
        },
        columnFixing:{
                enabled: false
        },
        onContentReady: function(e){
        },
        searchPanel: {
            visible: true,
            highlightCaseSensitive: true,
        },
        columnChooser: {
            enabled: true,
            mode: "select",
            allowSearch: true,
        },
        scrolling: {
            rowRenderingMode: 'standard',
        },
        paging: {
            pageSize: 50,
        },
        pager: {
            visible: true,
            allowedPageSizes: [10, 20, 50, 'all'],
            showPageSizeSelector: true,
            showInfo: true,
            showNavigationButtons: true,
        },
        columnsAutoWidth: true,
        showBorders: true,
        filterRow: {
            visible: false,
            applyFilter: 'auto',
        },
        headerFilter: {
            visible: true,
        },
        onRowClick: function(e) {

            $(this).openModal( whatmodal, e.data, callback );

        },
        allowColumnResizing: {
            enabled: false
        },
        columns: columns,
        showBorders: true,
    });
}


$.fn.openModal = function( modal, data, callback ){

    $(document).find(modal).modal("show");

    console.log(data);

    $.each( data, function( k, v){

        $(modal).find("input[name='" + k + "']").val( v );
        $(modal).find("textarea[name='" + k + "']").text( v );

    } );

    $(modal).find(".btn-action").attr("data-id", data.id.toString());

    if(callback != false){
        eval( callback + "(data)" );
    }

};

