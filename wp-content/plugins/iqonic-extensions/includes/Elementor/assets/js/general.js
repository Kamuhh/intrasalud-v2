(function (jQuery) {
    "use strict";

    jQuery(document).ready(function($){

    /*----------------
		Counter
		---------------------*/
		jQuery('.timer').countTo();

		/*----------------
		Coming soon
		---------------------*/
		var $expire_dates = jQuery('.expire_date').attr('id');

		if ( jQuery('.example').length > 0 ) {
		    jQuery('.example').countdown({
			    date: $expire_dates,
			    offset: -8,
			    date: '10/01/2019 23:59:59',
			    day: 'Day',
			    days: 'Days'
		    }, function () {
		    });
	    }

		/*----------------
	    Timer
	    ---------------------*/
		if (jQuery(".expire_date").length) {
			var $l;
			var $i;
			var $j;
			$l = jQuery(".expire_date").length;

			$i = 1;
			jQuery('.expire_date').each(function () {
				jQuery(this).addClass('expire_date_' + $i);
				$i++;
			});

			$i = 1;
			jQuery('.example').each(function () {
				jQuery(this).addClass('example_' + $i);
				$i++;
			});

			for ($i = 1; $i <= $l; $i++) {

				var $expire_dates = jQuery('.expire_date_' + $i).attr('id');

				jQuery('.example_' + $i).countdown({
					date: $expire_dates,
					offset: -8,
					day: 'Day',
					days: 'Days'
				}, function () {

				});
			}
		}


    });

})(jQuery);