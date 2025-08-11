(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        
        callProgress();

    });
    
})(jQuery);

function callProgress(){

    /*------------------------
    Progress Bar
    --------------------------*/
    jQuery('.iq-progress-bar > span').each(function() {

        var jQuerythis = jQuery(this);
        var width = jQuery(this).data('percent');
        jQuerythis.css({
            'transition': 'width 2s'
        });
        jQuery('.progress-value').css({
            'transition': 'margin 2s'
        });

        setTimeout(function() {
            jQuerythis.appear(function() {
                jQuerythis.css('width', width + '%');
            });
        }, 500);

        setTimeout(function() {
            jQuery('.iq-progressbar-style-2 .progress-value').appear(function() {
                jQuery('.iq-progressbar-style-2 .progress-value').css('margin-left', width + 'px');
            });
        }, 500);

        setTimeout(function() {
            jQuery('.iq-progressbar-style-3 .progress-tooltip').appear(function() {
                jQuery('.iq-progressbar-style-3 .progress-tooltip').css('margin-left', width + 'px');
            });
        }, 500);
    });
    
}