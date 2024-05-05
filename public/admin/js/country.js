
(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        ajax: $('#country-route').val(),
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
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false, responsivePriority: 1 },
            { "data": "country_name", "name": "country_name" },
            { "data": "action", searchable: false, responsivePriority: 2 },
        ]
    });
    $(document).on('change', '#countryCheckbox', function (e) {
        commonAjax('GET', $('#update-country-Route').val(), commonResponse, commonResponse, { 'id': $(this).data('id') });
    });
})(jQuery)





