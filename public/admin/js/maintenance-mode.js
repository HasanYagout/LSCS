(function ($) {
    "use strict"

    window.maintenanceMode = function(maintenance_mode) {
        "use strict"
        if (maintenance_mode == 1) {
            $(".maintenance_secret_key").attr("required", "true");
        } else if (maintenance_mode == 2) {
            $(".maintenance_secret_key").removeAttr('required');
            $('.maintenance_secret_key').val('');
            $('.maintenance_mode_url').val(getUrl);
        }
    }

    var url = getUrl + "/" + maintenanceSecretKey
    $('.maintenance_mode_url').val(url);
    var maintenance_mode = maintenanceModeConst

    $('.maintenance_secret_key').on('keyup', function () {
        var secret_value = $('.maintenance_secret_key').val()
        var url = getUrl + "/"
        $('.maintenance_mode_url').val(url + secret_value);
    })

    maintenanceMode(maintenance_mode)

    $('.maintenance_mode').on("change",function () {
        maintenance_mode = this.value
        maintenanceMode(maintenance_mode)
    });

})(jQuery)



