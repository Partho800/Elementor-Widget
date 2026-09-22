<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PNS_Timeline_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mss_timeline_widget';
	}

	public function get_title() {
		return esc_html__( 'Modern Timeline', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Timeline Items', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Timeline Title', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label' => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Timeline description goes here.', 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'item_color',
			[
				'label' => esc_html__( 'Accent Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1a56db',
			]
		);

		$this->add_control(
			'timeline_items',
			[
				'label' => esc_html__( 'Items', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => esc_html__( 'Pick a Package', 'pns-addons-for-elementor' ),
						'item_description' => esc_html__( 'Choose the perfect plan that fits your business needs.', 'pns-addons-for-elementor' ),
						'item_icon' => [ 'value' => 'fas fa-gift' ],
					],
					[
						'item_title' => esc_html__( 'Submit Basic Info', 'pns-addons-for-elementor' ),
						'item_description' => esc_html__( 'Provide us with your business details and branding preferences.', 'pns-addons-for-elementor' ),
						'item_icon' => [ 'value' => 'fas fa-info-circle' ],
						'item_color' => '#f39c12',
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->end_controls_section();


		// --- Style Section: Line ---
		$this->start_controls_section(
			'section_line_style',
			[
				'label' => esc_html__( 'Line Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'line_color',
			[
				'label' => esc_html__( 'Line Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1a56db',
				'selectors' => [
					'{{WRAPPER}} .mss-timeline::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mss-t-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_width',
			[
				'label' => esc_html__( 'Line Width', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-timeline::before' => 'width: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-timeline-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => esc_html__( 'Border', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .mss-timeline-card',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-timeline-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .mss-timeline-card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-timeline-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '30',
					'right' => '30',
					'bottom' => '30',
					'left' => '30',
					'unit' => 'px',
				],
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

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-t-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-t-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mss-t-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'default' => [
					'size' => 32,
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mss-t-icon' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Icon Margin Bottom', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mss-t-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 15,
				],
			]
		);

		$this->end_controls_section();

		// --- Style Section: Typography ---
		$this->start_controls_section(
			'section_typo_style',
			[
				'label' => esc_html__( 'Typography & Colors', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .mss-t-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .mss-t-title',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#666666',
				'selectors' => [
					'{{WRAPPER}} .mss-t-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .mss-t-desc',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['timeline_items'] ) ) {
			return;
		}
		?>
		<div class="mss-timeline-wrapper">
			<div class="mss-timeline">
				<?php foreach ( $settings['timeline_items'] as $index => $item ) : 
					$side_class = ( $index % 2 === 0 ) ? 'mss-left' : 'mss-right';
					?>
					<div class="mss-timeline-item <?php echo esc_attr( $side_class ); ?>">
						<div class="mss-timeline-card">
							<div class="mss-t-icon" style="color: <?php echo esc_attr( $item['item_color'] ); ?>;">
								<?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
							<div class="mss-t-content">
								<h3 class="mss-t-title"><?php echo esc_html( $item['item_title'] ); ?></h3>
								<p class="mss-t-desc"><?php echo esc_html( $item['item_description'] ); ?></p>
							</div>
						</div>
						<div class="mss-t-dot"></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}

