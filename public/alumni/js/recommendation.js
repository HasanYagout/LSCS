(function ($) {
    "use strict";
    var table = $("#recommendationTable").DataTable({
        rowCallback: function(row, data, index) {
            $('td', row).css('color', 'black'); // Set your desired background color for alternate rows
            if (index % 2 === 1) {
                $('td', row).css('background-color', '#fdf6e9'); // Set your desired background color for alternate rows
            }
        },
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        destroy: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#recommendation-route').val(),
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
            searchPlaceholder: "Search Recommendation",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"d-flex align-items-center cg-5"<"tableSearch float-start"f><"z-filter-button">>><"col-sm-6"<"tableLengthInput float-end"l>><"col-sm-12"<"z-filter-block">>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            { "data": "name", "name": "recommendation.name", responsivePriority: 1 },
            { "data": "status", "name": "recommendation.status", responsivePriority: 1 },
            // { "data": "employee_status", "name": "job.employee_status", responsivePriority: 1 },
            // { "data": "salary", "name": "job.salary", responsivePriority: 2 },
            // { "data": "application_deadline", "name": "job.application_deadline", responsivePriority: 3 },
            // { "data": "action", "name": "job.action"},
            // { "data": "major", "name": "student.major" },
            // { "data": "credits_left", searchable: false, responsivePriority: 2},
            { "data": "action", searchable: false, responsivePriority: 3 },
        ],
        "initComplete": function( settings, json ) {
            $('.z-filter-block').html($('#search-section').html());
            $('#search-section').remove();

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
