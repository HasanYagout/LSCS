(function ($) {
    "use strict";

    $(document).ready(function () {
        // Check if the DataTable is already initialized and destroy if necessary
        if ($.fn.dataTable.isDataTable('#companiesTable')) {
            $('#companiesTable').DataTable().clear().destroy();
        }

        // Initialize DataTable
        var table = $("#companiesTable").DataTable({
            pageLength: 10,
            ordering: true,
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: {
                url: $('#companies-route').val(),
            },
            language: {
                paginate: {
                    previous: "<i class='fa-solid fa-angles-left'></i>",
                    next: "<i class='fa-solid fa-angles-right'></i>",
                },
                searchPlaceholder: "Search Company",
                search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
            },
            dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"d-flex align-items-center cg-5"<"tableSearch float-start"f><"z-filter-button">>><"col-sm-6"<"tableLengthInput float-end"l>><"col-sm-12"<"z-filter-block">>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
            columns: [
                { data: "name", name: "name", orderable: true, searchable: true, responsivePriority: 1 },
                { data: "email", name: "email", orderable: true, searchable: true, responsivePriority: 1 },
                { data: "phone", name: "phone", orderable: true, searchable: true },
                { data: "status", name: "status", orderable: true, searchable: true },
                { data: "action", name: "action", orderable: false, searchable: false },
            ],
            initComplete: function (settings, json) {
                $('.z-filter-block').html($('#search-section').html());
                $('#search-section').remove();
            },
        });

        // Handle status toggle
        $(document).on('change', '.toggle-status', function (e) {
            var $switch = $(this);
            var companyId = $switch.data('id');
            var newStatus = $switch.is(':checked') ? 1 : 0;
            var updateUrl = $('#companies-update-route').val().replace(':id', companyId);

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
                            if (response.success) {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                            table.ajax.reload();
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message);
                            table.ajax.reload();
                        }
                    });
                } else {
                    // Revert the switch state if the user cancels
                    $switch.prop('checked', !newStatus);
                    table.ajax.reload();
                }
            });
        });
    });

})(jQuery);
