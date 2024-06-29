!(function () {
    "use strict";

    $(document).on('click', '.delete-education', function () {
        $(this).closest('.education-item').remove();
        if ($('.education-item').length < 1) {
            $('#education-child-empty').removeClass('d-none');
        }
    });

    $(document).on('click', '.delete-experience', function () {
        $(this).closest('.experience-item').remove();
        if ($('.experience-item').length < 1) {
            $('#experience-child-empty').removeClass('d-none');
        }
    });

    $(document).on('click', '.delete-cv', function () {
        $(this).closest('.cv-item').remove();
        if ($('.cv-item').length < 1) {
            $('#cv-child-empty').removeClass('d-none');
        }
    });

})(jQuery);
