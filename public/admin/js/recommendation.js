(function ($) {
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $("#recommendationTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        destroy: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#recommendation_route').val(),
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
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'id', name: 'id' ,orderable: true, searchable: true },
            { data: 'name', name: 'name' },
            { data: 'gpa', name: 'gpa' },
            { data: 'recommendation_count', name: 'recommendation' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
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
        }
    });


    $('#change-status-btn').on('click', function() {
        var selectedStatus = $('#status-change').val();
        var selectedIds = [];

        $('.record-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0 && selectedStatus !== '') {
            $.ajax({
                url: $('#status_update_route').val(),
                method: 'POST',
                data: {
                    ids: selectedIds,
                    status: selectedStatus,
                    _token: $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                },
                success: function(response) {
                    table.ajax.reload();
                    displaySuccessMessage(response.message); // Call function to display success message
                },
                error: function(xhr) {
                    alert('An error occurred.');
                }
            });
        } else {
            alert('Please select at least one record and a status.');
        }
    });

// Function to display success message
    function displaySuccessMessage(message) {
        var successAlert = '<div class="alert alert-success">' + message + '</div>';
        $('body').prepend(successAlert); // Append success message to the body or a specific container
        setTimeout(function() {
            $('.alert-success').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000); // Remove the message after 3 seconds
    }
    $(document).on('click', '.alumniPhone', function(){
        var contactName = $(this).closest('ul').data("contact-name");
        $('.contact-name').text(contactName);
        var dataPhoneNo = $(this).data("phone");
        $('.show-phone').text(dataPhoneNo);
    });
    $(document).on('click', '.alumniEmail', function(){
        var contactName = $(this).closest('ul').data("contact-name");
        $('.contact-name').text(contactName);
        var dataEmail = $(this).data("email");
        $('.show-email').text(dataEmail);
    });
    $(document).on('click','.advance-filter',function(e){
        table.draw();
        e.preventDefault();
    })
    $(document).on('change', '#change_status', function(){
        var selectedStatus = $(this).val();
        var alumniUserId = $(this).attr("data-id");
        var targetUrl = $('#alumni-status-update-route').val()+'?id='+alumniUserId;
        var modalId = '#ticketAssignModal';
        var modalUrl = $(this).attr("modal-url");
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
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
                $.ajax({
                    type: 'POST',
                    url: targetUrl,
                    data: {'selectedStatus':selectedStatus,'alumniUserId':alumniUserId,'_token':csrfToken},
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

    });

})(jQuery)
