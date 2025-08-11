(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        
        callburgerIcon();

    });
    
})(jQuery);

function callburgerIcon(){

    jQuery(".burger-menu-style").addClass("unToggled");
    jQuery(".burger-menu-style").click(function () {
        jQuery(this).toggleClass("toggled");
        jQuery(this).toggleClass("unToggled");
    });
    
}