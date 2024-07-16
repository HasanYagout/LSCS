(function ($) {
    "use strict";
    // Check if the DataTable is already initialized
    if ($.fn.dataTable.isDataTable('#storyDataTable')) {
        $('#storyDataTable').DataTable().clear().destroy();
    }

    $("#storyDataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        processing: true,
        responsive:true,
        searching: true,
        ajax: $('#story-all-list-route').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search story",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
            {"data": "thumbnail", "name": "thumbnail", searchable: false, responsivePriority:1},
            {"data": "title", "name": "title"},
            {"data": "status", "name": "status", searchable: false},
            {"data": "action", searchable: false, responsivePriority:2},
        ],
      });
    $(document).on('change', '.toggle-status', function(e) {
        var $switch = $(this);
        var storyId = $switch.data('id');
        var newStatus = $switch.is(':checked') ? 1 : 0;

        Swal.fire({
            title: 'Sure! You want to change the status?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change It!'
        }).then((result) => {
            if (result.value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: $('#stories-update-route').val(), // Replace with your actual route
                    data: {
                        '_token': csrfToken,
                        'story_id': storyId,
                        'status': newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                        $('#alumni-all-list-filter').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                        $('#alumni-all-list-filter').DataTable().ajax.reload();
                    }
                });
            } else {
                // Revert the switch state if the user cancels
                $switch.prop('checked', !newStatus);
                $('#alumni-all-list-filter').DataTable().ajax.reload();
            }
        });
    });

})(jQuery)
