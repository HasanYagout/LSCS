(function ($) {
    "use strict";
    // Check if the DataTable is already initialized
    if ($.fn.dataTable.isDataTable('#newsDataTable')) {
        $('#newsDataTable').DataTable().clear().destroy();
    }

    $("#newsDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: true,
        ajax: $('#newsDataTable').data('source'),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search news",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "image", "name": "image", searchable: false, orderable: false, responsivePriority: 1},
            {"data": "title", "name": "news.title"},
            {"data": "author", "name": "admins.first_name"},
            {"data": "category", "name": "news_categories.name"},
            {"data": "status", "name": "status"},
            {"data": "action", searchable: false, orderable: false, responsivePriority: 2},
        ],
    });
})(jQuery);
