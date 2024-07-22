(function ($) {
    "use strict";
    if ($.fn.dataTable.isDataTable('#eventPendingDataTable')) {
        $('#eventPendingDataTable').DataTable().clear().destroy();
    }

    $("#eventPendingDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: true,
        ajax: $('#event-pending-list-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search pending event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "title", "name": "events.title"},
            {"data": "category", "name": "event_categories.name"},
            {"data": "date", "name": "events.date"},
            {"data": "action", searchable: false, orderable: false, responsivePriority: 2},
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
                    alert('Status updated successfully');
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
