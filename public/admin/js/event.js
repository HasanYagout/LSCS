(function ($) {
    "use strict";

    $(document).on('change', '#eventType', function() {
        if($(this).val() == 2){
            $(document).find("#eventPrice").removeClass('d-none');
        }else{
            $(document).find("#eventPrice").addClass('d-none');
        }
    });

})(jQuery)
