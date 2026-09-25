/**
 * PNS Addons for Elementor - Video Card Widget Script
 * Handles responsive video popup modal without inline script injection.
 */
(function ($) {
	'use strict';

	$(document).ready(function () {
		// Open Video Modal
		$(document).on('click', '.mss-vc-play-btn', function (e) {
			e.preventDefault();
			var $btn = $(this);
			var widgetId = $btn.data('widget-id');
			var videoId = $btn.data('video-id');
			var $modal = $('#mss-video-modal-' + widgetId);

			if ($modal.length && !$modal.parent().is('body')) {
				$('body').append($modal);
			}

			var $iframe = $('#mss-iframe-' + widgetId);
			if (videoId && $modal.length) {
				$iframe.attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&showinfo=0');
				$modal.fadeIn(300);
				$('body').css('overflow', 'hidden');
			}
		});

		// Close Video Modal on button click
		$(document).on('click', '.mss-video-close', function (e) {
			e.preventDefault();
			var $modal = $(this).closest('.mss-video-modal');
			$modal.fadeOut(300, function () {
				$modal.find('iframe').attr('src', '');
				$('body').css('overflow', '');
			});
		});

		// Close Video Modal on backdrop click
		$(document).on('click', '.mss-video-modal', function (e) {
			if ($(e.target).hasClass('mss-video-modal')) {
				$(this).find('.mss-video-close').trigger('click');
			}
		});

		// Close on ESC key
		$(document).on('keydown', function (e) {
			if (e.key === 'Escape') {
				var $openModals = $('.mss-video-modal:visible');
				if ($openModals.length) {
					$openModals.find('.mss-video-close').trigger('click');
				}
			}
		});
	});
})(jQuery);
