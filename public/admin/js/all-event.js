(function ($) {
    "use strict";
    if ($.fn.dataTable.isDataTable('#allEventDataTable')) {
        $('#allEventDataTable').DataTable().clear().destroy();
    }

    $("#allEventDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: {
            url: $('#event-all-list-route').val(),
            type: 'GET',
            data: function(d) {
                d.search.value = $('#allEventDataTable_filter input').val(); // Getting search value
            }
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search all event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            { "data": "title", "name": "title", "orderable": true, "searchable": true },
            { "data": "category", "name": "event_categories.name", "orderable": true, "searchable": true },
            { "data": "date", "name": "date", "orderable": true, "searchable": true },
            { "data": "status", "name": "status", "orderable": true, "searchable": true },
            { "data": "action", "name": "action", "orderable": false, "searchable": false, "responsivePriority": 2 },
        ],
    });

    window.toggleStatus = function(eventId) {
        $.ajax({
            url: $('#event-pending-update-route').val(),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: eventId
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Status Changed Successfully');
                } else {
                    alert('Failed to update status');
                }
            },
            error: function(xhr) {
                alert('An error occurred while updating status');
            }
        });
    }
})(jQuery);
