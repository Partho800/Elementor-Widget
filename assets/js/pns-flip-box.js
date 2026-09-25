/**
 * PNS Addons for Elementor - 3D Flip Box Script
 * Version: 1.0.0
 * Author: PNS Addons
 */
(function ($) {
    'use strict';

    var PNSFlipBoxHandler = function ($scope, $) {
        var $flipBoxes = $scope.find('.pns-flip-box');
        if (!$flipBoxes.length) {
            return;
        }

        $flipBoxes.each(function () {
            var $box = $(this);
            var trigger = $box.data('trigger') || 'hover';
            var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

            // Touch screen tap support or click trigger
            if (isTouch || trigger === 'click') {
                $box.off('click.pnsFlip').on('click.pnsFlip', function (e) {
                    // If clicking the action button itself, allow link navigation
                    if ($(e.target).closest('.pns-flip-box-btn').length) {
                        return;
                    }

                    e.preventDefault();
                    var isFlipped = $box.hasClass('pns-is-flipped');

                    // If click trigger, close other flip boxes in same column/row if desired
                    $('.pns-flip-box').not($box).removeClass('pns-is-flipped');

                    if (isFlipped) {
                        $box.removeClass('pns-is-flipped');
                    } else {
                        $box.addClass('pns-is-flipped');
                    }
                });
            }
        });

        // Close when clicking outside on mobile
        $(document).off('click.pnsFlipOutside').on('click.pnsFlipOutside', function (e) {
            if (!$(e.target).closest('.pns-flip-box').length) {
                $('.pns-flip-box.pns-is-flipped').removeClass('pns-is-flipped');
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/pns_flip_box_widget.default', PNSFlipBoxHandler);
        }
    });

    $(document).ready(function () {
        $('.pns-flip-box-wrapper').each(function () {
            PNSFlipBoxHandler($(this).closest('.elementor-widget'), $);
        });
    });

})(jQuery);
