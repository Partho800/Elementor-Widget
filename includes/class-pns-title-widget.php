<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class PNS_Title_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'pns_custom_title';
	}

	public function get_title() {
		return esc_html__( 'Dual Heading', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'pns-addons-category' ];
	}

	public function get_style_depends() {
		return [ 'pns-blog-styles' ];
	}

	protected function register_controls() {

		// Title Layout Controls
		$this->start_controls_section(
			'section_title_layout',
			[
				'label' => esc_html__( 'Title Layout', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
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
					'{{WRAPPER}} .pns-dual-title-wrapper' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pns-dual-title' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'font_size',
			[
				'label' => esc_html__( 'Font Size', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 120,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 44,
				],
				'selectors' => [
					'{{WRAPPER}} .pns-dual-title' => 'font-size: {{SIZE}}{{UNIT}} !important; line-height: 1.2;',
				],
			]
		);

		$this->add_responsive_control(
			'font_weight',
			[
				'label' => esc_html__( 'Font Weight', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '700',
				'options' => [
					'300' => '300 (Light)',
					'400' => '400 (Normal)',
					'500' => '500 (Medium)',
					'600' => '600 (Semi-Bold)',
					'700' => '700 (Bold)',
					'800' => '800 (Extra-Bold)',
					'900' => '900 (Black)',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-dual-title' => 'font-weight: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		// First Part Settings
		$this->start_controls_section(
			'section_first_part',
			[
				'label' => esc_html__( 'First Part Settings', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'first_text',
			[
				'label' => esc_html__( 'Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'first_color',
			[
				'label' => esc_html__( 'Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#12211a',
				'selectors' => [
					'{{WRAPPER}} .pns-title-first' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'first_typography',
				'label' => esc_html__( 'Typography', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .pns-title-first',
			]
		);

		$this->end_controls_section();

		// Second Part Settings
		$this->start_controls_section(
			'section_second_part',
			[
				'label' => esc_html__( 'Second Part Settings', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'second_text',
			[
				'label' => esc_html__( 'Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Work', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'second_color_type',
			[
				'label' => esc_html__( 'Color Type', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'gradient',
				'options' => [
					'solid' => esc_html__( 'Solid Color', 'pns-addons-for-elementor' ),
					'gradient' => esc_html__( 'Gradient', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'second_color',
			[
				'label' => esc_html__( 'Solid Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#3BB852',
				'condition' => [
					'second_color_type' => 'solid',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-title-second' => 'color: {{VALUE}}; background: none; -webkit-background-clip: initial; -webkit-text-fill-color: initial;',
				],
			]
		);

		$this->add_control(
			'second_gradient_start',
			[
				'label' => esc_html__( 'Gradient Color Start', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#3BB852',
				'condition' => [
					'second_color_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'second_gradient_end',
			[
				'label' => esc_html__( 'Gradient Color End', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0d9488',
				'condition' => [
					'second_color_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'second_gradient_angle',
			[
				'label' => esc_html__( 'Gradient Angle (Deg)', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 135,
				],
				'condition' => [
					'second_color_type' => 'gradient',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'second_typography',
				'label' => esc_html__( 'Typography', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .pns-title-second',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tag = $settings['title_tag'];

		$first_classes = [ 'pns-title-first' ];
		$second_classes = [ 'pns-title-second' ];

		$second_style = '';
		if ( 'gradient' === $settings['second_color_type'] ) {
			$start = ! empty( $settings['second_gradient_start'] ) ? $settings['second_gradient_start'] : '#3BB852';
			$end = ! empty( $settings['second_gradient_end'] ) ? $settings['second_gradient_end'] : '#0d9488';
			$angle = ! empty( $settings['second_gradient_angle']['size'] ) ? $settings['second_gradient_angle']['size'] : 135;
			$second_style = "background: linear-gradient({$angle}deg, {$start} 0%, {$end} 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; display: inline-block;";
		}
		?>
		<div class="blogs-page">
			<div class="pns-dual-title-wrapper">
				<<?php echo esc_attr( $tag ); ?> class="pns-dual-title">
					<?php if ( ! empty( $settings['first_text'] ) ) : ?>
						<span class="<?php echo esc_attr( implode( ' ', $first_classes ) ); ?>">
							<?php echo esc_html( $settings['first_text'] ); ?>
						</span>
					<?php endif; ?>
					
					<?php if ( ! empty( $settings['second_text'] ) ) : ?>
						<span class="<?php echo esc_attr( implode( ' ', $second_classes ) ); ?>" style="<?php echo esc_attr( $second_style ); ?>">
							<?php echo esc_html( $settings['second_text'] ); ?>
						</span>
					<?php endif; ?>
				</<?php echo esc_attr( $tag ); ?>>
			</div>
		</div>
		<?php
	}
}


