/**
 * PNS Addons for Elementor - Editor Helper Script
 * Ensures "PNS Addons" category is placed at the very top of the Elementor widget panel.
 */
(function ($) {
	'use strict';

	function reorderCategoriesConfig() {
		if (
			window.elementor &&
			elementor.config &&
			elementor.config.document &&
			elementor.config.document.panel &&
			elementor.config.document.panel.elements_categories
		) {
			var categories = elementor.config.document.panel.elements_categories;
			if (categories['pns-addons-category']) {
				var pnsCat = categories['pns-addons-category'];
				delete categories['pns-addons-category'];

				// Place pns-addons-category at the very top of the categories object
				elementor.config.document.panel.elements_categories = Object.assign(
					{ 'pns-addons-category': pnsCat },
					categories
				);
			}
		}
	}

	function movePnsCategoryToTop() {
		var $pnsCategory = $('#elementor-panel-category-pns-addons-category');
		var $categoriesWrap = $('#elementor-panel-categories');

		if ($pnsCategory.length && $categoriesWrap.length) {
			if ($pnsCategory.index() !== 0) {
				$categoriesWrap.prepend($pnsCategory);
			}
		}
	}

	// Hook into Elementor init
	$(window).on('elementor:init', function () {
		reorderCategoriesConfig();

		if (window.elementor && elementor.channels && elementor.channels.panelElements) {
			elementor.channels.panelElements.on('element:selected', function () {
				setTimeout(movePnsCategoryToTop, 50);
			});
		}
	});

	// Observe DOM to handle dynamic panel category renders
	$(document).ready(function () {
		reorderCategoriesConfig();

		var panelEl = document.getElementById('elementor-panel');
		if (panelEl && window.MutationObserver) {
			var observer = new MutationObserver(function () {
				movePnsCategoryToTop();
			});
			observer.observe(panelEl, { childList: true, subtree: true });
		}

		// Initial check intervals
		var checkCount = 0;
		var interval = setInterval(function () {
			reorderCategoriesConfig();
			movePnsCategoryToTop();
			checkCount++;
			if (checkCount > 20) {
				clearInterval(interval);
			}
		}, 250);
	});
})(jQuery);
