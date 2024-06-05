(function ($) {
    "use strict";
    var table = $("#studentsTable").DataTable({
        pageLength: 10,
        ordering: false,
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
            { data: 'student_id', name: 'student_id', searchable: true, responsivePriority: 1 },
            { data: 'first_name', name: 'first_name', searchable: true, responsivePriority: 1 },
            { data: 'middle_name', name: 'middle_name', searchable: true, responsivePriority: 2 },
            { data: 'last_name', name: 'last_name', searchable: true, responsivePriority: 3 },
            { data: 'gpa', name: 'gpa', searchable: true },
            { data: 'major', name: 'major.name', searchable: true }, // Adjusted to search by major name
            { data: 'credits_left', name: 'credits_left', searchable: true, responsivePriority: 2 },
            { data: 'action', name: 'action', searchable: false, responsivePriority: 3 }
        ],
        rowCallback: function(row, data, index) {
            // Add the row number to the first column
            var info = table.page.info();
            $('td:eq(0)', row).html(info.start + index + 1);
        },
        "initComplete": function( settings, json ) {
            $('.z-filter-block').html($('#search-section').html());
            $('#search-section').remove();

            $('.z-filter-button').html(`  <button class="zBtn-filter" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
		</button>`);
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
                        'student_id': studentId,
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
