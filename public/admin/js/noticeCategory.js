(function ($) {
    "use strict";

    var table = $('#noticeCategoryDataTable').DataTable();

    if ($.fn.dataTable.isDataTable('#noticeCategoryDataTable')) {
        table.clear().destroy();
    }

    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#noticeCategoryDataTable')) {
            $("#noticeCategoryDataTable").DataTable({
                pageLength: 10,
                ordering: true,
                serverSide: true,
                processing: true,
                responsive: true,
                searching: true,
                ajax: $('#notice-list-route').val(),
                language: {
                    paginate: {
                        previous: "<i class='fa-solid fa-angles-left'></i>",
                        next: "<i class='fa-solid fa-angles-right'></i>",
                    },
                    searchPlaceholder: "Search notices",
                    search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
                    emptyTable: "No data found",
                    zeroRecords: "No matching records found"
                },
                dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
                columns: [
                    { "data": "name", "name": "name", orderable: true, searchable: true },
                    { "data": "status", "name": "status", orderable: true, searchable: false },
                    { "data": "action", searchable: false, orderable: false, responsivePriority: 2 },
                ],
            });
        }
    });
})(jQuery);
