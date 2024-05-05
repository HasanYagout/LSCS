(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        ajax: $('#currency-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false},
            {"data": "currency_code", "name": "currency_code", responsivePriority: 1},
            {"data": "symbol", "name": "symbol"},
            {"data": "currency_placement", "name": "currency_placement"},
            {"data": "action", searchable: false, responsivePriority: 2},
        ]
    });

    $("#sf-select-currency-add").select2({
        dropdownCssClass: "sf-select-dropdown",
        selectionCssClass: "sf-select-section",
        dropdownParent: $("#add-modal"),
    });

})(jQuery)
