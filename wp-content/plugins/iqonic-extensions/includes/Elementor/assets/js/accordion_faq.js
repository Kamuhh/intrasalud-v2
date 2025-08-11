(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        callAccordion();
    });
})(jQuery);

function callAccordion(){

    /*------------------------
        Accordion
    --------------------------*/
    jQuery('.iq-accordion .iq-accordion-block .iq-accordion-details').hide();
    jQuery('.iq-accordion .iq-accordion-block:first').addClass('iq-active').children().slideDown('slow');
    jQuery('.iq-accordion .iq-accordion-block').on("click", function() {
        if (jQuery(this).children('div.iq-accordion-details').is(':hidden')) {
            jQuery('.iq-accordion .iq-accordion-block').removeClass('iq-active').children('div.iq-accordion-details').slideUp('slow');
            jQuery(this).toggleClass('iq-active').children('div.iq-accordion-details').slideDown('slow');
        }
    });
    
}