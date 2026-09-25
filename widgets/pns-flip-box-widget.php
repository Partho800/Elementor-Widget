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

/**
 * PNS 3D Flip Box Widget for Elementor
 *
 * High-performance 3D interactive flipping card widget with front/back faces,
 * multiple 3D flip directions, custom action buttons, and mobile touch support.
 */
class PNS_Flip_Box_Widget extends Widget_Base {

	/**
	 * Widget Name
	 */
	public function get_name() {
		return 'pns_flip_box_widget';
	}

	/**
	 * Widget Title
	 */
	public function get_title() {
		return esc_html__( 'PNS 3D Flip Box', 'pns-addons-for-elementor' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'eicon-flip-box';
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
		return [ 'pns-flip-box-style' ];
	}

	/**
	 * Script dependencies
	 */
	public function get_script_depends() {
		return [ 'pns-flip-box-script' ];
	}

	/**
	 * Register Widget Controls
	 */
	protected function register_controls() {

		// ==========================================
		// 1. CONTENT TAB: FRONT SIDE
		// ==========================================
		$this->start_controls_section(
			'section_front_content',
			[
				'label' => esc_html__( 'Front Side', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'front_graphic_element',
			[
				'label'   => esc_html__( 'Graphic Element', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'none'  => [
						'title' => esc_html__( 'None', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-ban',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-info-circle',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-image',
					],
				],
				'default' => 'icon',
			]
		);

		$this->add_control(
			'front_icon',
			[
				'label'     => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-layer-group',
					'library' => 'fa-solid',
				],
				'condition' => [
					'front_graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'front_image',
			[
				'label'     => esc_html__( 'Image', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'front_graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'front_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Pre-Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Features & UI', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'front_title',
			[
				'label'       => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '3D Interactive Flip', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'front_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'front_description',
			[
				'label'   => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Hover with mouse or tap on mobile to reveal hidden back content, action buttons, and details with realistic 3D depth.', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_responsive_control(
			'front_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => '--pns-fb-front-align: flex-start; --pns-fb-front-text: left;',
					'center' => '--pns-fb-front-align: center; --pns-fb-front-text: center;',
					'right'  => '--pns-fb-front-align: flex-end; --pns-fb-front-text: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 2. CONTENT TAB: BACK SIDE
		// ==========================================
		$this->start_controls_section(
			'section_back_content',
			[
				'label' => esc_html__( 'Back Side', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'back_graphic_element',
			[
				'label'   => esc_html__( 'Graphic / Badge', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'none'  => [
						'title' => esc_html__( 'None', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-ban',
					],
					'badge' => [
						'title' => esc_html__( 'Badge', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-ribbon',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-info-circle',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-image',
					],
				],
				'default' => 'badge',
			]
		);

		$this->add_control(
			'back_badge_text',
			[
				'label'     => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Featured', 'pns-addons-for-elementor' ),
				'condition' => [
					'back_graphic_element' => 'badge',
				],
			]
		);

		$this->add_control(
			'back_icon',
			[
				'label'     => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
				'condition' => [
					'back_graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'back_image',
			[
				'label'     => esc_html__( 'Image', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'back_graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'back_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Pre-Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Instant Access', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'back_title',
			[
				'label'       => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discover All Benefits', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'back_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'back_description',
			[
				'label'   => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Unlock premium widgets, interactive animations, and responsive tools designed to elevate your websites.', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'back_show_button',
			[
				'label'        => esc_html__( 'Show Action Button', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'back_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Details', 'pns-addons-for-elementor' ),
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_button_link',
			[
				'label'       => esc_html__( 'Button Link', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'condition'   => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_button_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_button_icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'after',
				'options'   => [
					'before' => esc_html__( 'Before Text', 'pns-addons-for-elementor' ),
					'after'  => esc_html__( 'After Text', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'back_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => '--pns-fb-back-align: flex-start; --pns-fb-back-text: left;',
					'center' => '--pns-fb-back-align: center; --pns-fb-back-text: center;',
					'right'  => '--pns-fb-back-align: flex-end; --pns-fb-back-text: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 3. CONTENT TAB: SETTINGS & 3D EFFECTS
		// ==========================================
		$this->start_controls_section(
			'section_box_settings',
			[
				'label' => esc_html__( 'Flip & 3D Settings', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label'   => esc_html__( 'Flip Direction / Effect', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flip-left',
				'options' => [
					'flip-left'  => esc_html__( 'Flip Left', 'pns-addons-for-elementor' ),
					'flip-right' => esc_html__( 'Flip Right', 'pns-addons-for-elementor' ),
					'flip-up'    => esc_html__( 'Flip Up', 'pns-addons-for-elementor' ),
					'flip-down'  => esc_html__( 'Flip Down', 'pns-addons-for-elementor' ),
					'push-left'  => esc_html__( '3D Push Left', 'pns-addons-for-elementor' ),
					'zoom-in'    => esc_html__( '3D Zoom & Flip', 'pns-addons-for-elementor' ),
					'fade'       => esc_html__( 'Fade Swap', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'box_height',
			[
				'label'      => esc_html__( 'Card Height (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min'  => 180,
						'max'  => 800,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 340,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'flip_trigger',
			[
				'label'   => esc_html__( 'Flip Trigger (Desktop)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
					'click' => esc_html__( 'Click / Tap', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'content_3d_pop',
			[
				'label'        => esc_html__( '3D Depth Pop (Z-Index)', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'     => esc_html__( 'Alignment (All Together)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'pns-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors_dictionary' => [
					'left'   => '--pns-fb-align: flex-start; --pns-fb-text-align: left;',
					'center' => '--pns-fb-align: center; --pns-fb-text-align: center;',
					'right'  => '--pns-fb-align: flex-end; --pns-fb-text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 4. STYLE TAB: FRONT SIDE
		// ==========================================
		$this->start_controls_section(
			'section_style_front',
			[
				'label' => esc_html__( 'Front Side Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'front_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-flip-box-front',
			]
		);

		$this->add_control(
			'front_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'front_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'front_border',
				'selector' => '{{WRAPPER}} .pns-flip-box-front',
			]
		);

		$this->add_responsive_control(
			'front_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'front_box_shadow',
				'selector' => '{{WRAPPER}} .pns-flip-box-front',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 5. STYLE TAB: BACK SIDE
		// ==========================================
		$this->start_controls_section(
			'section_style_back',
			[
				'label' => esc_html__( 'Back Side Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'back_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-flip-box-back',
			]
		);

		$this->add_control(
			'back_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-back .pns-flip-box-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'back_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'back_border',
				'selector' => '{{WRAPPER}} .pns-flip-box-back',
			]
		);

		$this->add_responsive_control(
			'back_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'back_box_shadow',
				'selector' => '{{WRAPPER}} .pns-flip-box-back',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 6. STYLE TAB: FRONT TYPOGRAPHY & COLORS
		// ==========================================
		$this->start_controls_section(
			'section_style_front_typo',
			[
				'label' => esc_html__( 'Front Content Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_front_icon',
			[
				'label' => esc_html__( 'Icon / Graphic', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'front_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'front_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 119, 182, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'front_icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 16,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_front_title',
			[
				'label'     => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'front_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'front_title_typography',
				'selector' => '{{WRAPPER}} .pns-flip-box-front .pns-flip-box-title',
			]
		);

		$this->add_control(
			'heading_front_desc',
			[
				'label'     => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'front_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-front .pns-flip-box-desc' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'front_desc_typography',
				'selector' => '{{WRAPPER}} .pns-flip-box-front .pns-flip-box-desc',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 7. STYLE TAB: BACK TYPOGRAPHY & COLORS
		// ==========================================
		$this->start_controls_section(
			'section_style_back_typo',
			[
				'label' => esc_html__( 'Back Content Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_back_title',
			[
				'label' => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'back_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-back .pns-flip-box-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'back_title_typography',
				'selector' => '{{WRAPPER}} .pns-flip-box-back .pns-flip-box-title',
			]
		);

		$this->add_control(
			'heading_back_desc',
			[
				'label'     => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'back_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-back .pns-flip-box-desc' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'back_desc_typography',
				'selector' => '{{WRAPPER}} .pns-flip-box-back .pns-flip-box-desc',
			]
		);

		$this->add_control(
			'heading_back_badge',
			[
				'label'     => esc_html__( 'Badge Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 8. STYLE TAB: ACTION BUTTON
		// ==========================================
		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Action Button Style', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .pns-flip-box-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		// Normal State
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pns-flip-box-btn',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0077b6',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-btn:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-flip-box-btn:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .pns-flip-box-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 10,
					'right'    => 24,
					'bottom'   => 10,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 8,
					'right'    => 8,
					'bottom'   => 8,
					'left'     => 8,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-flip-box-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$flip_effect     = ! empty( $settings['flip_effect'] ) ? $settings['flip_effect'] : 'flip-left';
		$flip_trigger    = ! empty( $settings['flip_trigger'] ) ? $settings['flip_trigger'] : 'hover';
		$content_3d_pop  = ! empty( $settings['content_3d_pop'] ) && 'yes' === $settings['content_3d_pop'];

		// Front Settings
		$front_graphic   = ! empty( $settings['front_graphic_element'] ) ? $settings['front_graphic_element'] : 'icon';
		$front_title     = ! empty( $settings['front_title'] ) ? $settings['front_title'] : '';
		$front_subtitle  = ! empty( $settings['front_subtitle'] ) ? $settings['front_subtitle'] : '';
		$front_desc      = ! empty( $settings['front_description'] ) ? $settings['front_description'] : '';
		$front_tag       = ! empty( $settings['front_title_tag'] ) ? $settings['front_title_tag'] : 'h3';

		// Back Settings
		$back_graphic    = ! empty( $settings['back_graphic_element'] ) ? $settings['back_graphic_element'] : 'badge';
		$back_badge_text = ! empty( $settings['back_badge_text'] ) ? $settings['back_badge_text'] : '';
		$back_title      = ! empty( $settings['back_title'] ) ? $settings['back_title'] : '';
		$back_subtitle   = ! empty( $settings['back_subtitle'] ) ? $settings['back_subtitle'] : '';
		$back_desc       = ! empty( $settings['back_description'] ) ? $settings['back_description'] : '';
		$back_tag        = ! empty( $settings['back_title_tag'] ) ? $settings['back_title_tag'] : 'h3';

		$show_btn        = ! empty( $settings['back_show_button'] ) && 'yes' === $settings['back_show_button'];
		$btn_text        = ! empty( $settings['back_button_text'] ) ? $settings['back_button_text'] : '';
		$btn_link        = ! empty( $settings['back_button_link']['url'] ) ? $settings['back_button_link']['url'] : '#';
		$btn_icon_pos    = ! empty( $settings['back_button_icon_position'] ) ? $settings['back_button_icon_position'] : 'after';

		$wrapper_classes = [ 'pns-flip-box-wrapper' ];
		$box_classes     = [ 'pns-flip-box', 'pns-flip-direction-' . sanitize_html_class( $flip_effect ) ];

		if ( $content_3d_pop ) {
			$box_classes[] = 'pns-flip-box-3d-pop';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			<div class="<?php echo esc_attr( implode( ' ', $box_classes ) ); ?>" data-trigger="<?php echo esc_attr( $flip_trigger ); ?>">
				<div class="pns-flip-box-inner">

					<!-- FRONT FACE -->
					<div class="pns-flip-box-front">
						<div class="pns-flip-box-overlay"></div>
						<div class="pns-flip-box-content">

							<?php if ( 'icon' === $front_graphic && ! empty( $settings['front_icon']['value'] ) ) : ?>
								<div class="pns-flip-box-graphic">
									<div class="pns-flip-box-icon">
										<?php Icons_Manager::render_icon( $settings['front_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
								</div>
							<?php elseif ( 'image' === $front_graphic && ! empty( $settings['front_image']['url'] ) ) : ?>
								<div class="pns-flip-box-graphic">
									<img class="pns-flip-box-image" src="<?php echo esc_url( $settings['front_image']['url'] ); ?>" alt="<?php echo esc_attr( $front_title ); ?>" />
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $front_subtitle ) ) : ?>
								<p class="pns-flip-box-subtitle"><?php echo esc_html( $front_subtitle ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $front_title ) ) : ?>
								<<?php echo esc_html( $front_tag ); ?> class="pns-flip-box-title"><?php echo esc_html( $front_title ); ?></<?php echo esc_html( $front_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $front_desc ) ) : ?>
								<p class="pns-flip-box-desc"><?php echo esc_html( $front_desc ); ?></p>
							<?php endif; ?>

						</div>
					</div>

					<!-- BACK FACE -->
					<div class="pns-flip-box-back">
						<div class="pns-flip-box-overlay"></div>

						<?php if ( 'badge' === $back_graphic && ! empty( $back_badge_text ) ) : ?>
							<span class="pns-flip-box-badge"><?php echo esc_html( $back_badge_text ); ?></span>
						<?php endif; ?>

						<div class="pns-flip-box-content">

							<?php if ( 'icon' === $back_graphic && ! empty( $settings['back_icon']['value'] ) ) : ?>
								<div class="pns-flip-box-graphic">
									<div class="pns-flip-box-icon">
										<?php Icons_Manager::render_icon( $settings['back_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
								</div>
							<?php elseif ( 'image' === $back_graphic && ! empty( $settings['back_image']['url'] ) ) : ?>
								<div class="pns-flip-box-graphic">
									<img class="pns-flip-box-image" src="<?php echo esc_url( $settings['back_image']['url'] ); ?>" alt="<?php echo esc_attr( $back_title ); ?>" />
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $back_subtitle ) ) : ?>
								<p class="pns-flip-box-subtitle"><?php echo esc_html( $back_subtitle ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $back_title ) ) : ?>
								<<?php echo esc_html( $back_tag ); ?> class="pns-flip-box-title"><?php echo esc_html( $back_title ); ?></<?php echo esc_html( $back_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $back_desc ) ) : ?>
								<p class="pns-flip-box-desc"><?php echo esc_html( $back_desc ); ?></p>
							<?php endif; ?>

							<?php if ( $show_btn && ! empty( $btn_text ) ) :
								$this->add_link_attributes( 'button', $settings['back_button_link'] );
								$this->add_render_attribute( 'button', 'class', 'pns-flip-box-btn' );
								$has_btn_icon = ! empty( $settings['back_button_icon']['value'] );
							?>
								<div class="pns-flip-box-btn-wrap">
									<a <?php $this->print_render_attribute_string( 'button' ); ?>>
										<?php if ( $has_btn_icon && 'before' === $btn_icon_pos ) : ?>
											<?php Icons_Manager::render_icon( $settings['back_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php endif; ?>

										<span><?php echo esc_html( $btn_text ); ?></span>

										<?php if ( $has_btn_icon && 'after' === $btn_icon_pos ) : ?>
											<?php Icons_Manager::render_icon( $settings['back_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php endif; ?>
									</a>
								</div>
							<?php endif; ?>

						</div>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}
