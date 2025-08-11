/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function (jQuery) {
	"use strict";

	jQuery(window).trigger('resize');

	jQuery(document.body).on('woosq_loaded', ()=>{
		wp.hooks.doAction("yith_wcwl_init_add_to_wishlist_components")
	});


	jQuery(window).on('load', function (e) {

		/*-- Wow Animation --*/
		var wow = new WOW({
			boxClass: 'wow',
			animateClass: 'animated',
			offset: 0,
			mobile: true,
			live: true
		});
		wow.init();

		jQuery('ul.page-numbers').addClass('justify-content-center');

		/*------------------------
		Page Loader
		--------------------------*/

		jQuery("#load").fadeOut();
		jQuery("#loading").delay(0).fadeOut("slow");

		// scroll body to 0px on click back to top
		jQuery('#top').on('click', function () {
			jQuery('top').tooltip('hide');
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
			return false;
		});

		/*----------------------------------------------------------------
									Vertical Menu
		-----------------------------------------------------------------*/
		if (jQuery('.menu-style-one.kivicare-mobile-menu').length > 0) {
			getDefaultMenu();
		}

		/*------------------------
			Header style one
		--------------------------*/
		function headerHeight() {
			const height = jQuery('#main-header').height();
			jQuery('.iq-height').css('height', height + 'px');
		}

		jQuery(function () {
			headerHeight();
			jQuery(window).resize(headerHeight);

		});

		if (jQuery('header.default-header').length > 0) {
			jQuery('.sub-menu').css('display', 'none');
			jQuery('.sub-menu').prev().addClass('isubmenu');

			jQuery('.widget .ion-ios-arrow-down, #main .ion-ios-arrow-down').on('click', function () {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			});

			jQuery("#top-menu .menu-item .toggledrop").off("click");

			jQuery('.widget .ion-ios-arrow-down, #main .ion-ios-arrow-down').on('click', function () {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			});
			jQuery("#top-menu .menu-item .toggledrop").off("click");
			if (jQuery(window).width() < 1200) {
				jQuery('#top-menu .menu-item .toggledrop').on('click', function (e) {
					e.preventDefault();
					jQuery(this).next('.children, .sub-menu').slideToggle();
				});
			}
		}


		/*----------------
		Counter
		---------------------*/
		if (jQuery('.timer').length > 0) {
			jQuery('.timer').countTo();
		}

		/*----------------
		Coming soon
		---------------------*/
		var $expire_dates = jQuery('.expire_date').attr('id');
		if (jQuery('.example').length > 0) {
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

	var position = jQuery(window).scrollTop();
	jQuery('#back-to-top').fadeOut();

	jQuery(window).on('scroll', function () {

		var header = jQuery(".has-sticky"),
			yOffset = 0,
			triggerPoint = 80;
		yOffset = jQuery(window).scrollTop();

		if (jQuery('header.default-header').hasClass('has-sticky')) {
			if (yOffset >= triggerPoint) {
				header.addClass("menu-sticky animated slideInDown");
			} else {
				header.removeClass("menu-sticky animated slideInDown");
			}
		}
		if (jQuery('header.has-sticky').length > 0) {

			if (jQuery(this).scrollTop() > 300) {
				jQuery('header.default-header').addClass('menu-sticky animated slideInDown');
				jQuery('.has-sticky .logo').addClass('logo-display');
			} else if (jQuery(this).scrollTop() < 20) {
				jQuery('header.default-header').removeClass('menu-sticky animated slideInDown');
				jQuery('.has-sticky .logo').removeClass('logo-display');
			}
		}
		if (position >= 10 && jQuery("body").hasClass("side-bar-open")) {
			jQuery("body").removeClass("side-bar-open");
		}

		/*------------------------
		Back To Top
		--------------------------*/

		if (jQuery(this).scrollTop() > 250) {
			jQuery('#back-to-top').fadeIn(1400);
		} else {
			jQuery('#back-to-top').fadeOut(400);
		}

		if (jQuery('.has-sticky').length > 0) {
			var scroll = jQuery(window).scrollTop();
			if (scroll < position) {
				jQuery('.has-sticky').addClass('header-up');
				jQuery('body').addClass('header--is-sticky');
				jQuery('.has-sticky').removeClass('header-down');

			} else {
				jQuery('.has-sticky').addClass('header-down');
				jQuery('.has-sticky').removeClass('header-up ');
				jQuery('body').removeClass('header--is-sticky');
			}
			if (scroll == 0) {
				jQuery('.has-sticky').removeClass('header-up');
				jQuery('.has-sticky').removeClass('header-down');
				jQuery('body').removeClass('header--is-sticky');
			}
			position = scroll;
		}

	});

	jQuery(document).ready(function () {

		// shop sidebar toggle button
		if (jQuery('.shop-filter-sidebar').length > 0) {
			jQuery('.shop-filter-sidebar').click(function () {
				jQuery('body').find('.kivicare-woo-sidebar').toggleClass('woo-sidebar-open');
			});
		}

		/*-----------------------------------------------------------------------
		 --------------------------   Search Bar --------------------------------
		------------------------------------------------------------------------*/

		if (jQuery(".btn-search").length > 0) {
			jQuery(document).on('click', '.btn-search', function () {
				jQuery(this).parent().find('.kivicare-search').toggleClass('search--open');
			});
			jQuery(document).on('click', '.btn-search-close', function () {
				jQuery(this).closest('.kivicare-search').toggleClass('search--open');
			});
			jQuery('body').on('click', function (e) {
				if (jQuery(e.target).closest(".search_form_wrap").length === 0) {
					jQuery(".kivicare-search.search--open").removeClass("search--open");
				}
			});
		}


		/*---------------------------
		Sidebar
		---------------------------*/

		if (jQuery('#menu-btn-side-open').length > 0) {
			jQuery("#menu-btn-side-open").click(function () {
				jQuery("body").toggleClass("side-bar-open");

			});
			jQuery("#menu-btn-side-close").click(function () {
				jQuery("body").toggleClass("side-bar-open");
			});
			jQuery('body').mouseup(function (e) {
				if (jQuery(e.target).closest(".iq-menu-side-bar").length === 0) {
					jQuery("body").removeClass("side-bar-open");
				}
			});
			jQuery(".iq-menu-side-bar").mouseenter(function () {
				jQuery("body").addClass("body-scroll-hidden");
			});
			jQuery(".iq-menu-side-bar").mouseleave(function () {
				jQuery("body").removeClass("body-scroll-hidden");
			});
		}

		/*------------------------
				superfish menu
		--------------------------*/
		jQuery('ul.sf-menu').superfish({
			delay: 500,
			onBeforeShow: function (ul) {
				var elem = jQuery(this);
				var elem_offset = 0,
					elem_width = 0,
					ul_width = 0;
				// Add class if menu at the edge of the window
				if (elem.length == 1) {
					var page_width = jQuery('#page.site').width(),
						elem_offset = elem.parents('li').eq(0).offset().left,
						elem_width = elem.parents('li').eq(0).outerWidth(),
						ul_width = elem.outerWidth();

					if (elem.hasClass('iqonic-megamenu-container')) {
						if (elem.hasClass('iqonic-full-width')) {
							jQuery('.iqonic-megamenu-container.iqonic-full-width').css({
								'left': -elem_offset,
							});
						}
						if (elem.hasClass('iqonic-container-width')) {
							let containerOffset = (elem.closest('.elementor-container').length > 0) ? elem.closest('.elementor-container').offset() : elem.parents('li').eq(0).closest('header .container-fluid nav,header .container nav').offset();
							jQuery('.iqonic-megamenu-container.iqonic-container-width').css({
								'left': -(elem_offset - containerOffset.left)
							});
						}
					}
					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-main');
						elem.css({
							'left': 'auto',
							'right': '0'
						});
					} else {
						elem.removeClass('open-submenu-main');
						elem.css({});
					}
				}
				if (elem.parents("ul").length > 1) {
					var page_width = jQuery('#page.site').width();
					elem_offset = elem.parents("ul").eq(0).offset().left;
					elem_width = elem.parents("ul").eq(0).outerWidth();
					ul_width = elem.outerWidth();

					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-left');
						elem.css({
							'left': 'auto',
							'right': '100%'
						});
					} else {
						elem.removeClass('open-submenu-left');
					}
				}
			},
		});

		/*------------------------
			Wow Animation
		--------------------------*/
		jQuery(window).on('resize', function () {
			"use strict";
			jQuery('.widget .ion-ios-arrow-down, #main .ion-ios-arrow-down').on('click', function () {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			});
			jQuery("#top-menu .menu-item .toggledrop").off("click");
			if (jQuery(window).width() < 1200) {
				jQuery('#top-menu .menu-item .toggledrop').on('click', function (e) {
					e.preventDefault();
					jQuery(this).next('.children, .sub-menu').slideToggle();
				});
			}
		});

		/*------------------------
			Comment Form validation
		--------------------------*/
		if (jQuery('.validate-form').length > 0) {
			jQuery('.validate-form #commentform').submit(function () {
				jQuery('.error-msg').hide();
				var cmnt = jQuery.trim(jQuery(".validate-form #comment").val());
				var error = '';
				if (jQuery(".validate-form #author").length > 0) {
					var author = jQuery.trim(jQuery(".validate-form #email").val());
					var email = jQuery.trim(jQuery(".validate-form #author").val());
					var url = jQuery.trim(jQuery(".validate-form #url").val());
					jQuery(".validate-form #comment,.validate-form #author,.validate-form #email,.validate-form #url").removeClass('iq-warning');

					if (cmnt === "") {
						jQuery(".validate-form #comment").addClass('iq-warning');
						error = '1';
					}
					if (author === "") {
						jQuery(".validate-form #author").addClass('iq-warning');
						error = '1';
					}
					if (email === "") {
						jQuery(".validate-form #email").addClass('iq-warning');
						error = '1';
					}
					if (url === "") {
						jQuery(".validate-form #url").addClass('iq-warning');
						error = '1';
					}

				} else {
					jQuery(".validate-form #comment").removeClass('iq-warning');
					if (cmnt === "") {
						jQuery(".validate-form #comment").addClass('iq-warning');
						error = '1';
						mfp - close
						if (error !== '' && error === '1') {
							jQuery('.error-msg').html('One or more fields have an error. Please check and try again.');
							jQuery('.error-msg').slideDown();
							return false;
						}
					}
				}

			});
		}

		/*------------------------
		Add to cart with plus minus
		--------------------------*/
		jQuery(document).on('click', 'button.plus, button.minus', function () {

			jQuery('button[name="update_cart"]').removeAttr('disabled');

			var qty = jQuery(this).closest('.quantity').find('.qty');


			if (qty.val() == '') {
				qty.val(0);
			}
			var val = parseFloat(qty.val());

			var max = parseFloat(qty.attr('max'));
			var min = parseFloat(qty.attr('min'));
			var step = parseFloat(qty.attr('step'));

			// Change the value if plus or minus
			if (jQuery(this).is('.plus')) {
				if (max && (max <= val)) {
					qty.val(max);
				} else {
					qty.val(val + step);
				}
			} else {
				if (min && (min >= val)) {

					qty.val(min);
				} else if (val >= 1) {

					qty.val(val - step);
				}
			}
		});

		/*-----------------------------------------------------------------------
								Select2 
		-------------------------------------------------------------------------*/
		if (jQuery('select').length > 0) {
			jQuery('select').each(function () {
				jQuery(this).select2({
					width: '100%'
				});
			});
			jQuery('.select2-container').addClass('wide');
		}

		/*-----------------------------------------------------------------------
		quickview select2
		-------------------------------------------------------------------------*/
		jQuery(document.body).on('woosq_loaded woosq_close', function () {
			jQuery('select').each(function () {
				jQuery('#woosq-popup select').select2({
					width: '100%',
				});
			});
			jQuery('.select2-container').addClass('wide');
		});

		jQuery(window).on('click', function (e) {
			let target = jQuery(e.target);
			if (!target.closest(".search_form_wrap.iq-show").length) {
				jQuery('.search_form_wrap.iq-show').removeClass('iq-show');
			}

			if (!target.closest(".header-user-rights.iq-show").length) {
				jQuery('.header-user-rights.iq-show').removeClass('iq-show');
			}
		});
		setTimeout(revSlider, 3000);
	});

	jQuery(document).ready(function () {
		setTimeout(function () {
			DirLoad();
		}, 500);
		jQuery(window).resize(revSlider);
	});
}(jQuery));

function getDefaultMenu() {
	jQuery('.menu-style-one nav.mobile-menu .sub-menu').css('display', 'none ');
	jQuery('.menu-style-one nav.mobile-menu .top-menu li .dropdown').hide();
	jQuery('.menu-style-one nav.mobile-menu .sub-menu').prev().prev().addClass('submenu');
	jQuery('.menu-style-one nav.mobile-menu .sub-menu').before('<span class="toggledrop"><i class="fas fa-chevron-right"></i></span>');

	jQuery('nav.mobile-menu .widget i,nav.mobile-menu .top-menu i').on('click', function () {
		jQuery(this).next('.children, .sub-menu').slideToggle();
	});
	jQuery('.menu-style-one nav.mobile-menu .top-menu .menu-item .toggledrop').off('click');
	jQuery('.menu-style-one nav.mobile-menu .menu-item .toggledrop').on('click', function () {
		if (jQuery(this).closest(".menu-is--open").length == 0) {
			jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-is--open');
		}
		if (jQuery(this).parent().find("ul").length > 1) {
			jQuery(this).parent().addClass('menu-is--open');
		}
		jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .children,.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .sub-menu').slideUp();
		if (!jQuery(this).next('.children, .sub-menu').is(':visible') || jQuery(this).parent().hasClass("menu-is--open")) {
			jQuery(this).next('.children, .sub-menu').slideToggle();
		}
		jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .toggledrop').not(jQuery(this)).removeClass('active');

		jQuery(this).toggleClass('active');

		jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-clicked');
		jQuery(this).parent().addClass('menu-clicked');

		jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('current-menu-ancestor');
	});

	jQuery(document).on('change input', 'input.qty', function () {
		set_quanity(jQuery(this));
	});

	jQuery(document).on('added_to_cart', function (a, b, c, d) {
		jQuery('*[title]').tooltip('disable');
	});

	//cart products count on plus minus
	jQuery(document).on('removed_from_cart added_to_cart', function (e) {
		set_quanity(jQuery('input.qty'));
	});
}

/*---------------------------------------------------------------------
RTL Switch Mode
---------------------------------------------------------------------*/
function DirLoad() {

	const DirMode = document.getElementsByTagName("html")[0].getAttribute('dir');
	const LangElements = jQuery(".elementor-section-stretched");

	const RTLgetCss = (document.getElementById('bootstrap-css')) ? document.getElementById('bootstrap-css') : null;

	const r_url = RTLgetCss.getAttribute('href');
	const path = document.getElementsByTagName("html")[0].getAttribute("data-path");
	const version = document.getElementsByTagName("html")[0].getAttribute("data-version");

	if (DirMode == 'rtl') {
		const rb_url = RTLgetCss.setAttribute('href', (path + 'vendor/bootstrap.rtl.min.css' + '?ver=' + version));
		RTLgetCss.toString().replace(r_url, rb_url);
		LangElements.each(function (index, key) {
			LangElements[index].style.right = jQuery(this).css("left");
			LangElements[index].style.left = 'auto';
		});
		jQuery('body').addClass('rtl');
	}
	jQuery(window).trigger('resize');
}

function revSlider() {
	const DirMode = document.getElementsByTagName("html")[0].getAttribute('dir');

	if (DirMode == 'rtl') {
		const revSlider = jQuery('.rs-parallax-wrap');
		revSlider.each(function (key) {
			let left = revSlider[key].style.left;
			revSlider[key].style.right = revSlider[key].style.left;
			revSlider[key].style.left = left;
		});
	}
}

// Wocomerce Set Quantiy Input
function set_quanity(this_) {
	if (!this_.hasClass('qty')) {
		this_ = this_.siblings('input.qty');
	}
	let current = this_.attr('name');

	let item_hash = current ? current.replace(/cart\[([\w]+)\]\[qty\]/g, "$1") : false;

	let item_quantity = this_.val();
	let currentVal = parseFloat(item_quantity);

	jQuery.ajax({
		type: 'POST',
		url: kivicare_loadmore_params.ajaxurl,
		data: {
			action: 'qty_cart',
			hash: item_hash,
			quantity: currentVal
		},
		success: function (res) {
			jQuery(document.body).trigger('wc_fragment_refresh');
			jQuery('.cart-items-count').html(res['data']['quantity']);
			jQuery('.cart-items-count').each(function () {
				if (jQuery(this).text().trim() == 0) {
					jQuery('.basket-item-count').css('display', 'none');
				} else {
					jQuery('.basket-item-count').css('display', 'inline');
				}
			});
		}
	});
}