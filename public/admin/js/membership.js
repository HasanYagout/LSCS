(function ($) {
    "use strict";

    $("#membershipDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: $('#membership-create-route').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
            {"data": "badge", "name": "badge"},
            {"data": "title", "name": "title"},
            {"data": "price", "name": "price", responsivePriority:1},
            {"data": "duration", "name": "duration"},
            {"data": "status", "name": "status"},
            {"data": "action", searchable: false, responsivePriority:2},
        ],
      });


      $("#memberListDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        responsive: true,
        processing: true,
        searching: true,
        ajax: $('#member-list-route').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
            {"data": "name", "name": "users.name"},
            {"data": "planName", "name": "membership.title"},
            {"data": "created_at", "name": "created_at"},
            {"data": "expired_date", "name": "expired_date"},
            {"data": "status", "name": "status", responsivePriority:2},
        ],
      });

})(jQuery)
