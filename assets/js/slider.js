/**
 * PNS Addons for Elementor - Modern Slider Widget Script
 * Handles interactive slide navigation and autoplay for Modern Slider widgets.
 */
(function ($) {
	'use strict';

	function initSlider($container) {
		var $slideList = $container.find('.mss-slide-list');
		var $nextBtn   = $container.find('.mss-next');
		var $prevBtn   = $container.find('.mss-prev');

		if (!$slideList.length || !$nextBtn.length || !$prevBtn.length) {
			return;
		}

		$nextBtn.off('click.pnsSlider').on('click.pnsSlider', function () {
			var $items = $slideList.find('.mss-item');
			if ($items.length > 1) {
				$slideList.append($items.first());
			}
		});

		$prevBtn.off('click.pnsSlider').on('click.pnsSlider', function () {
			var $items = $slideList.find('.mss-item');
			if ($items.length > 1) {
				$slideList.prepend($items.last());
			}
		});

		// Autoplay logic
		var autoPlayTimer = null;
		function startAutoPlay() {
			if (!autoPlayTimer) {
				autoPlayTimer = setInterval(function () {
					$nextBtn.trigger('click.pnsSlider');
				}, 6000);
			}
		}

		function stopAutoPlay() {
			if (autoPlayTimer) {
				clearInterval(autoPlayTimer);
				autoPlayTimer = null;
			}
		}

		startAutoPlay();

		$container.hover(stopAutoPlay, startAutoPlay);
	}

	$(document).ready(function () {
		$('.mss-main-container').each(function () {
			initSlider($(this));
		});
	});

	// Support Elementor Frontend hooks
	$(window).on('elementor/frontend/init', function () {
		if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction('frontend/element_ready/mss_slider_widget.default', function ($scope) {
				$scope.find('.mss-main-container').each(function () {
					initSlider($(this));
				});
			});
		}
	});
})(jQuery);
