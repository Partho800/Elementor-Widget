<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PNS_Video_Card_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mss_video_card_widget';
	}

	public function get_title() {
		return esc_html__( 'Video Popup Card', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-video-camera';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Background Image', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'logo_img',
			[
				'label' => esc_html__( 'Top Logo/Image', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'YouTube Video URL', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'https://www.youtube.com/watch?v=XXXXX', 'pns-addons-for-elementor' ),
				'default' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
			]
		);

		$this->add_control(
			'video_icon',
			[
				'label' => esc_html__( 'Play Icon', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-play',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Watch the video', 'pns-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		// --- Style Section ---
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Card Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_height',
			[
				'label' => esc_html__( 'Card Height', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [ 'min' => 200, 'max' => 1000 ],
				],
				'default' => [ 'size' => 450, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-video-card' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'overlay_tabs' );

		$this->start_controls_tab(
			'overlay_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'normal_overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.7)',
				'selectors' => [
					'{{WRAPPER}} .mss-video-card::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'overlay_hover',
			[ 'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'hover_overlay_color',
			[
				'label' => esc_html__( 'Hover Overlay Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.9)',
				'selectors' => [
					'{{WRAPPER}} .mss-video-card:hover::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_duration',
			[
				'label' => esc_html__( 'Overlay Transition Duration (s)', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .mss-video-card::after' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->add_control(
			'zoom_duration',
			[
				'label' => esc_html__( 'Zoom Transition Duration (s)', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.8,
				],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-bg' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'logo_width',
			[
				'label' => esc_html__( 'Logo Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [ 'px' => [ 'min' => 50, 'max' => 500 ] ],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-logo img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Button & Icon ---
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button & Icon Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Button Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.15)',
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_bg_color',
			[
				'label' => esc_html__( 'Button Hover BG Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.3)',
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_text_color',
			[
				'label' => esc_html__( 'Text & Circle Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-vc-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mss-vc-play-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_icon_color_inner',
			[
				'label' => esc_html__( 'Icon Color (Inner)', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1a56db',
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mss-vc-play-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Button Padding', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '10',
					'right' => '25',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_control(
			'heading_icon',
			[
				'label' => esc_html__( 'Icon Circle Style', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'play_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-vc-play-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'default' => [ 'size' => 16 ],
			]
		);

		$this->add_responsive_control(
			'play_circle_size',
			[
				'label' => esc_html__( 'Circle Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [ 'px' => [ 'min' => 30, 'max' => 150 ] ],
				'selectors' => [
					'{{WRAPPER}} .mss-vc-play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'default' => [ 'size' => 45 ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_url = $settings['video_url'];
		
		// Extract YouTube ID
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
		$youtube_id = !empty($match[1]) ? $match[1] : '';
		?>
		<div class="mss-video-card">
			<div class="mss-vc-bg" style="background-image: url('<?php echo esc_url( $settings['card_bg']['url'] ); ?>');"></div>
			<div class="mss-vc-content">
				<?php if ( ! empty( $settings['logo_img']['url'] ) ) : ?>
					<div class="mss-vc-logo">
						<img src="<?php echo esc_url( $settings['logo_img']['url'] ); ?>" alt="Logo">
					</div>
				<?php endif; ?>

				<div class="mss-vc-bottom">
					<a href="#" class="mss-vc-play-btn" data-video-id="<?php echo esc_attr($youtube_id); ?>" data-widget-id="<?php echo esc_attr($this->get_id()); ?>">
						<div class="mss-vc-play-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['video_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
						<span class="mss-vc-btn-text"><?php echo esc_html( $settings['button_text'] ); ?></span>
					</a>
				</div>
			</div>
		</div>

		<!-- Simple Popup Modal -->
		<div id="mss-video-modal-<?php echo esc_attr( $this->get_id() ); ?>" class="mss-video-modal" style="display:none; position:fixed; z-index:99999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.95);">
			<div class="mss-video-modal-content" style="position:relative; top:50%; transform:translateY(-50%); width:90%; max-width:1200px; margin:auto;">
				<span class="mss-video-close" style="position:absolute; top:-45px; right:0; color:#fff; font-size:40px; cursor:pointer;">&times;</span>
				<div class="mss-video-iframe-wrapper" style="position:relative; padding-bottom:56.25%; height:0;">
					<iframe id="mss-iframe-<?php echo esc_attr( $this->get_id() ); ?>" width="100%" height="100%" src="" frameborder="0" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%;"></iframe>
				</div>
			</div>
		</div>

		<?php
		$widget_id = esc_js( $this->get_id() );
		$vc_js = "jQuery(document).ready(function($) {
			var widgetId = '{$widget_id}';
			var btn = \$('.elementor-element-' + widgetId + ' .mss-vc-play-btn');
			var modal = \$('#mss-video-modal-' + widgetId);
			if (modal.length) { \$('body').append(modal); }
			var iframe = \$('#mss-iframe-' + widgetId);
			var close = modal.find('.mss-video-close');
			btn.on('click', function(e) {
				e.preventDefault();
				var videoId = \$(this).attr('data-video-id');
				if (videoId) {
					iframe.attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&showinfo=0');
					modal.fadeIn(300);
					\$('body').css('overflow', 'hidden');
				}
			});
			close.on('click', function() {
				modal.fadeOut(300, function() { iframe.attr('src', ''); \$('body').css('overflow', 'auto'); });
			});
			modal.on('click', function(e) {
				if (\$(e.target).hasClass('mss-video-modal')) { close.trigger('click'); }
			});
		});";
		wp_add_inline_script( 'jquery', $vc_js );
		?>
		<?php
	}
}

