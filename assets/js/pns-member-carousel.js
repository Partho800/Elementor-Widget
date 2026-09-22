/**
 * PNS Member Carousel Widget (Premium Carousel) - JavaScript
 * Handles Swiper initialization for frontend and Elementor Editor live preview.
 */
(function ($) {
	'use strict';

	function initMemberCarousel($scope) {
		var $wrappers = $scope.find('.mss-premium-carousel-wrapper');
		if (!$wrappers.length && $scope.hasClass('mss-premium-carousel-wrapper')) {
			$wrappers = $scope;
		}

		$wrappers.each(function () {
			var $wrapper = $(this);
			var $container = $wrapper.find('.mss-pc-swiper');

			if (!$container.length || typeof Swiper === 'undefined') {
				return;
			}

			// Destroy existing Swiper instance if re-initializing in Elementor editor
			if ($container[0] && $container[0].swiper) {
				$container[0].swiper.destroy(true, true);
			}

			var settings = $wrapper.data('settings') || {};

			var nextEl = $wrapper.find('.mss-pc-next')[0];
			var prevEl = $wrapper.find('.mss-pc-prev')[0];
			var pagEl  = $wrapper.find('.mss-pc-pagination')[0];

			var swiperOptions = $.extend({}, settings, {
				navigation: {
					nextEl: nextEl || null,
					prevEl: prevEl || null,
				},
				pagination: {
					el: pagEl || null,
					clickable: true,
				},
			});

			try {
				new Swiper($container[0], swiperOptions);
			} catch (e) {
				console.error('Member Carousel Swiper error:', e);
			}
		});
	}

	$(document).ready(function () {
		initMemberCarousel($(document));
	});

	$(window).on('elementor/frontend/init', function () {
		if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/mss_premium_carousel.default',
				function ($scope) {
					initMemberCarousel($scope);
				}
			);
		}
	});

})(jQuery);
