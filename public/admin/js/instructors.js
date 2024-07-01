(function ($) {
    "use strict";

    var table = $("#instructorsDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true, // Ensure server-side processing is enabled
        processing: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#instructor-list-route').val(),
            data: function (d) {
                d.selectedDepartment = $('#department :selected').val();
                d.selectedPassingYear = $('#passing-year :selected').val();
                d.isMember = $('#is-member :selected').val();
            }
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search Admins",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"d-flex align-items-center cg-5"<"tableSearch float-start"f><"z-filter-button">>><"col-sm-6"<"tableLengthInput float-end"l>><"col-sm-12"<"z-filter-block">>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "image", "name": "image", responsivePriority: 1, "searchable": true},
            {"data": "first_name", "name": "first_name", responsivePriority: 1, "searchable": true},
            {"data": "last_name", "name": "last_name", "searchable": true},
            {"data": "email", "name": "email"},
            {"data": "type", "name": "type"},
            {"data": "status", "name": "status"},
            {"data": "reset_password", "name": "reset_password"},
            {"data": "action", "name": "action"}
        ],
        initComplete: function (settings, json) {
            $('.z-filter-block').html($('#search-section').html());
            $('#search-section').remove();

            $('.z-filter-button').html(`
                <button class="zBtn-filter" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="14.1646" cy="10.1667" rx="1.647" ry="1.66667" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <ellipse cx="8.39895" cy="5.16667" rx="1.647" ry="1.66667" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <ellipse cx="2.63528" cy="9.33332" rx="1.647" ry="1.66667" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M8.39941 14.3333L8.39941 6.83331" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M8.39941 3.5L8.39941 1" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M14.1631 8.5L14.1631 1" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M2.63574 14.3333L2.63574 11" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M14.1631 14.3333L14.1631 11.8333" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M2.63574 7.66666L2.63574 0.99999" stroke="#1B1C17" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>`
            );
        },
    });

    // Event handler for toggle status checkbox change
    $(document).on('change', '.toggle-status', function (e) {
        var $switch = $(this);
        var instructorId = $switch.data('id');
        var newStatus = $switch.is(':checked') ? 1 : 0;
        var updateUrl = $('#instructor-status-route').val().replace(':id', instructorId);

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
                    url: updateUrl,
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        status: newStatus
                    },
                    success: function (response) {
                        if (response.message) {
                            toastr.success(response.message);
                        } else {
                            toastr.error('Failed to update status.');
                        }
                        // Reload DataTable after status change
                        table.ajax.reload();
                    },
                    error: function (error) {
                        toastr.error('Failed to update status.');
                        console.error(error);
                        // Reload DataTable on error (optional)
                        table.ajax.reload();
                    }
                });
            } else {
                // Revert the switch state if the user cancels
                $switch.prop('checked', !newStatus);
                toastr.info('Status change cancelled.');
            }
        });
    });

    // Function to handle resetting password


    // Function to handle deletion
    window.deleteItem = function (url, id) {
        Swal.fire({
            title: 'Sure! You want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Deleted',
                            html: '<span style="color:red">Item has been deleted</span>',
                            timer: 2000,
                            icon: 'success'
                        });
                        toastr.success('Admin deleted successfully.');
                        // Reload DataTable after deletion
                        table.ajax.reload();
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            }
        });
    };

})(jQuery);
