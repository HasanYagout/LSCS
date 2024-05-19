(function ($) {
    "use strict";
    var table = $("#cvsTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        destroy: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#job-post-list-route').val(),
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
            { "data": "cvs", "name": "profile.cv", responsivePriority: 1 },
            // { "data": "title", "name": "job.title", responsivePriority: 1 },
            // { "data": "employee_status", "name": "job.employee_status", responsivePriority: 1 },
            // { "data": "salary", "name": "job.salary", responsivePriority: 2 },
            // { "data": "application_deadline", "name": "job.application_deadline", responsivePriority: 3 },
            // { "data": "action", "name": "job.action"},
            // { "data": "major", "name": "student.major" },
            // { "data": "credits_left", searchable: false, responsivePriority: 2},
            // { "data": "action", searchable: false, responsivePriority: 3 },
        ],
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
    $(document).on('click','.editStudent',function(e){
        Swal.fire({
            title: 'Sure! You want to change the status to Alumni?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change It!'
        }).then((result) => {
            if (result.value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var buttonValue = $('.editStudent').val();
                $.ajax({
                    type: 'POST',
                    url: 'students/update',
                    data: {
                        // 'selectedStatus':selectedStatus,
                        // 'alumniUserId':alumniUserId,
                        '_token':csrfToken,
                        'buttonValue': buttonValue // Include the button value in the data

                    },
                    success: function (response) {
                        if (response.status === true) {
                            toastr.success(response.message);
                        }

                        $('#alumni-all-list-filter').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }else{
                $('#alumni-all-list-filter').DataTable().ajax.reload();
            }
        })
    })
})(jQuery)
