(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        callMasonry();
    });
})(jQuery);

function callMasonry() {
    /*------------------------
    Masonry
    --------------------------*/
    if (jQuery('.iqonic-masonry-grid').length > 0) {
        jQuery('.iqonic-masonry-grid').each(function () {
            jQuery(".iqonic-masonry-block").imagesLoaded(function () {
                jQuery(".iqonic-masonry-grid").masonry({
                    columnWidth: ".grid-sizer",
                    itemSelector: ".iqonic-masonry-item",
                });
            });

        });
    }
    jQuery('.iq-image-popup:has(img)').click(function (e) { e.preventDefault(); return false; });
    jQuery('.iq-image-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
}