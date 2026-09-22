<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PNS_Animated_Button_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mss_animated_button';
	}

	public function get_title() {
		return esc_html__( 'Animated Button', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
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
			'button_text',
			[
				'label' => esc_html__( 'Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Me', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Link', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'animation_type',
			[
				'label' => esc_html__( 'Hover Animation', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'pulse',
				'options' => [
					'pulse'  => esc_html__( 'Pulse', 'pns-addons-for-elementor' ),
					'glow'   => esc_html__( 'Glow', 'pns-addons-for-elementor' ),
					'shine'  => esc_html__( 'Shine', 'pns-addons-for-elementor' ),
					'lift'   => esc_html__( 'Lift Up', 'pns-addons-for-elementor' ),
					'expand' => esc_html__( 'Scale Out', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'pns-addons-for-elementor' ),
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .mss-anim-btn',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mss-anim-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1a56db',
				'selectors' => [
					'{{WRAPPER}} .mss-anim-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-anim-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '15',
					'right' => '40',
					'bottom' => '15',
					'left' => '40',
					'unit' => 'px',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mss-anim-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 5,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'button', 'class', 'mss-anim-btn' );
		$this->add_render_attribute( 'button', 'class', 'mss-anim-' . $settings['animation_type'] );
		$this->add_render_attribute( 'button', 'href', $settings['button_link']['url'] );

		if ( $settings['button_link']['is_external'] ) {
			$this->add_render_attribute( 'button', 'target', '_blank' );
		}

		if ( $settings['button_link']['nofollow'] ) {
			$this->add_render_attribute( 'button', 'rel', 'nofollow' );
		}
		?>
		<a <?php $this->print_render_attribute_string( 'button' ); ?>>
			<span><?php echo esc_html( $settings['button_text'] ); ?></span>
		</a>
		<?php
	}
}

