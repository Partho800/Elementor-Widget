(function ($) {
    'use strict';

    var PNSFaqHandler = function ($scope, $) {
        var $container = $scope.find('.pns-faq-container');
        if (!$container.length) {
            return;
        }

        var isAccordion = $container.data('accordion') === 'yes';
        var $items = $container.find('.pns-faq-item');
        var $searchInput = $container.find('.pns-faq-search-input');
        var $noResults = $container.find('.pns-faq-no-results');

        // Toggle click handler
        $items.find('.pns-faq-question').off('click').on('click', function (e) {
            e.preventDefault();
            var $item = $(this).closest('.pns-faq-item');
            var isActive = $item.hasClass('pns-faq-active');

            if (isAccordion) {
                // Close other open items
                $items.not($item).removeClass('pns-faq-active').find('.pns-faq-question').attr('aria-expanded', 'false');
            }

            if (isActive) {
                $item.removeClass('pns-faq-active');
                $(this).attr('aria-expanded', 'false');
            } else {
                $item.addClass('pns-faq-active');
                $(this).attr('aria-expanded', 'true');
            }
        });

        // Search live filter handler
        if ($searchInput.length) {
            $searchInput.off('keyup input').on('keyup input', function () {
                var query = $(this).val().toLowerCase().trim();
                var matchedCount = 0;

                $items.each(function () {
                    var $this = $(this);
                    var titleText = $this.find('.pns-faq-title').text().toLowerCase();
                    var answerText = $this.find('.pns-faq-answer-inner').text().toLowerCase();

                    if (!query || titleText.indexOf(query) !== -1 || answerText.indexOf(query) !== -1) {
                        $this.removeClass('pns-faq-hidden');
                        matchedCount++;
                        // If searching with active query, auto-expand matching item
                        if (query) {
                            $this.addClass('pns-faq-active').find('.pns-faq-question').attr('aria-expanded', 'true');
                        }
                    } else {
                        $this.addClass('pns-faq-hidden');
                    }
                });

                if (matchedCount === 0 && query !== '') {
                    $noResults.show();
                } else {
                    $noResults.hide();
                }
            });
        }
    };

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/pns_faq_widget.default', PNSFaqHandler);
        }
    });

    $(document).ready(function () {
        $('.pns-faq-container').each(function () {
            PNSFaqHandler($(this).closest('.elementor-widget'), $);
        });
    });

})(jQuery);