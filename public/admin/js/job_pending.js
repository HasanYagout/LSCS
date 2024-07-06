(function ($) {
    "use strict";
    var table = $("#jobPostPendingdataTable").DataTable({
        pageLength: 10,
        ordering: true,
        serverSide: true,
        processing: true,
        destroy: true,
        responsive: true,
        searching: true,
        ajax: {
            url: $('#job-post-list-route').val(),
            data: function (d) {
                d.postedBy = $('#posted_by :selected').val();
                d.status = $('#status :selected').val();
                d.company = $('#company :selected').val();
            }
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search Jobs",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<"tableTop"<"row align-items-center"<"col-sm-6"<"d-flex align-items-center cg-5"<"tableSearch float-start"f><"z-filter-button">>><"col-sm-6"<"tableLengthInput float-end"l>><"col-sm-12"<"z-filter-block">>>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            { "data": "company_logo", "name": "company_logo", responsivePriority: 1, orderable: false, searchable: false },
            { "data": "title", "name": "title", responsivePriority: 1, orderable: true, searchable: true },
            { "data": "employee_status", "name": "employee_status", responsivePriority: 1, orderable: true, searchable: true },
            { "data": "application_deadline", "name": "application_deadline", responsivePriority: 3, orderable: true, searchable: true },
            { "data": "status", "name": "status", responsivePriority: 3, orderable: true, searchable: true },
        ],
        "initComplete": function(settings, json) {
            $('.z-filter-block').html($('#search-section').html());
            $('#search-section').remove();

            $('.z-filter-button').html(`
                <button class="zBtn-filter" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
    $(document).on('click', '.advance-filter', function(e){
        table.draw();
        e.preventDefault();
    });
})(jQuery);
