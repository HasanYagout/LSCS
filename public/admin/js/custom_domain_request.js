(function ($) {
    "use strict";

    $("#customDomainDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive:true,
        searching: true,
        ajax: $('#custom-domain-list-route').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search Domain",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
            {"data": "old_domain", "name": "old_domain"},
            {"data": "request_domain", "name": "request_domain"},
            {"data": "status", "name": "status"},
            {"data": "action", "name": "action"},
        ],
      });

})(jQuery)
