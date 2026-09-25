/**
 * PNS Addons for Elementor - Progress Bar & Circular Progress Script
 * Version: 1.0.0
 * Author: PNS Addons
 */
(function ($) {
    'use strict';

    var PNSProgressBarHandler = function ($scope, $) {
        var $wrapper = $scope.find('.pns-progress-wrapper');
        if (!$wrapper.length) {
            return;
        }

        var isEditMode = Boolean(window.elementorFrontend && elementorFrontend.isEditMode && elementorFrontend.isEditMode());
        var duration = parseInt($wrapper.data('duration'), 10) || 1200;

        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }

        function animateCounter($numEl, targetVal, animDuration) {
            if (!$numEl.length) return;
            var startVal = 0;
            var startTime = null;

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / animDuration, 1);
                var eased = easeOutCubic(progress);
                var current = Math.round(startVal + (targetVal - startVal) * eased);
                $numEl.text(current);

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    $numEl.text(targetVal);
                }
            }

            window.requestAnimationFrame(step);
        }

        function animateLinearItem($item) {
            if ($item.hasClass('pns-animated')) return;
            $item.addClass('pns-animated');

            var percentage = parseFloat($item.data('percentage')) || 0;
            var $fill = $item.find('.pns-progress-fill');
            var $num = $item.find('.pns-progress-number');

            // Animate bar width
            $fill.css('width', percentage + '%');

            // Animate counter text
            animateCounter($num, percentage, duration);
        }

        function animateCircularItem($item) {
            if ($item.hasClass('pns-animated')) return;
            $item.addClass('pns-animated');

            var percentage = parseFloat($item.data('percentage')) || 0;
            var gauge = $item.data('gauge') || 'circle';
            var $bar = $item.find('.pns-circle-bar');
            var $num = $item.find('.pns-progress-number');

            var radius = 45;
            var circumference = 2 * Math.PI * radius; // ~282.743
            var maxArc = circumference;

            if (gauge === 'semi') {
                maxArc = circumference * 0.5; // 180 deg = ~141.37
            } else if (gauge === 'arch') {
                maxArc = circumference * (240 / 360); // 240 deg = ~188.5
            }

            // Target stroke-dashoffset
            var targetOffset = maxArc - (percentage / 100) * maxArc;

            // Set initial state
            $bar.css({
                'stroke-dasharray': maxArc + ' ' + circumference,
                'stroke-dashoffset': maxArc
            });

            // Trigger CSS animation on next tick
            setTimeout(function () {
                $bar.css({
                    'transition': 'stroke-dashoffset ' + (duration / 1000) + 's cubic-bezier(0.16, 1, 0.3, 1)',
                    'stroke-dashoffset': targetOffset
                });
            }, 30);

            // Animate counter
            animateCounter($num, percentage, duration);
        }

        function runAnimation() {
            // Linear Bars
            $wrapper.find('.pns-progress-linear-item').each(function () {
                animateLinearItem($(this));
            });

            // Circular Items
            $wrapper.find('.pns-progress-circular-item').each(function () {
                animateCircularItem($(this));
            });
        }

        // Viewport detection
        if (isEditMode || !('IntersectionObserver' in window)) {
            runAnimation();
        } else {
            var observer = new IntersectionObserver(function (entries, obs) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        runAnimation();
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            observer.observe($wrapper[0]);
        }
    };

    $(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/pns_progress_bar_widget.default', PNSProgressBarHandler);
        }
    });

    $(document).ready(function () {
        $('.pns-progress-wrapper').each(function () {
            PNSProgressBarHandler($(this).closest('.elementor-widget'), $);
        });
    });

})(jQuery);
