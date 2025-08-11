(function (jQuery) {
    "use strict";

    jQuery(window).on('load', function() {

        callBlogMasonry();

    }); 
    
})(jQuery);

function callBlogMasonry(){

    if (jQuery('.iq-masonry-block').length >= 1) {

        jQuery('.iq-masonry').isotope({
            itemSelector: '.iq-masonry-item',
        });

        /*------------------------------
        filter items on button click
        -------------------------------*/
        jQuery('.isotope-filters').on('click', 'button', function() {
            var filterValue = jQuery(this).attr('data-filter');
            jQuery('.isotope').isotope({
                resizable: true,
                filter: filterValue
            });
            jQuery('.isotope-filters button').removeClass('active');
            jQuery(this).addClass('active');
        });

        /*------------------------
        Masonry
        --------------------------*/
        var jQuerymsnry = jQuery('.iq-masonry-block .iq-masonry');
        if (jQuerymsnry) {
            var jQueryfilter = jQuery('.iq-masonry-block .isotope-filters');
            jQuerymsnry.isotope({
                percentPosition: true,
                resizable: true,
                itemSelector: '.iq-masonry-block .iq-masonry-item',
                masonry: {
                    gutterWidth: 0
                }
            });
            // bind filter button click
            jQueryfilter.on('click', 'button', function() {
                var filterValue = jQuery(this).attr('data-filter');
                jQuerymsnry.isotope({
                    filter: filterValue
                });
            });

            jQueryfilter.each(function(i, buttonGroup) {
                var jQuerybuttonGroup = jQuery(buttonGroup);
                jQuerybuttonGroup.on('click', 'button', function() {
                    jQuerybuttonGroup.find('.active').removeClass('active');
                    jQuery(this).addClass('active');
                });
            });
        }
    }
    
}