/**
 * PNS Addons for Elementor - Pricing Table Interactive Switcher
 */
(function($) {
	'use strict';

	var PNS_Pricing_Table_Handler = function($scope, $) {
		var $wrapper = $scope.find('.pns-pricing-table-card');
		if (!$wrapper.length) {
			return;
		}

		$wrapper.each(function() {
			var $card = $(this);
			var $switcher = $card.find('.pns-pricing-switcher');

			if (!$switcher.length) {
				return;
			}

			var $options = $switcher.find('.pns-pricing-switcher-option');
			var $amount = $card.find('.pns-pricing-amount');
			var $originalPrice = $card.find('.pns-pricing-original-price');
			var $period = $card.find('.pns-pricing-period');
			var $button = $card.find('.pns-pricing-button');

			var monthlyPrice = $amount.data('monthly-price');
			var yearlyPrice = $amount.data('yearly-price');
			var monthlyOriginal = $originalPrice.data('monthly-original');
			var yearlyOriginal = $originalPrice.data('yearly-original');
			var monthlyPeriod = $period.data('monthly-period');
			var yearlyPeriod = $period.data('yearly-period');
			var monthlyLink = $button.data('monthly-link');
			var yearlyLink = $button.data('yearly-link');

			$options.on('click', function(e) {
				e.preventDefault();
				var $clicked = $(this);
				if ($clicked.hasClass('is-active')) {
					return;
				}

				$options.removeClass('is-active');
				$clicked.addClass('is-active');

				var period = $clicked.data('period');

				$amount.css({ opacity: 0, transform: 'translateY(-4px)' });
				if ($originalPrice.length) {
					$originalPrice.css({ opacity: 0 });
				}

				setTimeout(function() {
					if (period === 'yearly') {
						$card.addClass('is-yearly-active');
						if (yearlyPrice !== undefined) {
							$amount.text(yearlyPrice);
						}
						if ($originalPrice.length && yearlyOriginal !== undefined) {
							$originalPrice.text(yearlyOriginal);
						}
						if ($period.length && yearlyPeriod !== undefined) {
							$period.text(yearlyPeriod);
						}
						if ($button.length && yearlyLink) {
							$button.attr('href', yearlyLink);
						}
					} else {
						$card.removeClass('is-yearly-active');
						if (monthlyPrice !== undefined) {
							$amount.text(monthlyPrice);
						}
						if ($originalPrice.length && monthlyOriginal !== undefined) {
							$originalPrice.text(monthlyOriginal);
						}
						if ($period.length && monthlyPeriod !== undefined) {
							$period.text(monthlyPeriod);
						}
						if ($button.length && monthlyLink) {
							$button.attr('href', monthlyLink);
						}
					}

					$amount.css({ opacity: 1, transform: 'translateY(0)' });
					if ($originalPrice.length) {
						$originalPrice.css({ opacity: 1 });
					}
				}, 150);
			});
		});
	};

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/pns_pricing_table.default', PNS_Pricing_Table_Handler);
	});

	// Support normal non-elementor frontend or instant init
	$(document).ready(function() {
		if (typeof elementorFrontend === 'undefined') {
			PNS_Pricing_Table_Handler($('body'), $);
		}
	});

})(jQuery);
