<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Repeater;

/**
 * PNS Progress Bar & Circular Progress Widget for Elementor
 *
 * Highly customizable progress bar and circular progress rings / gauges.
 * Features smooth scroll animations, SVG gradients, multi-item grids, and custom styling.
 */
class PNS_Progress_Bar_Widget extends Widget_Base {

	/**
	 * Widget Name
	 */
	public function get_name() {
		return 'pns_progress_bar_widget';
	}

	/**
	 * Widget Title
	 */
	public function get_title() {
		return esc_html__( 'PNS Progress Bar & Circle', 'pns-addons-for-elementor' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'eicon-skill-bar';
	}

	/**
	 * Widget Categories
	 */
	public function get_categories() {
		return [ 'pns-addons-category' ];
	}

	/**
	 * Style dependencies
	 */
	public function get_style_depends() {
		return [ 'pns-progress-bar-style' ];
	}

	/**
	 * Script dependencies
	 */
	public function get_script_depends() {
		return [ 'pns-progress-bar-script' ];
	}

	/**
	 * Register Widget Controls
	 */
	protected function register_controls() {

		// ==========================================
		// 1. CONTENT TAB: LAYOUT & MODE
		// ==========================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout & Type', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_type',
			[
				'label'   => esc_html__( 'Progress Type', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'linear',
				'options' => [
					'linear'   => esc_html__( 'Linear Progress Bar', 'pns-addons-for-elementor' ),
					'circular' => esc_html__( 'Circular Progress & Gauge', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'gauge_style',
			[
				'label'     => esc_html__( 'Gauge Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'circle',
				'options'   => [
					'circle' => esc_html__( 'Full Circle (360°)', 'pns-addons-for-elementor' ),
					'semi'   => esc_html__( 'Semi-Circle (180°)', 'pns-addons-for-elementor' ),
					'arch'   => esc_html__( 'Arch Gauge (240°)', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'layout_type' => 'circular',
				],
			]
		);

		$this->add_control(
			'linear_layout',
			[
				'label'     => esc_html__( 'Label Layout', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'standard',
				'options'   => [
					'standard' => esc_html__( 'Standard (Label Above Bar)', 'pns-addons-for-elementor' ),
					'inside'   => esc_html__( 'Inside Bar (Text Inside Track)', 'pns-addons-for-elementor' ),
					'tooltip'  => esc_html__( 'Tooltip / Floating Pin', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'layout_type' => 'linear',
				],
			]
		);

		$this->add_responsive_control(
			'circular_columns',
			[
				'label'          => esc_html__( 'Columns', 'pns-addons-for-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => esc_html__( '1 Column', 'pns-addons-for-elementor' ),
					'2' => esc_html__( '2 Columns', 'pns-addons-for-elementor' ),
					'3' => esc_html__( '3 Columns', 'pns-addons-for-elementor' ),
					'4' => esc_html__( '4 Columns', 'pns-addons-for-elementor' ),
				],
				'condition'      => [
					'layout_type' => 'circular',
				],
			]
		);

		$this->add_control(
			'striped_pattern',
			[
				'label'        => esc_html__( 'Diagonal Stripes', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'layout_type' => 'linear',
				],
			]
		);

		$this->add_control(
			'animated_stripes',
			[
				'label'        => esc_html__( 'Animated Stripes', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'layout_type'     => 'linear',
					'striped_pattern' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'       => esc_html__( 'Animation Duration (ms)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 300,
				'max'         => 5000,
				'step'        => 100,
				'default'     => 1400,
				'description' => esc_html__( 'Duration of scroll count-up and fill animation in milliseconds.', 'pns-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 2. CONTENT TAB: PROGRESS ITEMS (REPEATER)
		// ==========================================
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Progress Items', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title',
			[
				'label'       => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Web Development', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Description', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Frontend & Backend Mastery', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_percentage',
			[
				'label'   => esc_html__( 'Percentage', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'default' => 85,
			]
		);

		$repeater->add_control(
			'item_prefix',
			[
				'label'   => esc_html__( 'Prefix', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$repeater->add_control(
			'item_suffix',
			[
				'label'   => esc_html__( 'Suffix', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '%',
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'   => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-code',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'custom_color_heading',
			[
				'label'     => esc_html__( 'Individual Item Colors', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'override_colors',
			[
				'label'        => esc_html__( 'Custom Colors for This Item', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$repeater->add_control(
			'item_color_type',
			[
				'label'     => esc_html__( 'Color Type', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'solid'    => esc_html__( 'Solid Color', 'pns-addons-for-elementor' ),
					'gradient' => esc_html__( 'Gradient', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'override_colors' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_bar_color_1',
			[
				'label'     => esc_html__( 'Bar Color (Primary)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'condition' => [
					'override_colors' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_bar_color_2',
			[
				'label'     => esc_html__( 'Gradient Color 2 (End)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00b4d8',
				'condition' => [
					'override_colors' => 'yes',
					'item_color_type' => 'gradient',
				],
			]
		);

		$repeater->add_control(
			'item_track_color',
			[
				'label'     => esc_html__( 'Track Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'condition' => [
					'override_colors' => 'yes',
				],
			]
		);

		$this->add_control(
			'progress_items',
			[
				'label'       => esc_html__( 'Progress Items', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ item_title }}} ({{{ item_percentage }}}%)',
				'default'     => [
					[
						'item_title'      => esc_html__( 'Web Design & UI/UX', 'pns-addons-for-elementor' ),
						'item_subtitle'   => esc_html__( 'Figma, Prototyping & Layouts', 'pns-addons-for-elementor' ),
						'item_percentage' => 92,
						'item_icon'       => [
							'value'   => 'fas fa-palette',
							'library' => 'fa-solid',
						],
					],
					[
						'item_title'      => esc_html__( 'Frontend Development', 'pns-addons-for-elementor' ),
						'item_subtitle'   => esc_html__( 'HTML5, CSS3 & JavaScript', 'pns-addons-for-elementor' ),
						'item_percentage' => 85,
						'item_icon'       => [
							'value'   => 'fas fa-code',
							'library' => 'fa-solid',
						],
					],
					[
						'item_title'      => esc_html__( 'WordPress & Elementor', 'pns-addons-for-elementor' ),
						'item_subtitle'   => esc_html__( 'Custom Themes & Widgets', 'pns-addons-for-elementor' ),
						'item_percentage' => 78,
						'item_icon'       => [
							'value'   => 'fab fa-wordpress',
							'library' => 'fa-brands',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 3. STYLE TAB: LINEAR BAR STYLING
		// ==========================================
		$this->start_controls_section(
			'section_style_linear',
			[
				'label'     => esc_html__( 'Linear Bar Style', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_type' => 'linear',
				],
			]
		);

		$this->add_responsive_control(
			'bar_height',
			[
				'label'      => esc_html__( 'Bar Height (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 4,
						'max'  => 60,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-progress-track' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bar_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-progress-track' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pns-progress-fill'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bar_color_type',
			[
				'label'   => esc_html__( 'Bar Color Type', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'    => esc_html__( 'Solid Color', 'pns-addons-for-elementor' ),
					'gradient' => esc_html__( 'Gradient', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'bar_fill_color',
			[
				'label'     => esc_html__( 'Bar Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'condition' => [
					'bar_color_type' => 'solid',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-progress-fill' => 'background: {{VALUE}} !important; background-image: none !important;',
				],
			]
		);

		$this->add_control(
			'bar_gradient_c1',
			[
				'label'     => esc_html__( 'Gradient Color 1 (Start)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'condition' => [
					'bar_color_type' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-progress-fill' => 'background-image: linear-gradient(90deg, {{VALUE}} 0%, {{bar_gradient_c2.VALUE}} 100%) !important;',
				],
			]
		);

		$this->add_control(
			'bar_gradient_c2',
			[
				'label'     => esc_html__( 'Gradient Color 2 (End)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00b4d8',
				'condition' => [
					'bar_color_type' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-progress-fill' => 'background-image: linear-gradient(90deg, {{bar_gradient_c1.VALUE}} 0%, {{VALUE}} 100%) !important;',
				],
			]
		);

		$this->add_control(
			'bar_track_bg',
			[
				'label'     => esc_html__( 'Track Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-track' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bar_track_shadow',
				'label'    => esc_html__( 'Track Inner Shadow', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .pns-progress-track',
			]
		);

		$this->add_responsive_control(
			'items_gap_linear',
			[
				'label'      => esc_html__( 'Space Between Bars', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 80,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-progress-linear-list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 4. STYLE TAB: CIRCULAR & GAUGE STYLING
		// ==========================================
		$this->start_controls_section(
			'section_style_circular',
			[
				'label'     => esc_html__( 'Circular & Gauge Style', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_type' => 'circular',
				],
			]
		);

		$this->add_responsive_control(
			'circle_size',
			[
				'label'      => esc_html__( 'Circle Diameter (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 80,
						'max'  => 400,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 160,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-circle-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-circle-svg'       => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'circle_stroke_width',
			[
				'label'      => esc_html__( 'Stroke Width (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 2,
						'max'  => 40,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 9,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-circle-bg'  => 'stroke-width: {{SIZE}}px;',
					'{{WRAPPER}} .pns-circle-bar' => 'stroke-width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'circle_stroke_linecap',
			[
				'label'     => esc_html__( 'Stroke Linecap', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'round',
				'options'   => [
					'round'  => esc_html__( 'Round', 'pns-addons-for-elementor' ),
					'square' => esc_html__( 'Square / Flat', 'pns-addons-for-elementor' ),
					'butt'   => esc_html__( 'Butt', 'pns-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .pns-circle-bar' => 'stroke-linecap: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_color_type',
			[
				'label'   => esc_html__( 'Bar Color Type', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'    => esc_html__( 'Solid Color', 'pns-addons-for-elementor' ),
					'gradient' => esc_html__( 'Gradient', 'pns-addons-for-elementor' ),
				],
			]
		);

		// Solid Bar Color
		$this->add_control(
			'circle_bar_color',
			[
				'label'     => esc_html__( 'Bar Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'condition' => [
					'circle_color_type' => 'solid',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-circle-bar' => 'stroke: {{VALUE}} !important;',
				],
			]
		);

		// Gradient Color 1
		$this->add_control(
			'circle_primary_color',
			[
				'label'       => esc_html__( 'Gradient Color 1 (Start)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#0077b6',
				'render_type' => 'template',
				'condition'   => [
					'circle_color_type' => 'gradient',
				],
			]
		);

		// Gradient Color 2
		$this->add_control(
			'circle_secondary_color',
			[
				'label'       => esc_html__( 'Gradient Color 2 (End)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#00b4d8',
				'render_type' => 'template',
				'condition'   => [
					'circle_color_type' => 'gradient',
				],
			]
		);

		// Track Stroke Color
		$this->add_control(
			'circle_track_color',
			[
				'label'     => esc_html__( 'Track Stroke Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .pns-circle-bg' => 'stroke: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'circle_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 10,
						'max'  => 80,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-progress-circular-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 5. STYLE TAB: TITLES & SUBTITLES
		// ==========================================
		$this->start_controls_section(
			'section_style_typography',
			[
				'label' => esc_html__( 'Titles & Subtitles', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => esc_html__( 'Title Typography & Color', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-title'          => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-circle-outer-title'      => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-progress-inside-content' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .pns-progress-title, {{WRAPPER}} .pns-circle-outer-title, {{WRAPPER}} .pns-progress-inside-content',
			]
		);

		$this->add_control(
			'heading_subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle / Description', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-subtitle'     => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-circle-outer-desc'     => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-circle-inner-subtitle' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .pns-progress-subtitle, {{WRAPPER}} .pns-circle-outer-desc, {{WRAPPER}} .pns-circle-inner-subtitle',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 6. STYLE TAB: COUNTER & ICONS
		// ==========================================
		$this->start_controls_section(
			'section_style_counter',
			[
				'label' => esc_html__( 'Counter & Icons', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_counter_style',
			[
				'label' => esc_html__( 'Number Counter', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'counter_color',
			[
				'label'     => esc_html__( 'Counter Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-counter-wrap'  => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-circle-inner-counter'   => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-progress-tooltip-pin'   => 'color: #ffffff;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_typography',
				'selector' => '{{WRAPPER}} .pns-progress-counter-wrap, {{WRAPPER}} .pns-circle-inner-counter, {{WRAPPER}} .pns-progress-tooltip-pin',
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'label'     => esc_html__( 'Icon Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-icon'       => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-circle-inner-icon'   => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 10,
						'max'  => 60,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-progress-icon'       => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-progress-icon svg'   => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-circle-inner-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-circle-inner-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Tooltip Pin styling
		$this->add_control(
			'heading_tooltip_style',
			[
				'label'     => esc_html__( 'Tooltip / Pin Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_type'   => 'linear',
					'linear_layout' => 'tooltip',
				],
			]
		);

		$this->add_control(
			'tooltip_bg',
			[
				'label'     => esc_html__( 'Tooltip Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-tooltip-pin' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .pns-progress-tooltip-pin::after' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'layout_type'   => 'linear',
					'linear_layout' => 'tooltip',
				],
			]
		);

		$this->add_control(
			'tooltip_text_color',
			[
				'label'     => esc_html__( 'Tooltip Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-progress-tooltip-pin' => 'color: {{VALUE}};',
				],
				'condition' => [
					'layout_type'   => 'linear',
					'linear_layout' => 'tooltip',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget Output
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$layout_type        = ! empty( $settings['layout_type'] ) ? $settings['layout_type'] : 'linear';
		$gauge_style        = ! empty( $settings['gauge_style'] ) ? $settings['gauge_style'] : 'circle';
		$linear_layout      = ! empty( $settings['linear_layout'] ) ? $settings['linear_layout'] : 'standard';
		$striped_pattern    = ! empty( $settings['striped_pattern'] ) && 'yes' === $settings['striped_pattern'];
		$animated_stripes   = ! empty( $settings['animated_stripes'] ) && 'yes' === $settings['animated_stripes'];
		$animation_duration = ! empty( $settings['animation_duration'] ) ? absint( $settings['animation_duration'] ) : 1400;
		$items              = ! empty( $settings['progress_items'] ) ? $settings['progress_items'] : [];

		if ( empty( $items ) ) {
			return;
		}

		$wrapper_classes = [ 'pns-progress-wrapper' ];

		if ( 'linear' === $layout_type ) {
			$wrapper_classes[] = 'pns-layout-' . sanitize_html_class( $linear_layout );
			if ( $striped_pattern ) {
				$wrapper_classes[] = 'pns-progress-striped';
			}
			if ( $animated_stripes ) {
				$wrapper_classes[] = 'pns-progress-animated';
			}
		} else {
			$gauge_class = 'pns-circle-gauge-' . sanitize_html_class( $gauge_style );
			$wrapper_classes[] = $gauge_class;
		}

		$widget_id = $this->get_id();

		// Circular settings
		$circle_color_type = ! empty( $settings['circle_color_type'] ) ? $settings['circle_color_type'] : 'solid';
		$circle_bar_color  = ! empty( $settings['circle_bar_color'] ) ? $settings['circle_bar_color'] : '#0077b6';
		$circle_c1         = ! empty( $settings['circle_primary_color'] ) ? $settings['circle_primary_color'] : '#0077b6';
		$circle_c2         = ! empty( $settings['circle_secondary_color'] ) ? $settings['circle_secondary_color'] : '#00b4d8';
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" data-duration="<?php echo esc_attr( $animation_duration ); ?>">

			<?php if ( 'linear' === $layout_type ) : ?>
				<!-- Linear Progress Bars -->
				<div class="pns-progress-linear-list">
					<?php foreach ( $items as $index => $item ) :
						$title      = ! empty( $item['item_title'] ) ? $item['item_title'] : '';
						$subtitle   = ! empty( $item['item_subtitle'] ) ? $item['item_subtitle'] : '';
						$percentage = isset( $item['item_percentage'] ) ? absint( $item['item_percentage'] ) : 0;
						$prefix     = isset( $item['item_prefix'] ) ? $item['item_prefix'] : '';
						$suffix     = isset( $item['item_suffix'] ) ? $item['item_suffix'] : '%';
						$has_icon   = ! empty( $item['item_icon']['value'] );

						// Item custom colors
						$item_style = '';
						$fill_style = '';
						if ( ! empty( $item['override_colors'] ) && 'yes' === $item['override_colors'] ) {
							$item_type = ! empty( $item['item_color_type'] ) ? $item['item_color_type'] : 'solid';
							$c1        = ! empty( $item['item_bar_color_1'] ) ? $item['item_bar_color_1'] : '#0077b6';
							$c2        = ! empty( $item['item_bar_color_2'] ) ? $item['item_bar_color_2'] : $c1;
							$track_c   = ! empty( $item['item_track_color'] ) ? $item['item_track_color'] : '';

							if ( 'gradient' === $item_type && ! empty( $item['item_bar_color_2'] ) ) {
								$fill_style = 'background: linear-gradient(90deg, ' . esc_attr( $c1 ) . ' 0%, ' . esc_attr( $c2 ) . ' 100%) !important;';
							} else {
								$fill_style = 'background: ' . esc_attr( $c1 ) . ' !important;';
							}
							if ( ! empty( $track_c ) ) {
								$item_style = 'background-color: ' . esc_attr( $track_c ) . ' !important;';
							}
						}
					?>
						<div class="pns-progress-linear-item" data-percentage="<?php echo esc_attr( $percentage ); ?>">

							<?php if ( 'standard' === $linear_layout ) : ?>
								<div class="pns-progress-header">
									<div class="pns-progress-title-wrap">
										<?php if ( $has_icon ) : ?>
											<span class="pns-progress-icon">
												<?php Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
										<div>
											<?php if ( ! empty( $title ) ) : ?>
												<h4 class="pns-progress-title"><?php echo esc_html( $title ); ?></h4>
											<?php endif; ?>
											<?php if ( ! empty( $subtitle ) ) : ?>
												<p class="pns-progress-subtitle"><?php echo esc_html( $subtitle ); ?></p>
											<?php endif; ?>
										</div>
									</div>

									<div class="pns-progress-counter-wrap">
										<?php if ( ! empty( $prefix ) ) : ?>
											<span class="pns-progress-prefix"><?php echo esc_html( $prefix ); ?></span>
										<?php endif; ?>
										<span class="pns-progress-number">0</span>
										<?php if ( ! empty( $suffix ) ) : ?>
											<span class="pns-progress-suffix"><?php echo esc_html( $suffix ); ?></span>
										<?php endif; ?>
									</div>
								</div>

								<div class="pns-progress-track" style="<?php echo esc_attr( $item_style ); ?>">
									<div class="pns-progress-fill" style="<?php echo esc_attr( $fill_style ); ?>"></div>
								</div>

							<?php elseif ( 'inside' === $linear_layout ) : ?>
								<div class="pns-progress-track" style="<?php echo esc_attr( $item_style ); ?>">
									<div class="pns-progress-fill" style="<?php echo esc_attr( $fill_style ); ?>">
										<div class="pns-progress-inside-content">
											<div class="pns-progress-title-wrap">
												<?php if ( $has_icon ) : ?>
													<span class="pns-progress-icon">
														<?php Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
													</span>
												<?php endif; ?>
												<?php if ( ! empty( $title ) ) : ?>
													<span class="pns-progress-title"><?php echo esc_html( $title ); ?></span>
												<?php endif; ?>
											</div>

											<div class="pns-progress-counter-wrap">
												<?php if ( ! empty( $prefix ) ) : ?>
													<span class="pns-progress-prefix"><?php echo esc_html( $prefix ); ?></span>
												<?php endif; ?>
												<span class="pns-progress-number">0</span>
												<?php if ( ! empty( $suffix ) ) : ?>
													<span class="pns-progress-suffix"><?php echo esc_html( $suffix ); ?></span>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>

							<?php elseif ( 'tooltip' === $linear_layout ) : ?>
								<div class="pns-progress-header">
									<div class="pns-progress-title-wrap">
										<?php if ( $has_icon ) : ?>
											<span class="pns-progress-icon">
												<?php Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
										<div>
											<?php if ( ! empty( $title ) ) : ?>
												<h4 class="pns-progress-title"><?php echo esc_html( $title ); ?></h4>
											<?php endif; ?>
											<?php if ( ! empty( $subtitle ) ) : ?>
												<p class="pns-progress-subtitle"><?php echo esc_html( $subtitle ); ?></p>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<div class="pns-progress-track" style="<?php echo esc_attr( $item_style ); ?>">
									<div class="pns-progress-fill" style="<?php echo esc_attr( $fill_style ); ?>">
										<div class="pns-progress-tooltip-pin">
											<?php if ( ! empty( $prefix ) ) : ?>
												<span class="pns-progress-prefix"><?php echo esc_html( $prefix ); ?></span>
											<?php endif; ?>
											<span class="pns-progress-number">0</span>
											<?php if ( ! empty( $suffix ) ) : ?>
												<span class="pns-progress-suffix"><?php echo esc_html( $suffix ); ?></span>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>

						</div>
					<?php endforeach; ?>
				</div>

			<?php else : ?>
				<!-- Circular Progress & Gauges Grid -->
				<?php
				$cols = ! empty( $settings['circular_columns'] ) ? $settings['circular_columns'] : '3';
				$grid_col_class = 'pns-grid-cols-' . sanitize_html_class( $cols );
				?>
				<div class="pns-progress-circular-grid <?php echo esc_attr( $grid_col_class ); ?>">
					<?php foreach ( $items as $index => $item ) :
						$title      = ! empty( $item['item_title'] ) ? $item['item_title'] : '';
						$subtitle   = ! empty( $item['item_subtitle'] ) ? $item['item_subtitle'] : '';
						$percentage = isset( $item['item_percentage'] ) ? absint( $item['item_percentage'] ) : 0;
						$prefix     = isset( $item['item_prefix'] ) ? $item['item_prefix'] : '';
						$suffix     = isset( $item['item_suffix'] ) ? $item['item_suffix'] : '%';
						$has_icon   = ! empty( $item['item_icon']['value'] );

						// Item colors & SVG gradient ID
						$grad_id = 'pns-grad-' . esc_attr( $widget_id ) . '-' . esc_attr( $index );

						$override  = ! empty( $item['override_colors'] ) && 'yes' === $item['override_colors'];
						$item_type = ! empty( $item['item_color_type'] ) ? $item['item_color_type'] : 'solid';

						$bar_stroke_style = '';
						$bg_stroke_style  = '';

						if ( $override ) {
							$c1      = ! empty( $item['item_bar_color_1'] ) ? $item['item_bar_color_1'] : '#0077b6';
							$c2      = ! empty( $item['item_bar_color_2'] ) ? $item['item_bar_color_2'] : $c1;
							$track_c = ! empty( $item['item_track_color'] ) ? $item['item_track_color'] : '';

							if ( ! empty( $track_c ) ) {
								$bg_stroke_style = 'stroke: ' . esc_attr( $track_c ) . ' !important;';
							}

							if ( 'gradient' === $item_type && ! empty( $item['item_bar_color_2'] ) ) {
								$bar_stroke_style = 'stroke: url(#' . esc_attr( $grad_id ) . ') !important;';
							} else {
								$bar_stroke_style = 'stroke: ' . esc_attr( $c1 ) . ' !important;';
							}
						} else {
							// Use global settings
							$c1 = $circle_c1;
							$c2 = $circle_c2;

							if ( 'gradient' === $circle_color_type ) {
								$bar_stroke_style = 'stroke: url(#' . esc_attr( $grad_id ) . ');';
							} else {
								$bar_stroke_style = 'stroke: ' . esc_attr( $circle_bar_color ) . ';';
							}
						}
					?>
						<div class="pns-progress-circular-item" data-percentage="<?php echo esc_attr( $percentage ); ?>" data-gauge="<?php echo esc_attr( $gauge_style ); ?>">
							<div class="pns-circle-container">
								<svg class="pns-circle-svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet">
									<defs>
										<linearGradient id="<?php echo esc_attr( $grad_id ); ?>" x1="0%" y1="0%" x2="100%" y2="100%">
											<stop offset="0%" stop-color="<?php echo esc_attr( $c1 ); ?>" />
											<stop offset="100%" stop-color="<?php echo esc_attr( $c2 ); ?>" />
										</linearGradient>
									</defs>

									<!-- Track background circle -->
									<circle class="pns-circle-bg" cx="50" cy="50" r="45" style="<?php echo esc_attr( $bg_stroke_style ); ?>" />

									<!-- Animated progress bar circle -->
									<circle class="pns-circle-bar" cx="50" cy="50" r="45" style="<?php echo esc_attr( $bar_stroke_style ); ?>" />
								</svg>

								<!-- Inner Content (Icon, Counter, Subtitle) -->
								<div class="pns-circle-inner-content">
									<?php if ( $has_icon ) : ?>
										<div class="pns-circle-inner-icon">
											<?php Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>
									<?php endif; ?>

									<div class="pns-circle-inner-counter">
										<?php if ( ! empty( $prefix ) ) : ?>
											<span class="pns-progress-prefix"><?php echo esc_html( $prefix ); ?></span>
										<?php endif; ?>
										<span class="pns-progress-number">0</span>
										<?php if ( ! empty( $suffix ) ) : ?>
											<span class="pns-progress-suffix"><?php echo esc_html( $suffix ); ?></span>
										<?php endif; ?>
									</div>

									<?php if ( ! empty( $subtitle ) ) : ?>
										<span class="pns-circle-inner-subtitle"><?php echo esc_html( $subtitle ); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Outer Content below circle -->
							<?php if ( ! empty( $title ) ) : ?>
								<div class="pns-circle-outer-content">
									<h4 class="pns-circle-outer-title"><?php echo esc_html( $title ); ?></h4>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

			<?php endif; ?>

		</div>
		<?php
	}
}
