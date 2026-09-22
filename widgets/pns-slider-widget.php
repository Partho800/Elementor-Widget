<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Modern Simple Slider Elementor Widget.
 */
class PNS_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'mss_slider_widget';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Modern Slider', 'pns-addons-for-elementor' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-slideshow';
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
				'label' => esc_html__( 'Slides', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_image',
			[
				'label' => esc_html__( 'Choose Image', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'slide_title',
			[
				'label' => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Slide Title' , 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_description',
			[
				'label' => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Slide description goes here.' , 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Explore' , 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slides List', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slide_title' => esc_html__( 'Komodo', 'pns-addons-for-elementor' ),
						'slide_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus.', 'pns-addons-for-elementor' ),
						'slide_image' => [ 'url' => '' ],
					],
					[
						'slide_title' => esc_html__( 'Kerala', 'pns-addons-for-elementor' ),
						'slide_description' => esc_html__( 'Beautiful nature and serene backwaters of India.', 'pns-addons-for-elementor' ),
						'slide_image' => [ 'url' => '' ],
					],
					[
						'slide_title' => esc_html__( 'Switzerland', 'pns-addons-for-elementor' ),
						'slide_description' => esc_html__( 'The majestic mountains of Matterhorn.', 'pns-addons-for-elementor' ),
						'slide_image' => [ 'url' => '' ],
					],
				],
				'title_field' => '{{{ slide_title }}}',
			]
		);

		$this->end_controls_section();

		// --- Style Section: Content ---
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-des' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-btn' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Title ---
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mss-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .mss-name',
			]
		);

		$this->add_responsive_control(
			'title_max_width',
			[
				'label' => esc_html__( 'Max Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-name' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Description ---
		$this->start_controls_section(
			'section_des_style',
			[
				'label' => esc_html__( 'Description Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'des_color',
			[
				'label' => esc_html__( 'Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mss-des' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'des_typography',
				'selector' => '{{WRAPPER}} .mss-des',
			]
		);

		$this->add_responsive_control(
			'des_max_width',
			[
				'label' => esc_html__( 'Max Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-des' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Button ---
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mss-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mss-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'selector' => '{{WRAPPER}} .mss-btn',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Cards ---
		$this->start_controls_section(
			'section_cards_style',
			[
				'label' => esc_html__( 'Cards Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-item:nth-child(n+3)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '8',
					'right' => '8',
					'bottom' => '8',
					'left' => '8',
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'card_width',
			[
				'label' => esc_html__( 'Card Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 400,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-item:nth-child(n+3)' => 'width: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 180,
				],
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label' => esc_html__( 'Card Height', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 150,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-item:nth-child(n+3)' => 'height: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 260,
				],
			]
		);

		$this->add_control(
			'focus_card_height',
			[
				'label' => esc_html__( 'Focus Card Height', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-item:nth-child(3)' => 'height: {{SIZE}}{{UNIT}}; bottom: calc(50px - (({{SIZE}} - {{card_height.SIZE}}) / 2));',
				],
				'default' => [
					'size' => 320,
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Navigation ---
		$this->start_controls_section(
			'section_nav_style',
			[
				'label' => esc_html__( 'Navigation Buttons', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'nav_btn_size',
			[
				'label' => esc_html__( 'Button Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 20, 'max' => 150 ],
				],
				'default' => [ 'size' => 55 ],
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default' => [ 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-buttons button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_nav_pos',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'nav_pos_bottom',
			[
				'label' => esc_html__( 'Bottom Offset', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [ 'min' => -100, 'max' => 500 ],
				],
				'default' => [ 'size' => 50, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-buttons' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_pos_left',
			[
				'label' => esc_html__( 'Left Offset', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [ 'min' => -100, 'max' => 1000 ],
				],
				'default' => [ 'size' => 80, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mss-buttons' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_gap',
			[
				'label' => esc_html__( 'Gap Between Buttons', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [ 'size' => 15 ],
				'selectors' => [
					'{{WRAPPER}} .mss-buttons' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Background Overlay ---
		$this->start_controls_section(
			'section_overlay_style',
			[
				'label' => esc_html__( 'Background Overlay', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.3)',
				'selectors' => [
					'{{WRAPPER}} .mss-item:nth-child(1)::after, {{WRAPPER}} .mss-item:nth-child(2)::after' => 'background-color: {{VALUE}}; content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;',
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Container ---
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_height',
			[
				'label' => esc_html__( 'Height', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 400,
						'max' => 1200,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 90,
					'unit' => 'vh',
				],
				'selectors' => [
					'{{WRAPPER}} .mss-main-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-main-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		if ( empty( $settings['slides'] ) ) {
			return;
		}
		?>
		<div class="mss-main-container">
			<div class="mss-slide-list">
				<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
					<div class="mss-item" style="background-image: url('<?php echo esc_url( $slide['slide_image']['url'] ); ?>');">
						<div class="mss-content">
							<div class="mss-name"><?php echo esc_html( $slide['slide_title'] ); ?></div>
							<div class="mss-des"><?php echo esc_html( $slide['slide_description'] ); ?></div>
							<?php if ( ! empty( $slide['button_text'] ) ) : ?>
								<a href="<?php echo esc_url( $slide['button_link']['url'] ); ?>" class="mss-btn">
									<?php echo esc_html( $slide['button_text'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="mss-buttons">
				<button class="mss-prev"><i class="dashicons dashicons-arrow-left-alt2"></i></button>
				<button class="mss-next"><i class="dashicons dashicons-arrow-right-alt2"></i></button>
			</div>
		</div>
		<?php
	}
}

