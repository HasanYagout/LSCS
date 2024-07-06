$(document).ready(function () {
    $("#noticeDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: {
            url: $('#notice-list-route').val(),
            type: 'GET',
            data: function(d) {
                d.search.value = $('#noticeDataTable_filter input').val(); // Getting search value
            }
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search notice",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            { "data": "image", "name": "image", "orderable": false, "searchable": false, "responsivePriority": 1 },
            { "data": "title", "name": "notices.title", "orderable": true, "searchable": true },
            { "data": "category", "name": "notice_categories.name", "orderable": true, "searchable": true },
            { "data": "status", "name": "status", "orderable": true, "searchable": true },
            { "data": "action", "name": "action", "orderable": false, "searchable": false, "responsivePriority": 2 },
        ],
    });
});
