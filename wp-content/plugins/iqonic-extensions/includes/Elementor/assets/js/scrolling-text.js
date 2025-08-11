(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {

        callSkrollr();

    });

})(jQuery);

function callSkrollr() {

    jQuery('.scrolling-text').each(function() {

        var ids = jQuery('#'+this.id);
        window_height = jQuery(window).height();

        jQuery(window).on("scroll", function() {
            if (ids.length) {
                var window_height = jQuery(document).scrollTop() + jQuery(window).height(),
                count = ids.offset().top;
                
                if (count <= window_height) {
                    var i = jQuery(document).scrollTop() - count + jQuery(window).height();
                    var scroll = i - 150;
					var speed = scroll + ((scroll/70)/100);
					var text_scroll = speed * 30 /100;
                    ids.css({
                        transform: "translateX(" + text_scroll + "px)"
                    })
                }
            }
        });

    });
}
