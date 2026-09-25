(function ($) {
    'use strict';

    var PNSPricingTableHandler = function ($scope, $) {
        var $wrapper = $scope.find('.pns-pricing-table-wrapper');
        if (!$wrapper.length) {
            return;
        }

        // Initialize billing switcher buttons
        var $switcher = $wrapper.find('.pns-pricing-switcher');
        if ($switcher.length) {
            $switcher.find('.pns-pricing-switch-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var $btn = $(this);
                if ($btn.hasClass('active')) {
                    return;
                }

                var period = $btn.data('period'); // "1" or "2"
                var syncGroup = $wrapper.data('sync-group');

                var $targetWrappers = $wrapper;
                if (syncGroup) {
                    $targetWrappers = $('[data-sync-group="' + syncGroup + '"]');
                }

                $targetWrappers.each(function () {
                    var $wrap = $(this);
                    
                    // Update active button state
                    $wrap.find('.pns-pricing-switch-btn').removeClass('active');
                    $wrap.find('.pns-pricing-switch-btn[data-period="' + period + '"]').addClass('active');

                    // Switch price blocks with smooth animation
                    var $periodPrices = $wrap.find('.pns-period-price');
                    $periodPrices.removeClass('active');
                    $wrap.find('.pns-period-' + period).addClass('active');

                    // Switch button URLs if period-specific URLs are provided
                    $wrap.find('.pns-pricing-btn').each(function () {
                        var $linkBtn = $(this);
                        var url = $linkBtn.attr('data-url-period-' + period);
                        if (url && url.length > 0) {
                            $linkBtn.attr('href', url);
                        }
                    });
                });
            });
        }

        // Tooltip touch toggle support for mobile devices
        $wrapper.find('.pns-feature-tooltip-trigger').off('click').on('click', function (e) {
            if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
                e.preventDefault();
                e.stopPropagation();
                var $tooltip = $(this).find('.pns-feature-tooltip-content');
                var isVisible = $tooltip.css('opacity') === '1';

                $('.pns-feature-tooltip-content').css({ 'opacity': '0', 'visibility': 'hidden' });

                if (!isVisible) {
                    $tooltip.css({ 'opacity': '1', 'visibility': 'visible', 'transform': 'translateX(-50%) translateY(0)' });
                }
            }
        });

        $(document).on('click', function () {
            $('.pns-feature-tooltip-content').removeAttr('style');
        });
    };

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/pns_pricing_table_widget.default', PNSPricingTableHandler);
        }
    });

    $(document).ready(function () {
        $('.pns-pricing-table-wrapper').each(function () {
            PNSPricingTableHandler($(this).closest('.elementor-widget'), $);
        });
    });

})(jQuery);
