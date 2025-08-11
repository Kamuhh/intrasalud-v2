/**
 * File products-swiper.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	"use strict";

	$(document).ready(function () {


		if ($(document).find('.product-single-slider').length > 0) {

			$(document).find('.product-single-slider').each(function () {
				let slider = $(this);
				var config;
				if (slider.hasClass("image-slider")) {
					config = {
						slidesPerView: 1,
						paginationClickable: true,
						pagination: '.swiper-pagination',
						paginationType: "bullets",
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev'
						},
						loop: true,
						spaceBetween: 0
					};
				}

				if (slider.hasClass("related-slider") || slider.hasClass("upsells-slider")) {
					config = {
						speed: 400,
						initialSlide: 0,
						autoHeight: false,
						direction: 'horizontal',
						loop: false,
						nextButton: '.swiper-button-next',
						prevButton: '.swiper-button-prev',
						effect: 'slide',
						spaceBetween: 0,
						slidesPerView: 4,
						slidesOffsetBefore: 0,
						grabCursor: true,
						breakpoints: {
							480: {
								slidesPerView: 1,
							},
							767: {
								slidesPerView: 2,
							},
							999: {
								slidesPerView: 3,
							},
							1149: {
								slidesPerView: 3,
							}
						},
					};
				}

				let swiper = new Swiper(slider[0], config);

			});
			/* Resize window on load */
			window.dispatchEvent(new Event('resize'));
		}

	});


}(jQuery));
