(function (jQuery) {
    "use strict";

    callCountTo();
    
})(jQuery);

function callCountTo(){

    jQuery(document).ready(function() {
        if (jQuery('.timer').length > 0) {
            jQuery('.timer').each(function() {
                var jQuerythis = jQuery(this);
                jQuerythis.appear(function() {
                    jQuery('.timer').countTo();
                });
            });
        }

    });
    
}