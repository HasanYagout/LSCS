(function ($) {
	"use strict";

    $(document).on('change', '.change_status-ss', function(){
        var selectedStatus = $(this).val();
        var id = $(this).attr("data-id");
        var targetUrl = $('#transaction-update-route').val();
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
                    data: {'status':selectedStatus,'id':id,'_token':csrfToken},
                    success: function (response) {
                        toastr.success(response.message);

                        $('#pendingTransactionDataTable').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                        $('#pendingTransactionDataTable').DataTable().ajax.reload();
                    }
                })
            }else{
                $('#pendingTransactionDataTable').DataTable().ajax.reload();
            }
        })
    });

	$("#pendingTransactionDataTable").DataTable({
		pageLength: 10,
		ordering: false,
		serverSide: true,
        responsive: true,
		processing: true,
		searching: false,
		ajax: $('#pending-event-transaction-route').val(),
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search here",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
			{ "data": "user", "name": "users.name", responsivePriority: 1 },
            { "data": "type", "name": "type"},
            { "data": "amount", "name": "grand_total"},
			{ "data": "created_at", "name": "created_at" },
			{ "data": "status", "name": "status" },
			{ "data": "payment_info", searchable: false},
			{ "data": "action", searchable: false, responsivePriority: 2 },
		],
	});

})(jQuery)
