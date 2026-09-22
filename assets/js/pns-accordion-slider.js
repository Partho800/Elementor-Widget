/**
 * PNS Accordion Slider Widget - JavaScript
 * Handles hover-expand accordion effect and optional Swiper carousel.
 */
(function ($) {
	'use strict';

	function initAccordion($wrapper) {
		var $items = $wrapper.find('.mss-accordion-item');
		var hoverTimer = null;
		var leaveTimer = null;

		// Set first item active on load
		$items.first().addClass('active');

		$items.on('mouseenter', function () {
			if ($wrapper.hasClass('mss-accordion-carousel')) return;
			clearTimeout(hoverTimer);
			clearTimeout(leaveTimer);
			var $hovered = $(this);
			hoverTimer = setTimeout(function () {
				$items.removeClass('active');
				$hovered.addClass('active');
			}, 60);
		});

		$wrapper.on('mouseleave', function () {
			if ($wrapper.hasClass('mss-accordion-carousel')) return;
			clearTimeout(hoverTimer);
			leaveTimer = setTimeout(function () {
				$items.removeClass('active');
				$items.first().addClass('active');
			}, 80);
		});
	}

	function initAllAccordions() {
		$('.mss-accordion-wrapper').each(function () {
			var $this = $(this);

			// Prevent double-initialization
			if ($this.data('pns-accordion-init')) return;
			$this.data('pns-accordion-init', true);

			initAccordion($this);

			// Carousel mode
			if ($this.hasClass('mss-accordion-carousel') && typeof Swiper !== 'undefined') {
				var slidesPerView = parseInt($this.data('slides') || 3, 10);
				new Swiper($this[0], {
					slidesPerView: slidesPerView,
					spaceBetween: 20,
					loop: true,
					pagination: { el: $this.find('.swiper-pagination')[0], clickable: true },
					navigation: {
						nextEl: $this.find('.swiper-button-next')[0],
						prevEl: $this.find('.swiper-button-prev')[0],
					},
					breakpoints: {
						320: { slidesPerView: 1 },
						768: { slidesPerView: 2 },
						1024: { slidesPerView: slidesPerView },
					},
				});
			}
		});
	}

	$(document).ready(function () {
		initAllAccordions();
	});

	// Re-init on Elementor frontend edit mode
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/mss_accordion_slider_widget.default',
			function ($scope) {
				var $wrapper = $scope.find('.mss-accordion-wrapper');
				$wrapper.removeData('pns-accordion-init');
				initAllAccordions();
			}
		);
	});

})(jQuery);
