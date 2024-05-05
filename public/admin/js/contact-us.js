
(function ($) {
    "use strict";
    $('#contactUsDataTable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: $('#contact-us-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search here",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "name", "name": "name",responsivePriority:1},
            {"data": "email", "name": "email",responsivePriority:2},
            {"data": "message", "name": "message"},
        ]
    });
})(jQuery)
