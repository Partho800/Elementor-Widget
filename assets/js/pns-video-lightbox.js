/**
 * PNS Addons - Video Lightbox Script
 * Handles video lightbox/modal for Process Steps and What We Do widgets.
 */
jQuery(document).ready(function($) {
	if (!window.ceVideoLightboxInitialized) {
		window.ceVideoLightboxInitialized = true;

		// Attach click listener for video triggers
		$(document).on('click', '.ce-process-video-trigger', function(e) {
			e.preventDefault();
			var $trigger = $(this);
			var videoSource = $trigger.attr('data-video-source');
			var videoUrl = $trigger.attr('data-video-url');

			if (!videoUrl) return;

			var $lightbox = $('.ce-video-lightbox');
			var $container = $lightbox.find('.ce-video-lightbox-container');
			$container.empty();

			if (videoSource === 'external') {
				var embedUrl = '';
				if (videoUrl.indexOf('youtube.com') !== -1 || videoUrl.indexOf('youtu.be') !== -1 || videoUrl.indexOf('youtube-nocookie.com') !== -1) {
					var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|\/shorts\/)([^#&?]*).*/;
					var match = videoUrl.match(regExp);
					if (match && match[2].length === 11) {
						embedUrl = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&rel=0';
					}
				} else if (videoUrl.indexOf('vimeo.com') !== -1) {
					var regExpV = /vimeo\.com\/(?:video\/)?([0-9]+)/;
					var matchV = videoUrl.match(regExpV);
					if (matchV) {
						embedUrl = 'https://player.vimeo.com/video/' + matchV[1] + '?autoplay=1';
					}
				}

				if (embedUrl) {
					$container.html('<iframe src="' + embedUrl + '" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
				} else if (/\.(mp4|webm|ogg|ogv)($|\?)/i.test(videoUrl)) {
					$container.html('<video src="' + videoUrl + '" controls autoplay style="width:100%;height:100%;object-fit:contain;"></video>');
				} else {
					$container.html('<iframe src="' + videoUrl + '" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
				}
			} else if (videoSource === 'self_hosted') {
				$container.html('<video src="' + videoUrl + '" controls autoplay style="width:100%;height:100%;object-fit:contain;"></video>');
			}

			$lightbox.addClass('ce-active');
			$('body').css('overflow', 'hidden');
		});

		// Close lightbox listeners
		$(document).on('click', '.ce-video-lightbox-close, .ce-video-lightbox-overlay', function() {
			var $lightbox = $('.ce-video-lightbox');
			$lightbox.removeClass('ce-active');
			$lightbox.find('.ce-video-lightbox-container').empty();
			$('body').css('overflow', '');
		});

		// Close on ESC keypress
		$(document).on('keydown', function(e) {
			if (e.key === 'Escape') {
				var $lightbox = $('.ce-video-lightbox');
				if ($lightbox.hasClass('ce-active')) {
					$lightbox.removeClass('ce-active');
					$lightbox.find('.ce-video-lightbox-container').empty();
					$('body').css('overflow', '');
				}
			}
		});
	}
});
