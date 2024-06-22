!(function () {
    "use strict";

    $(document).on('click', '.delete-education', function () {
        $(this).closest('.education-item').remove();
        if ($('.education-item').length < 1) {
            $('#education-child-empty').removeClass('d-none');
        }
    });

})(jQuery);