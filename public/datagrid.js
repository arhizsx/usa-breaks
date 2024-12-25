$.fn.setDatagrid = function (e, a, l, o = !1) {
    let n = e;
    $(this).dxDataGrid({
        dataSource: a,
        rowAlternationEnabled: !0,
        selection: {
            mode: "single"
        },
        width: "100%",
        showBorders: !0,
        columnHidingEnabled: !0,
        columnAutoWidth: !1,
        export: {
            enabled: !0
        },
        columnFixing: {
            enabled: !1
        },
        onContentReady: function (t) { },
        searchPanel: {
            visible: !0,
            highlightCaseSensitive: !0
        },
        columnChooser: {
            enabled: !0,
            mode: "select",
            allowSearch: !0
        },
        scrolling: {
            rowRenderingMode: "standard"
        },
        paging: {
            pageSize: 50
        },
        pager: {
            visible: !0,
            allowedPageSizes: [10, 20, 50, "all"],
            showPageSizeSelector: !0,
            showInfo: !0,
            showNavigationButtons: !0
        },
        columnsAutoWidth: !0,
        showBorders: !0,
        filterRow: {
            visible: !1,
            applyFilter: "auto"
        },
        headerFilter: {
            visible: !0
        },
        onRowClick: function (t) {
            $(this).openModal(n, t.data, o)
        },
        allowColumnResizing: {
            enabled: !1
        },
        columns: l,
        showBorders: !0
    })
}
    ;
$.fn.openModal = function (modal, data, callback) {
    $(document).find(modal).modal("show"),
        $.each(data, function (e, a) {
            $(modal).find("input[name='" + e + "']").val(a),
                $(modal).find("textarea[name='" + e + "']").text(a)
        }),
        $(modal).find(".btn-action").attr("data-id", data.id.toString()),
        callback != !1 && eval(callback + "(data)")
}
    ;
