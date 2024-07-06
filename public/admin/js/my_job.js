(function ($) {
    "use strict";
    var table = $("#jobPostDataTable").DataTable({
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
            { "data": "company_logo", "name": "company_logo", "searchable": false, "orderable": false, responsivePriority: 1 },
            { "data": "title", "name": "title", "searchable": true, "orderable": true, responsivePriority: 1 },
            { "data": "employee_status", "name": "employee_status", "searchable": true, "orderable": true, responsivePriority: 1 },
            { "data": "application_deadline", "name": "application_deadline", "searchable": true, "orderable": true, responsivePriority: 3 },
            { "data": "status", "name": "status", "searchable": true, "orderable": true, responsivePriority: 3 },
            { "data": "action", "name": "action", "searchable": false, "orderable": false},
        ],

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
