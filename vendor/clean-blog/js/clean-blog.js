(function ($) {
	"use strict"; // Start of use strict

	// Show the navbar when the page is scrolled up
	var MQL = 992;

	//primary navigation slide-in effect
	if ($(window).width() > MQL) {
		var headerHeight = $('#mainNav').height();
		$(window).on('scroll', {
			previousTop: 0
		},
			function () {
				var currentTop = $(window).scrollTop();
				//check if user is scrolling up
				if (currentTop < this.previousTop) {
					//if scrolling up...
					if (currentTop > 0 && $('#mainNav').hasClass('is-fixed')) {
						$('#mainNav').addClass('is-visible');
					} else {
						$('#mainNav').removeClass('is-visible is-fixed');
					}
				} else if (currentTop > this.previousTop) {
					//if scrolling down...
					$('#mainNav').removeClass('is-visible');
					if (currentTop > headerHeight && !$('#mainNav').hasClass('is-fixed')) $('#mainNav').addClass('is-fixed');
				}
				this.previousTop = currentTop;
			});
	}

	// Reset search input value on focus
	$('.search-field').focus(function () {
		this.value = '';
	});

	// Display and Slab site title text after whole page is loaded including styles
	window.addEventListener("load", () => {
		$(".site-heading").fadeIn();
		$("h1.site-title").slabText({
			"fontRatio": 0.3
		});
	}, false);

	// Slab first slide title text.
	$('h2.slide-title').slabText({
		"fontRatio": 0.3,
		"resizeThrottleTime": 0
	});
	/**
	 * Slab slide title text after first slide animation.
	 * This is for the second and third slides.
	 */
	$('.carousel').on('slid.bs.carousel', function () {
		$('h2.slide-title').slabText({
			"fontRatio": 0.3,
			"resizeThrottleTime": 0
		});
	});

})(jQuery); // End of use strict
