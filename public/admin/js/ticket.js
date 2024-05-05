(function ($) {
    "use strict";

    window.getTicketModal = function(url, modalId) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $(document).find(modalId).find('.modal-content').html(data);

                $(modalId).modal('toggle');

                setTimeout(function(){
                    $(document).find('#download-btn').removeClass('d-none');
                    html2canvas($(document).find('#printArea')[0], {scale: 4}).then(function(canvas){
                        $(document).find('#download-btn').attr('href',canvas.toDataURL());
                    });
                }, 1000);
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })
    }

    $("#myTicketDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive:true,
        searching: true,
        ajax: $('#my-ticket-list-route').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search event",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "event", "name": "event_id.title"},
            {"data": "ticket_number", "name": "ticket_number"},
            {"data": "type", "name": "type",  responsivePriority: 1},
            {"data": "date", "name": "date"},
            {"data": "location", "name": "location"},
            {"data": "action", searchable: false, responsivePriority:2},
        ],
      });

})(jQuery)
