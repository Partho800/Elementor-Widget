<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Modern Accordion Slider Elementor Widget.
 */
class MSS_Accordion_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'mss_accordion_slider_widget';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Accordion Slider', 'mss' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Cards', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'card_image',
			[
				'label' => esc_html__( 'Choose Image', 'mss' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'card_title',
			[
				'label' => esc_html__( 'Title', 'mss' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Card Title' , 'mss' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'card_description',
			[
				'label' => esc_html__( 'Description', 'mss' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Card description goes here.' , 'mss' ),
			]
		);

		$repeater->add_control(
			'card_link',
			[
				'label' => esc_html__( 'Link', 'mss' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mss' ),
			]
		);

		$this->add_control(
			'cards',
			[
				'label' => esc_html__( 'Cards List', 'mss' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'card_title' => esc_html__( 'Email Marketing', 'mss' ),
						'card_description' => esc_html__( 'Boost Engagement and Drive Conversions with Targeted Emails.', 'mss' ),
						'card_image' => [ 'url' => 'https://images.unsplash.com/photo-1557200134-90327ee9fafa?auto=format&fit=crop&q=80&w=800' ],
					],
					[
						'card_title' => esc_html__( 'Social Media', 'mss' ),
						'card_description' => esc_html__( 'Connect with your audience on all major platforms.', 'mss' ),
						'card_image' => [ 'url' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?auto=format&fit=crop&q=80&w=800' ],
					],
					[
						'card_title' => esc_html__( 'SEO Optimization', 'mss' ),
						'card_description' => esc_html__( 'Rank higher on search engines and get more traffic.', 'mss' ),
						'card_image' => [ 'url' => 'https://images.unsplash.com/photo-1571721738205-e827cbd13ce9?auto=format&fit=crop&q=80&w=800' ],
					],
					[
						'card_title' => esc_html__( 'Web Design', 'mss' ),
						'card_description' => esc_html__( 'Create stunning websites that convert visitors.', 'mss' ),
						'card_image' => [ 'url' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800' ],
					],
				],
				'title_field' => '{{{ card_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'items_to_show',
			[
				'label' => esc_html__( 'Items per View', 'mss' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 10,
			]
		);

		$this->add_control(
			'enable_carousel',
			[
				'label' => esc_html__( 'Enable Carousel', 'mss' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'mss' ),
				'label_off' => esc_html__( 'No', 'mss' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Hover Icon', 'mss' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-up',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label' => esc_html__( 'Transition Speed (ms)', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 100, 'max' => 1500, 'step' => 50 ],
				],
				'default' => [ 'size' => 500 ],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Card ---
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Card Style', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label' => esc_html__( 'Height', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [ 'min' => 200, 'max' => 800 ],
					'vh' => [ 'min' => 10, 'max' => 100 ],
				],
				'default' => [ 'size' => 480, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'mss' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Content Box ---
		$this->start_controls_section(
			'section_content_box_style',
			[
				'label' => esc_html__( 'Content Box', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_box_width',
			[
				'label' => esc_html__( 'Width', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [ 'min' => 100, 'max' => 600 ],
				],
				'default' => [ 'size' => 380, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_box_height',
			[
				'label' => esc_html__( 'Height', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [ 'min' => 50, 'max' => 400 ],
				],
				'default' => [ 'size' => 128, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'mss' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'right' => '24',
					'bottom' => '24',
					'left' => '24',
					'unit' => 'px',
				],
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'mss' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '12',
					'right' => '12',
					'bottom' => '12',
					'left' => '12',
					'unit' => 'px',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'selector' => '{{WRAPPER}} .mss-accordion-content',
			]
		);

		$this->add_control(
			'content_box_alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'mss' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'mss' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'mss' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'mss' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'mss' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'mss' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'mss' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'mss' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Typography ---
		$this->start_controls_section(
			'section_typography',
			[
				'label' => esc_html__( 'Typography', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'mss' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .mss-accordion-title',
			]
		);

		$this->add_control(
			'desc_heading',
			[
				'label' => esc_html__( 'Description', 'mss' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Color', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#666666',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'selector' => '{{WRAPPER}} .mss-accordion-desc',
			]
		);

		$this->end_controls_section();

		// --- Style Section: Icon ---
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mss-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ccff00',
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default' => [ 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-accordion-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-accordion-icon' => 'width: calc({{SIZE}}{{UNIT}} * 2); height: calc({{SIZE}}{{UNIT}} * 2);',
				],
			]
		);

		$this->add_control(
			'icon_rotation',
			[
				'label' => esc_html__( 'Rotation (Degrees)', 'mss' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0, 'max' => 360 ],
				],
				'default' => [ 'size' => 45 ],
				'selectors' => [
					'{{WRAPPER}} .mss-accordion-icon' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['cards'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'mss-accordion-wrapper' );
		if ( count( $settings['cards'] ) > $settings['items_to_show'] && 'yes' === $settings['enable_carousel'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'swiper-container mss-accordion-carousel' );
			$this->add_render_attribute( 'list', 'class', 'swiper-wrapper' );
			$this->add_render_attribute( 'item', 'class', 'swiper-slide' );
		} else {
			$this->add_render_attribute( 'list', 'class', 'mss-accordion-list' );
			$this->add_render_attribute( 'item', 'class', 'mss-accordion-item-static' );
		}
		$speed_ms = ! empty( $settings['transition_speed']['size'] ) ? (int) $settings['transition_speed']['size'] : 500;
		$speed_s = round( $speed_ms / 1000, 2 );
		$delay_s = round( $speed_s * 0.4, 2 );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> style="--mss-speed: <?php echo esc_attr( $speed_s ); ?>s; --mss-delay: <?php echo esc_attr( $delay_s ); ?>s;">
			<div <?php echo $this->get_render_attribute_string( 'list' ); ?> style="display: flex; gap: 15px;">
				<?php 
				$items_count = 0;
				$max_items = (int) $settings['items_to_show'];
				$is_carousel = ( count( $settings['cards'] ) > $max_items && 'yes' === $settings['enable_carousel'] );

				foreach ( $settings['cards'] as $index => $card ) : 
					if ( ! $is_carousel && $items_count >= $max_items ) {
						break;
					}
					$active_class = ( $index === 0 ) ? 'active' : '';
					$items_count++;
					?>
					<div class="mss-accordion-item <?php echo $active_class; ?> <?php echo $this->get_render_attribute_string( 'item' ); ?>" style="background-image: url('<?php echo esc_url( $card['card_image']['url'] ); ?>');">
						<div class="mss-accordion-overlay"></div>
						
						<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
							<div class="mss-accordion-icon">
								<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						<?php endif; ?>

						<div class="mss-accordion-content">
							<h3 class="mss-accordion-title"><?php echo esc_html( $card['card_title'] ); ?></h3>
							<p class="mss-accordion-desc"><?php echo esc_html( $card['card_description'] ); ?></p>
							<?php if ( ! empty( $card['card_link']['url'] ) ) : ?>
								<a href="<?php echo esc_url( $card['card_link']['url'] ); ?>" class="mss-accordion-link"></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $settings['cards'] ) > $settings['items_to_show'] && 'yes' === $settings['enable_carousel'] ) : ?>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			<?php endif; ?>
		</div>

		<style>
			.mss-accordion-wrapper {
				width: 100%;
				overflow: hidden;
				padding: 20px 0;
			}
			.mss-accordion-list {
				display: flex;
				width: 100%;
				list-style: none;
				padding: 0;
				margin: 0;
			}
			.mss-accordion-item {
				position: relative;
				flex: 1;
				min-width: 244px;
				background-size: cover;
				background-position: center;
				transition: flex var(--mss-speed, 0.5s) cubic-bezier(0.4, 0, 0.2, 1), min-width var(--mss-speed, 0.5s) cubic-bezier(0.4, 0, 0.2, 1);
				cursor: pointer;
				overflow: hidden;
				display: flex;
				flex-direction: column;
				justify-content: flex-end;
				padding: 25px;
				will-change: flex;
			}
			.mss-accordion-item.active {
				flex: 0 0 420px;
			}
			
			.mss-accordion-overlay {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: linear-gradient(to bottom, rgba(0,0,0,0) 40%, rgba(0,0,0,0.6) 100%);
				opacity: 0.5;
				transition: opacity 0.3s;
				z-index: 1;
			}
			
			.mss-accordion-icon {
				position: absolute;
				top: 25px;
				right: 25px;
				width: 50px;
				height: 50px;
				background-color: #ccff00;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				opacity: 0;
				transform: scale(0.5) rotate(0deg);
				transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
				z-index: 5;
			}
			
			.mss-accordion-item:hover .mss-accordion-icon {
				opacity: 1;
				transform: scale(1) rotate(0deg);
			}

			.mss-accordion-content {
				position: relative;
				z-index: 5;
				background: #ffffff;
				border-radius: 12px;
				transform: translateY(24px);
				opacity: 0;
				transition: opacity 0.3s ease var(--mss-delay, 0.2s), transform 0.4s cubic-bezier(0.25, 1, 0.5, 1) var(--mss-delay, 0.2s);
				box-shadow: 0 10px 30px rgba(0,0,0,0.1);
				display: flex;
				flex-direction: column;
				gap: 5px;
				pointer-events: none;
			}

			.mss-accordion-item.active .mss-accordion-content {
				transform: translateY(0);
				opacity: 1;
				pointer-events: auto;
			}

			.mss-accordion-title {
				margin: 0;
				font-size: 22px;
				font-weight: 700;
				color: #1a1a1a;
				line-height: 1.2;
			}

			.mss-accordion-desc {
				margin: 0;
				font-size: 15px;
				color: #555;
				line-height: 1.5;
			}

			.mss-accordion-link {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: 10;
			}

			/* Hover expansion logic */
			.mss-accordion-list:hover .mss-accordion-item {
				/* flex: 1; */
			}
			.mss-accordion-list .mss-accordion-item:hover {
				/* flex: 3.5; */
			}

			/* Swiper compatibility */
			.swiper-slide {
				transition: flex 0.6s ease;
			}

			/* ---- Mobile Responsive ---- */
			@media (max-width: 767px) {
				.mss-accordion-list {
					flex-direction: column;
					gap: 12px;
				}
				.mss-accordion-item {
					flex: none !important;
					width: 100% !important;
					min-width: 100% !important;
					height: 260px !important;
					transition: height 0.4s ease !important;
				}
				.mss-accordion-item.active {
					flex: none !important;
					width: 100% !important;
					height: 320px !important;
				}
				.mss-accordion-content {
					width: 100% !important;
					max-width: 100% !important;
					box-sizing: border-box;
				}
				.mss-accordion-icon {
					display: none;
				}
			}

			@media (min-width: 768px) and (max-width: 1024px) {
				.mss-accordion-item {
					min-width: 140px;
				}
				.mss-accordion-item.active {
					flex: 0 0 320px;
				}
				.mss-accordion-content {
					width: 280px !important;
				}
			}
		</style>

		<script>
		jQuery(document).ready(function($) {
			function initAccordion($wrapper) {
				const $items = $wrapper.find('.mss-accordion-item');
				let hoverTimer = null;
				let leaveTimer = null;
				
				$items.on('mouseenter', function() {
					if ($wrapper.hasClass('mss-accordion-carousel')) return;
					clearTimeout(hoverTimer);
					clearTimeout(leaveTimer);
					const $hovered = $(this);
					hoverTimer = setTimeout(function() {
						$items.removeClass('active');
						$hovered.addClass('active');
					}, 60); // small debounce so rapid mouse move doesn't flicker
				});

				$wrapper.on('mouseleave', function() {
					if ($wrapper.hasClass('mss-accordion-carousel')) return;
					clearTimeout(hoverTimer);
					leaveTimer = setTimeout(function() {
						$items.removeClass('active');
						$items.first().addClass('active');
					}, 80);
				});
			}

			$('.mss-accordion-wrapper').each(function() {
				const $this = $(this);
				initAccordion($this);

				if ($this.hasClass('mss-accordion-carousel')) {
					const settings = {
						slidesPerView: <?php echo esc_js( $settings['items_to_show'] ); ?>,
						spaceBetween: 20,
						loop: true,
						pagination: {
							el: '.swiper-pagination',
							clickable: true,
						},
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev',
						},
						breakpoints: {
							320: { slidesPerView: 1 },
							768: { slidesPerView: 2 },
							1024: { slidesPerView: <?php echo esc_js( $settings['items_to_show'] ); ?> }
						}
					};

					if (typeof Swiper !== 'undefined') {
						new Swiper($this[0], settings);
					} else if (window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper) {
						// Use Elementor's Swiper if available
						new window.elementorFrontend.utils.swiper($this[0], settings).then(function(newSwiperInstance) {
							// Swiper instance created
						});
					}
				}
			});
		});
		</script>
		<?php
	}
}
