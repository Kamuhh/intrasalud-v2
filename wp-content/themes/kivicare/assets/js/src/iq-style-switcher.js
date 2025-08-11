
const mode = (document.querySelector('.iq-theme-feature')) ? document.querySelector('.iq-theme-feature') : null;
if (mode != null) {
	const setting_options = (document.querySelector('meta[name="setting_options"]')) ? document.querySelector('meta[name="setting_options"]') : null;

	const switchPanel = document.querySelector('.iq-switchbuttontoggler');
	switchPanel.addEventListener('click', () => {
		mode.classList.toggle('open');
	});


	document.getElementById('switch-mode').onchange = function (e) {
		if (e.target.tagName.toLowerCase() === 'input') {
			const bgClass = e.target.value;
			if (setting_options !== null) {
				const LangElements = Array.from(document.getElementsByClassName("elementor-section-stretched"));
				const version = setting_options.getAttribute("data-version");
				const path = setting_options.getAttribute("data-path");
				const RTLgetCss = (document.getElementById('bootstrap-css')) ? document.getElementById('bootstrap-css') : null;
				if (RTLgetCss != null) {
					const r_url = RTLgetCss.getAttribute('href');
					if (bgClass == "rtl") {
						jQuery('body').addClass('rtl');
						const rb_url = RTLgetCss.setAttribute('href', (path + 'vendor/bootstrap.rtl.min.css' + '?ver=' + version));
						RTLgetCss.toString().replace(r_url, rb_url);
						for (let i = 0; i < LangElements.length; i++) {
							LangElements[i].style.right = LangElements[i].style.left;
							LangElements[i].style.left = 'auto';
						}
					} else {
						jQuery('body').removeClass('rtl');
						const rb_url = RTLgetCss.setAttribute('href', (path + 'vendor/bootstrap.min.css' + '?ver=' + version));
						RTLgetCss.toString().replace(r_url, rb_url);
						for (let i = 0; i < LangElements.length; i++) {
							LangElements[i].style.left = LangElements[i].style.right;
							LangElements[i].style.right = 'auto';
						}
					}
				}
			}

			document.getElementsByTagName("html")[0].setAttribute('dir', bgClass);
			setCookie('theme_scheme_direction', bgClass);

			if(jQuery('.owl-carousel').length > 0) {
				callOwlCarousel();
			}
			if (jQuery('.swiper-container').length > 0) {
				callSwiper()
			}
		}
	};
}
