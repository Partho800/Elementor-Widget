/**
 * PNS Addons for Elementor - Sticky Extension JavaScript Handler
 *
 * Provides buttery-smooth, high-performance sticky functionality
 * for Sections, Containers, Columns, and Widgets.
 */
(function ($) {
	'use strict';

	/**
	 * Breakpoint helper
	 */
	function getDevice() {
		if (window.elementorFrontend && typeof elementorFrontend.getCurrentDeviceMode === 'function') {
			var mode = elementorFrontend.getCurrentDeviceMode();
			if (mode === 'mobile' || mode === 'mobile_extra') {
				return 'mobile';
			}
			if (mode === 'tablet' || mode === 'tablet_extra') {
				return 'tablet';
			}
			if (mode === 'desktop' || mode === 'laptop' || mode === 'widescreen') {
				return 'desktop';
			}
		}

		var width = window.innerWidth;
		if (width <= 767) {
			return 'mobile';
		}
		if (width <= 1024) {
			return 'tablet';
		}
		return 'desktop';
	}

	/**
	 * Check if currently in Elementor Editor
	 */
	function isEditor() {
		return $('body').hasClass('elementor-editor-active') || 
		       $('body').hasClass('elementor-editor-preview') ||
		       (window.elementorFrontend && typeof elementorFrontend.isEditMode === 'function' && elementorFrontend.isEditMode());
	}

	/**
	 * Get Admin Bar Height taking mobile behavior and scroll into account
	 */
	function getAdminBarHeight() {
		// Inside Elementor Editor preview canvas, admin bar is not inside the viewport
		if (isEditor()) {
			return 0;
		}

		var $adminBar = $('#wpadminbar');
		if (!$adminBar.length || !$adminBar.is(':visible')) {
			return 0;
		}

		var pos = $adminBar.css('position');
		var height = $adminBar.outerHeight() || 0;

		// On desktop or when fixed
		if (pos === 'fixed') {
			return height;
		}

		// On mobile (<= 600px), WordPress admin bar is absolute and scrolls off
		var scrollTop = $(window).scrollTop();
		if (scrollTop < height) {
			return Math.max(0, height - scrollTop);
		}

		return 0;
	}

	/**
	 * Helper to safely parse numeric control values and avoid NaN
	 */
	function parseControlSize(control, defaultVal) {
		if (control && control.size !== undefined && control.size !== '' && control.size !== null) {
			var num = parseFloat(control.size);
			return isNaN(num) ? defaultVal : num;
		}
		return defaultVal;
	}

	/**
	 * PNS Sticky Instance Class
	 */
	function PNSStickyItem($element) {
		this.$element = $element;
		this.$spacer  = null;
		this.config   = null;
		this.isStuck  = false;
		this.lastScrollTop = $(window).scrollTop();
		this.initialOffset = null;
		this.initialWidth  = null;
		this.initialHeight = null;

		this.init();
	}

	PNSStickyItem.prototype = {
		init: function () {
			this.loadConfig();
			if (!this.config || !this.config.sticky || this.config.sticky === 'none') {
				this.destroy();
				return;
			}

			// Check editor preview permission
			if (isEditor() && this.config.inEditor === false) {
				this.destroy();
				return;
			}

			this.createSpacer();
			this.updateDimensions();
			this.bindEvents();
			this.handleScroll();
		},

		loadConfig: function () {
			var configAttr = this.$element.attr('data-pns-sticky-config');
			if (configAttr) {
				try {
					this.config = JSON.parse(configAttr);
				} catch (e) {
					this.config = null;
				}
			}

			// In Elementor editor or live page with data-settings
			var settings = this.$element.data('settings');
			if (settings && settings.pns_sticky) {
				this.config = {
					sticky: settings.pns_sticky,
					stickyOn: settings.pns_sticky_on || ['desktop', 'tablet', 'mobile'],
					offsetTop: parseControlSize(settings.pns_sticky_offset, 0),
					offsetTopTablet: parseControlSize(settings.pns_sticky_offset_tablet, null),
					offsetTopMobile: parseControlSize(settings.pns_sticky_offset_mobile, null),
					offsetBottom: parseControlSize(settings.pns_sticky_offset_bottom, 0),
					offsetBottomTablet: parseControlSize(settings.pns_sticky_offset_bottom_tablet, null),
					offsetBottomMobile: parseControlSize(settings.pns_sticky_offset_bottom_mobile, null),
					effectsOffset: parseControlSize(settings.pns_sticky_effects_offset, 0),
					scrollUp: settings.pns_sticky_scroll_up === 'yes',
					stayInParent: settings.pns_sticky_stay_in_parent === 'yes',
					zIndex: settings.pns_sticky_z_index !== undefined && settings.pns_sticky_z_index !== '' ? parseInt(settings.pns_sticky_z_index, 10) : 999,
					inEditor: settings.pns_sticky_in_editor !== 'no'
				};
			}

			// Sanitize any NaN in config
			if (this.config) {
				if (isNaN(this.config.offsetTop)) this.config.offsetTop = 0;
				if (isNaN(this.config.offsetTopTablet)) this.config.offsetTopTablet = null;
				if (isNaN(this.config.offsetTopMobile)) this.config.offsetTopMobile = null;
				if (isNaN(this.config.offsetBottom)) this.config.offsetBottom = 0;
				if (isNaN(this.config.offsetBottomTablet)) this.config.offsetBottomTablet = null;
				if (isNaN(this.config.offsetBottomMobile)) this.config.offsetBottomMobile = null;
				if (isNaN(this.config.effectsOffset)) this.config.effectsOffset = 0;
				if (isNaN(this.config.zIndex)) this.config.zIndex = 999;
			}
		},

		createSpacer: function () {
			var $prev = this.$element.prev('.pns-sticky-spacer');
			if ($prev.length) {
				this.$spacer = $prev;
			} else {
				this.$spacer = $('<div class="pns-sticky-spacer"></div>');
				this.$element.before(this.$spacer);
			}
		},

		updateDimensions: function () {
			if (!this.isStuck) {
				this.initialOffset = this.$element.offset();
				this.initialWidth  = this.$element.outerWidth();
				this.initialHeight = this.$element.outerHeight(true);
			} else if (this.$spacer && this.$spacer.is(':visible')) {
				this.initialOffset = this.$spacer.offset();
				this.initialWidth  = this.$spacer.outerWidth();
				this.initialHeight = this.$spacer.outerHeight(true);
			}
		},

		getOffset: function (type) {
			var device = getDevice();
			if (type === 'top') {
				var val = 0;
				if (device === 'mobile') {
					val = (this.config.offsetTopMobile !== null && this.config.offsetTopMobile !== undefined && !isNaN(this.config.offsetTopMobile)) ? this.config.offsetTopMobile : 0;
				} else if (device === 'tablet') {
					val = (this.config.offsetTopTablet !== null && this.config.offsetTopTablet !== undefined && !isNaN(this.config.offsetTopTablet)) ? this.config.offsetTopTablet : (this.config.offsetTop || 0);
				} else {
					val = (this.config.offsetTop !== null && this.config.offsetTop !== undefined && !isNaN(this.config.offsetTop)) ? this.config.offsetTop : 0;
				}
				return isNaN(val) ? 0 : Math.max(0, val);
			} else {
				var bVal = 0;
				if (device === 'mobile') {
					bVal = (this.config.offsetBottomMobile !== null && this.config.offsetBottomMobile !== undefined && !isNaN(this.config.offsetBottomMobile)) ? this.config.offsetBottomMobile : 0;
				} else if (device === 'tablet') {
					bVal = (this.config.offsetBottomTablet !== null && this.config.offsetBottomTablet !== undefined && !isNaN(this.config.offsetBottomTablet)) ? this.config.offsetBottomTablet : (this.config.offsetBottom || 0);
				} else {
					bVal = (this.config.offsetBottom !== null && this.config.offsetBottom !== undefined && !isNaN(this.config.offsetBottom)) ? this.config.offsetBottom : 0;
				}
				return isNaN(bVal) ? 0 : Math.max(0, bVal);
			}
		},

		isDeviceActive: function () {
			var currentDevice = getDevice();
			var activeDevices = this.config.stickyOn || ['desktop', 'tablet', 'mobile'];
			if (typeof activeDevices === 'string') {
				activeDevices = [activeDevices];
			}
			return activeDevices.indexOf(currentDevice) !== -1;
		},

		handleScroll: function () {
			if (!this.config || !this.config.sticky) {
				return;
			}

			// Device check
			if (!this.isDeviceActive()) {
				if (this.isStuck) {
					this.unstick();
				}
				return;
			}

			var scrollTop = $(window).scrollTop();
			var windowHeight = $(window).height();
			var adminBarHeight = getAdminBarHeight();

			if (!this.initialOffset) {
				this.updateDimensions();
			}

			if (!this.initialOffset) {
				return;
			}

			if (this.config.sticky === 'top') {
				var targetOffset = this.getOffset('top') + adminBarHeight;
				var stickPoint = this.initialOffset.top - targetOffset;

				// Trigger sticky as soon as scrolled to stickPoint or past initial position
				var shouldStick = false;
				if (stickPoint <= 0) {
					shouldStick = (scrollTop > 0);
				} else {
					shouldStick = (scrollTop >= stickPoint);
				}

				if (shouldStick) {
					this.stickTop(targetOffset, scrollTop);
				} else {
					if (this.isStuck) {
						this.unstick();
					}
				}
			} else if (this.config.sticky === 'bottom') {
				var targetBottomOffset = this.getOffset('bottom');
				var elementBottom = this.initialOffset.top + this.initialHeight;
				var stickPointBottom = elementBottom - (windowHeight - targetBottomOffset);

				if (scrollTop <= stickPointBottom) {
					this.stickBottom(targetBottomOffset, scrollTop);
				} else {
					if (this.isStuck) {
						this.unstick();
					}
				}
			}

			this.lastScrollTop = scrollTop;
		},

		stickTop: function (targetOffset, scrollTop) {
			var device = getDevice();

			if (!this.isStuck) {
				this.updateDimensions();
				this.$spacer
					.css({
						height: this.initialHeight + 'px',
						width: this.initialWidth + 'px',
						margin: this.$element.css('margin'),
						display: 'block'
					});

				var cssProps = {
					position: 'fixed',
					zIndex: this.config.zIndex || 999
				};

				if (device === 'mobile') {
					cssProps.left = '0';
					cssProps.right = '0';
					cssProps.width = '100%';
				} else {
					cssProps.left = this.initialOffset.left + 'px';
					cssProps.width = this.initialWidth + 'px';
				}

				this.$element
					.addClass('pns-sticky-fixed')
					.css(cssProps);

				this.isStuck = true;
			}

			// Handle stay in parent container (only for child nested containers, not root section/e-parent)
			var computedTop = targetOffset;
			if (this.config.stayInParent && !this.$element.hasClass('e-parent') && !this.$element.hasClass('elementor-top-section')) {
				var $parent = this.$element.parent().closest('.elementor-section, .elementor-container, .e-con, .elementor-column');
				if ($parent.length) {
					var parentBottom = $parent.offset().top + $parent.outerHeight();
					var elementBottom = scrollTop + targetOffset + this.initialHeight;

					if (elementBottom > parentBottom) {
						var diff = parentBottom - elementBottom;
						computedTop = targetOffset + diff;
					}
				}
			}

			this.$element.css('top', Math.max(0, computedTop) + 'px');

			// Effects Offset (e.g. background change, box shadow, shrink)
			var effectsThreshold = (this.config.effectsOffset || 0);
			if ((scrollTop - (this.initialOffset.top - targetOffset)) >= effectsThreshold) {
				this.$element.addClass('pns-sticky-active');
			} else {
				this.$element.removeClass('pns-sticky-active');
			}

			// Scroll Up Only handler
			if (this.config.scrollUp) {
				var scrollDelta = scrollTop - this.lastScrollTop;
				if (scrollDelta > 2 && scrollTop > (this.initialOffset.top + this.initialHeight)) {
					// Scrolling Down
					this.$element.addClass('pns-sticky--hidden').removeClass('pns-sticky--revealed');
				} else if (scrollDelta < -2) {
					// Scrolling Up
					this.$element.removeClass('pns-sticky--hidden').addClass('pns-sticky--revealed');
				}
			}
		},

		stickBottom: function (targetBottomOffset, scrollTop) {
			var device = getDevice();

			if (!this.isStuck) {
				this.updateDimensions();
				this.$spacer
					.css({
						height: this.initialHeight + 'px',
						width: this.initialWidth + 'px',
						margin: this.$element.css('margin'),
						display: 'block'
					});

				var cssProps = {
					position: 'fixed',
					bottom: targetBottomOffset + 'px',
					zIndex: this.config.zIndex || 999
				};

				if (device === 'mobile') {
					cssProps.left = '0';
					cssProps.right = '0';
					cssProps.width = '100%';
				} else {
					cssProps.left = this.initialOffset.left + 'px';
					cssProps.width = this.initialWidth + 'px';
				}

				this.$element
					.addClass('pns-sticky-fixed')
					.css(cssProps);

				this.isStuck = true;
			}

			this.$element.addClass('pns-sticky-active');
		},

		unstick: function () {
			this.$element
				.removeClass('pns-sticky-fixed pns-sticky-active pns-sticky--hidden pns-sticky--revealed')
				.css({
					position: '',
					top: '',
					bottom: '',
					left: '',
					right: '',
					width: '',
					zIndex: ''
				});

			if (this.$spacer) {
				this.$spacer.hide().css('height', '0');
			}

			this.isStuck = false;
		},

		handleResize: function () {
			this.unstick();
			this.updateDimensions();
			this.handleScroll();
		},

		bindEvents: function () {
			var self = this;
			var ticking = false;

			var scrollHandler = function () {
				if (!ticking) {
					window.requestAnimationFrame(function () {
						self.handleScroll();
						ticking = false;
					});
					ticking = true;
				}
			};

			var resizeHandler = function () {
				self.handleResize();
			};

			var elId = this.$element.attr('data-id') || Math.random().toString(36).substring(7);
			$(window).on('scroll.pnsSticky_' + elId, scrollHandler);
			$(window).on('resize.pnsSticky_' + elId, resizeHandler);
			$(window).on('orientationchange.pnsSticky_' + elId, resizeHandler);

			// Support mobile touch scrolling
			this._boundTouch = scrollHandler;
			document.addEventListener('touchmove', scrollHandler, { passive: true });

			this._scrollHandler = scrollHandler;
			this._resizeHandler = resizeHandler;
			this._elId = elId;
		},

		destroy: function () {
			if (this._elId) {
				$(window).off('scroll.pnsSticky_' + this._elId);
				$(window).off('resize.pnsSticky_' + this._elId);
				$(window).off('orientationchange.pnsSticky_' + this._elId);
			}
			if (this._boundTouch) {
				document.removeEventListener('touchmove', this._boundTouch);
			}
			this.unstick();
			if (this.$spacer) {
				this.$spacer.remove();
				this.$spacer = null;
			}
		}
	};

	/**
	 * Initialize Sticky Elements
	 */
	function initStickyElements($scope) {
		var $elements;
		if ($scope && $scope.length) {
			if ($scope.hasClass('pns-sticky-element') || $scope.attr('data-pns-sticky-config')) {
				$elements = $scope;
			} else {
				$elements = $scope.find('.pns-sticky-element, [data-pns-sticky-config]');
			}
		} else {
			$elements = $('.pns-sticky-element, [data-pns-sticky-config]');
		}

		$elements.each(function () {
			var $el = $(this);
			var existing = $el.data('pnsStickyInstance');
			if (existing && existing.destroy) {
				existing.destroy();
			}
			var instance = new PNSStickyItem($el);
			$el.data('pnsStickyInstance', instance);
		});
	}

	// Elementor Frontend Hooks
	$(window).on('elementor/frontend/init', function () {
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
				initStickyElements($scope);
			});
		}
	});

	// Standard Document Ready fallback
	$(document).ready(function () {
		initStickyElements();

		// Check if images loading changes layout
		$(window).on('load', function () {
			$('.pns-sticky-element, [data-pns-sticky-config]').each(function () {
				var inst = $(this).data('pnsStickyInstance');
				if (inst) {
					inst.updateDimensions();
					inst.handleScroll();
				}
			});
		});
	});

})(jQuery);
