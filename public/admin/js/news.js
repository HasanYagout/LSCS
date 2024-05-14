(function ($) {
    "use strict";

    $(document).ready(function() {
        $("#sf-select-news-tag").select2({
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section",
            dropdownParent: $("#add-modal"),
        });
    });

    $("#newsDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive:true,
        searching: true,
        ajax: $('#news.js').val(),
        language: {
			paginate: {
				previous: "<i class='fa-solid fa-angles-left'></i>",
				next: "<i class='fa-solid fa-angles-right'></i>",
			},
			searchPlaceholder: "Search news",
			search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
		},
		dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"tableSearch float-start"f>><"col-sm-6"<"tableLengthInput float-end"l>>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
		columns: [
            {"data": "image", "name": "image", searchable: false, responsivePriority:1},
            {"data": "title", "name": "title"},
            {"data": "category", "name": "categories.name"},
            {"data": "status", "name": "status"},
            {"data": "author", "name": "users.name"},
            {"data": "action", searchable: false, responsivePriority:2},
        ],
      });

})(jQuery)
