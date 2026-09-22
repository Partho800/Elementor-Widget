<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Modern Accordion Slider Elementor Widget.
 */
class PNS_Accordion_Slider_Widget extends \Elementor\Widget_Base {

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
		return esc_html__( 'Accordion Slider', 'pns-addons-for-elementor' );
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

	public function get_style_depends() {
		return [ 'pns-accordion-slider-style' ];
	}

	public function get_script_depends() {
		return [ 'pns-accordion-slider' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Cards', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'card_image',
			[
				'label' => esc_html__( 'Choose Image', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'card_title',
			[
				'label' => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Card Title' , 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'card_description',
			[
				'label' => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Card description goes here.' , 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'card_link',
			[
				'label' => esc_html__( 'Link', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'cards',
			[
				'label' => esc_html__( 'Cards List', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'card_title' => esc_html__( 'Email Marketing', 'pns-addons-for-elementor' ),
						'card_description' => esc_html__( 'Boost Engagement and Drive Conversions with Targeted Emails.', 'pns-addons-for-elementor' ),
						'card_image' => [ 'url' => '' ],
					],
					[
						'card_title' => esc_html__( 'Social Media', 'pns-addons-for-elementor' ),
						'card_description' => esc_html__( 'Connect with your audience on all major platforms.', 'pns-addons-for-elementor' ),
						'card_image' => [ 'url' => '' ],
					],
					[
						'card_title' => esc_html__( 'SEO Optimization', 'pns-addons-for-elementor' ),
						'card_description' => esc_html__( 'Rank higher on search engines and get more traffic.', 'pns-addons-for-elementor' ),
						'card_image' => [ 'url' => '' ],
					],
					[
						'card_title' => esc_html__( 'Web Design', 'pns-addons-for-elementor' ),
						'card_description' => esc_html__( 'Create stunning websites that convert visitors.', 'pns-addons-for-elementor' ),
						'card_image' => [ 'url' => '' ],
					],
				],
				'title_field' => '{{{ card_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'items_to_show',
			[
				'label' => esc_html__( 'Items per View', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 10,
			]
		);

		$this->add_control(
			'enable_carousel',
			[
				'label' => esc_html__( 'Enable Carousel', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Hover Icon', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Transition Speed (ms)', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Card Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label' => esc_html__( 'Height', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Content Box', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_box_width',
			[
				'label' => esc_html__( 'Width', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Height', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Content Alignment', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'pns-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pns-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Text Alignment', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'pns-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pns-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Typography', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Icon Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Size', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Rotation (Degrees)', 'pns-addons-for-elementor' ),
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
		$this->add_render_attribute( 'wrapper', 'data-slides', (int) $settings['items_to_show'] );
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
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> style="--mss-speed: <?php echo esc_attr( $speed_s ); ?>s; --mss-delay: <?php echo esc_attr( $delay_s ); ?>s;">
			<div <?php $this->print_render_attribute_string( 'list' ); ?> style="display: flex; gap: 15px;">
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
					<div class="mss-accordion-item <?php echo esc_attr( $active_class ); ?> <?php $this->print_render_attribute_string( 'item' ); ?>" style="background-image: url('<?php echo esc_url( $card['card_image']['url'] ); ?>');">
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

		<?php
	}
}

