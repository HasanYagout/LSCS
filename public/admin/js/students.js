(function ($) {
    "use strict";
    var table = $("#studentsTable").DataTable({
        pageLength: 10,
        ordering: true,
        order: [[1, 'desc']], // Default order: sort by id descending
        serverSide: true,
        processing: true,
        destroy: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#students-list-route').val(),
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
            searchPlaceholder: "Search Alumni",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"d-flex align-items-center cg-5"<"tableSearch float-start"f><"z-filter-button">>><"col-sm-6"<"tableLengthInput float-end"l>><"col-sm-12"<"z-filter-block">>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            { data: null, name: 'number', searchable: false, orderable: false, responsivePriority: 1 }, // For row numbers
            { data: 'id', name: 'students.id', searchable: true, orderable: true, responsivePriority: 3 },
            { data: 'first_name', name: 'students.first_name', searchable: true, orderable: true, responsivePriority: 1 },
            { data: 'middle_name', name: 'middle_name', searchable: true, orderable: true, responsivePriority: 2 },
            { data: 'last_name', name: 'last_name', searchable: true, orderable: true, responsivePriority: 3 },
            { data: 'gpa', name: 'gpa', searchable: true, orderable: true },
            { data: 'major', name: 'major', searchable: true, orderable: true, responsivePriority: 3 }, // Adjusted to search by major name
            { data: 'credits_left', name: 'credits_left', searchable: true, orderable: true, responsivePriority: 2 },
            { data: 'action', name: 'action', searchable: false, orderable: false, responsivePriority: 3 }
        ],
        rowCallback: function(row, data, index) {
            // Add the row number to the first column
            var info = table.page.info();
            $('td:eq(0)', row).html(info.start + index + 1);
        },
        initComplete: function(settings, json) {
            $('.z-filter-block').html($('#search-section').html());
            $('#search-section').remove();
        },
    });

    $(document).on('change', '.toggle-status', function(e) {
        var $switch = $(this);
        var studentId = $switch.data('id');
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
                    url: $('#students-update-route').val(), // Replace with your actual route
                    data: {
                        '_token': csrfToken,
                        'id': studentId,
                        'status': newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                        $('#studentsTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                        $('#studentsTable').DataTable().ajax.reload();
                    }
                });
            } else {
                // Revert the switch state if the user cancels
                $switch.prop('checked', !newStatus);
                $('#studentsTable').DataTable().ajax.reload();
            }
        });
    });

})(jQuery);
