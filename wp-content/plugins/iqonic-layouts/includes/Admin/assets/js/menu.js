(function ($) {
    // Add Color Picker to all inputs that have 'color-field' class
    $(function () {
        $('.iqonic-color-picker').wpColorPicker();
        if ($('.custom-width-radio').length > 0) {
            $('.custom-width-radio').each(function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.megamenu-width-container').find('.custom-width-input-holder').show();
                } else {
                    $(this).closest('.megamenu-width-container').find('.custom-width-input-holder').slideUp();
                }
            });
            $(document).on('click', '.custom-width-radio', function () {
                $(this).closest('.megamenu-width-container').find('.custom-width-input-holder').slideDown();
            });
            $(document).on('click', '.default-width-radio', function () {
                $(this).closest('.megamenu-width-container').find('.custom-width-input-holder').slideUp();
            });
            
            $('.custom-height-radio').each(function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.megamenu-height-container').find('.custom-height-input-holder').show();
                } else {
                    $(this).closest('.megamenu-height-container').find('.custom-height-input-holder').slideUp();
                }
            });
            $(document).on('click', '.default-height-radio', function () {
                $(this).closest('.megamenu-height-container').find('.custom-height-input-holder').slideUp();
            });
            $(document).on('click', '.custom-height-radio', function () {
                $(this).closest('.megamenu-height-container').find('.custom-height-input-holder').slideDown();
            });

        }

        if ($('.enable-megamenu').length > 0) {
            $('.enable-megamenu').each(function () {
                if ($(this).is(':checked')) {
                    $(this).parent().next('.megamenu-select').show();
                    $(this).closest('.megamenu-holder').find('.megamenu-width-container ,.megamenu-height-container , .megamenu-padding-container').show();
                } else {
                    $(this).parent().next('.megamenu-select').hide();
                    $(this).closest('.megamenu-holder').find('.megamenu-width-container ,.megamenu-height-container , .megamenu-padding-container').hide();
                }
            });
            $(document).on('click', '.enable-megamenu', function () {
                $(this).parent().next('.megamenu-select').slideToggle();
                $(this).closest('.megamenu-holder').find('.megamenu-width-container ,.megamenu-height-container , .megamenu-padding-container').slideToggle();
            });
        }
    });

})(jQuery);