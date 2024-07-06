(function ($) {
    "use strict";

    $("#myEventDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: $('#my-event-list-route').val(),
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
            { "data": "title", "name": "title", "orderable": true, "searchable": true },
            { "data": "category", "name": "event_categories.name", "orderable": true, "searchable": true },
            { "data": "date", "name": "date", "orderable": true, "searchable": true },
            { "data": "status", "name": "status", "orderable": true, "searchable": true },
        ],
    });

    $(document).on("change", "#eventType", function () {
        if ($(this).val() == 2)
            $(document).find("#eventPrice").show();
        else
            $(document).find("#eventPrice").hide();
    });

})(jQuery)
