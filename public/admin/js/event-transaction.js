(function ($) {
	"use strict";
	$("#eventDataTable").DataTable({
		pageLength: 10,
		ordering: false,
		serverSide: true,
        responsive: true,
		processing: true,
		searching: true,
		ajax: $('#event-transaction-route').val(),
		language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search event transaction",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
			{ "data": "user", "name": "user.name"},
			{ "data": "purpose", "name": "purpose", responsivePriority: 1 },
			{ "data": "tnxId", "name": "tnxId" ,responsivePriority: 2},
			{ "data": "payment_method", "name": "payment_method"},
			{ "data": "created_at", "name": "created_at" },
			{ "data": "amount", "name": "amount" },
		],
	});

})(jQuery)
