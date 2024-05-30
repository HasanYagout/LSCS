
(function ($) {
    "use strict";


    window.getEditModal = function (url, modalId) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $(document).find(modalId).find('.modal-content').html(data);

                if ($(document).find(modalId).find('.sf-select-edit-modal').length) {
                    $(document).find(modalId).find('.sf-select-edit-modal').select2({
                        dropdownCssClass: "sf-select-dropdown",
                        selectionCssClass: "sf-select-section",
                        dropdownParent: $(modalId),
                    });
                }

                if ($(document).find(modalId).find('.sf-select-without-search').length) {
                    $(document).find(modalId).find('.sf-select-without-search').niceSelect();
                }

                if ($(document).find(modalId).find('.date-time-picker').length) {
                    $(document).find(modalId).find('.date-time-picker').each(function () {
                        $(this).closest(".primary-form-group-wrap").addClass("calendarIcon"); // Add your custom class here
                    });
                }

                if ($(document).find(modalId).find('.date-time-picker').length) {
                    $(document).find(modalId).find('.date-time-picker').daterangepicker({
                        singleDatePicker: true,
                        timePicker: true,
                        locale: {
                            format: "Y-M-D h:mm",
                        },
                    });
                }

                if ($(document).find(modalId).find('.summernoteOne').length) {
                    $(document).find(modalId).find('.summernoteOne').summernote({
                        placeholder: "Write description...",
                        tabsize: 2,
                        minHeight: 183,
                        toolbar: [
                            // ["style", ["style"]],
                            // ["view", ["undo", "redo"]],
                            // ["fontname", ["fontname"]],
                            // ["fontsize", ["fontsize"]],
                            // ["font", ["bold", "italic", "underline"]],
                            // ["para", ["ul", "ol", "paragraph"]],
                            // ["color", ["color"]],
                            ["font", ["bold", "italic", "underline"]],
                            ["para", ["ul", "ol", "paragraph"]],
                        ],
                    });
                }

                $(modalId).modal('toggle');
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })
    }


})(jQuery)
