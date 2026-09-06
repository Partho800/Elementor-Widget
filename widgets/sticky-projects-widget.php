<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;

class Custom_Sticky_Projects_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_sticky_projects_widget';
	}

	public function get_title() {
		return esc_html__( 'Sticky Stacking Projects', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'sticky', 'stacking', 'project', 'cards', 'scroll', 'custom' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: STACKING PROJECT CARDS (LEFT) ---
		$this->start_controls_section(
			'section_cards_content',
			[
				'label' => esc_html__( 'Stacking Cards (Left Column)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_cards = new Repeater();

		$repeater_cards->add_control(
			'card_title',
			[
				'label'       => esc_html__( 'Title', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Construction Company', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_cards->add_control(
			'card_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Category Tag', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Project 01', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_cards->add_control(
			'card_desc',
			[
				'label'       => esc_html__( 'Short Description / Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'custom-elementor-widgets' ),
				'rows'        => 3,
			]
		);

		$repeater_cards->add_control(
			'card_btn_text',
			[
				'label'       => esc_html__( 'Card Button Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View Project', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_cards->add_control(
			'card_btn_icon',
			[
				'label'   => esc_html__( 'Card Button Icon', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater_cards->add_control(
			'card_image',
			[
				'label'   => esc_html__( 'Card Background Image', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater_cards->add_control(
			'card_link',
			[
				'label'       => esc_html__( 'Card Link', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'custom-elementor-widgets' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'project_cards',
			[
				'label'       => esc_html__( 'Project Cards List', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_cards->get_controls(),
				'default'     => [
					[
						'card_title'    => esc_html__( 'Construction Company', 'custom-elementor-widgets' ),
						'card_subtitle' => esc_html__( 'Project 01', 'custom-elementor-widgets' ),
						'card_desc'     => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'custom-elementor-widgets' ),
						'card_btn_text' => esc_html__( 'View Project', 'custom-elementor-widgets' ),
						'card_image'    => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'card_title'    => esc_html__( 'Architecture & Design', 'custom-elementor-widgets' ),
						'card_subtitle' => esc_html__( 'Project 02', 'custom-elementor-widgets' ),
						'card_desc'     => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'custom-elementor-widgets' ),
						'card_btn_text' => esc_html__( 'View Project', 'custom-elementor-widgets' ),
						'card_image'    => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'card_title'    => esc_html__( 'Warehouse & Logistics', 'custom-elementor-widgets' ),
						'card_subtitle' => esc_html__( 'Project 03', 'custom-elementor-widgets' ),
						'card_desc'     => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'custom-elementor-widgets' ),
						'card_btn_text' => esc_html__( 'View Project', 'custom-elementor-widgets' ),
						'card_image'    => [ 'url' => Utils::get_placeholder_image_src() ],
					],
				],
				'title_field' => '{{{ card_title }}}',
			]
		);

		// Display Mode Controls
		$this->add_control(
			'card_desc_display',
			[
				'label'     => esc_html__( 'Short Text Display Mode', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'hover'  => esc_html__( 'Reveal on Hover', 'custom-elementor-widgets' ),
					'always' => esc_html__( 'Always Visible', 'custom-elementor-widgets' ),
					'none'   => esc_html__( 'Hide / Disable', 'custom-elementor-widgets' ),
				],
				'default'   => 'hover',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_btn_display',
			[
				'label'   => esc_html__( 'Card Button Display Mode', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'hover'  => esc_html__( 'Reveal on Hover', 'custom-elementor-widgets' ),
					'always' => esc_html__( 'Always Visible', 'custom-elementor-widgets' ),
					'none'   => esc_html__( 'Hide / Disable', 'custom-elementor-widgets' ),
				],
				'default' => 'hover',
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'      => esc_html__( 'Card Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 800 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 440 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'base_sticky_top',
			[
				'label'      => esc_html__( 'Sticky Top Base Offset', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 300 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 90 ],
			]
		);

		$this->add_responsive_control(
			'stacking_shift',
			[
				'label'      => esc_html__( 'Stacking Top Shift per Card', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
			]
		);

		$this->end_controls_section();


		// --- SECTION: HEADER CONTENT (RIGHT SIDE) ---
		$this->start_controls_section(
			'section_header_content',
			[
				'label' => esc_html__( 'Section Header (Right Side)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subheading',
			[
				'label'       => esc_html__( 'Subheading / Tag', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'INTRIGUED BY OUR PROJECT?', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Main Heading', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Take a look our best project', 'custom-elementor-widgets' ),
				'rows'        => 2,
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Heading HTML Tag', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
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
				'default' => 'h2',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo dolor in reprehenderit.', 'custom-elementor-widgets' ),
				'rows'    => 4,
			]
		);

		$this->add_responsive_control(
			'right_sticky_top',
			[
				'label'      => esc_html__( 'Right Side Sticky Top Offset', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 300 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-right-col' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- SECTION: BUTTON CONTENT ---
		$this->start_controls_section(
			'section_button_content',
			[
				'label' => esc_html__( 'Call to Action Button', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See All Project', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'custom-elementor-widgets' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'custom-elementor-widgets' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'button_icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before' => esc_html__( 'Before Text', 'custom-elementor-widgets' ),
					'after'  => esc_html__( 'After Text', 'custom-elementor-widgets' ),
				],
				'default'   => 'after',
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();


		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// --- STYLE: STACKING CARDS CONTAINER & OVERLAY ---
		$this->start_controls_section(
			'section_cards_style',
			[
				'label' => esc_html__( 'Project Cards Container & Overlay', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Card Fallback Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_overlay_settings',
			[
				'label'     => esc_html__( 'Bottom Overlay Settings (Text Readability)', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'card_overlay_height',
			[
				'label'      => esc_html__( 'Bottom Overlay Height (%)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [ 'min' => 20, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 65 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-overlay' => 'height: {{SIZE}}%;',
				],
			]
		);

		$this->add_control(
			'card_overlay_gradient_start',
			[
				'label'     => esc_html__( 'Overlay Top Gradient Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0)',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-overlay' => 'background: linear-gradient(180deg, {{VALUE}} 0%, {{card_overlay_gradient_end.VALUE}} 100%);',
				],
			]
		);

		$this->add_control(
			'card_overlay_gradient_end',
			[
				'label'     => esc_html__( 'Overlay Bottom Tint Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.92)',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-overlay' => 'background: linear-gradient(180deg, {{card_overlay_gradient_start.VALUE}} 0%, {{VALUE}} 100%);',
				],
			]
		);

		$this->add_responsive_control(
			'card_overlay_backdrop_blur',
			[
				'label'      => esc_html__( 'Backdrop Glass Blur', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-overlay' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'card_overlay_opacity',
			[
				'label'      => esc_html__( 'Overlay Opacity (Normal)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 0.95 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_overlay_hover_opacity',
			[
				'label'      => esc_html__( 'Overlay Opacity (Hover)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1.0 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-item:hover .ce-project-card-overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_content_padding',
			[
				'label'      => esc_html__( 'Card Inner Content Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '32', 'right' => '36', 'bottom' => '32', 'left' => '36', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .ce-project-card-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .ce-project-card-item',
			]
		);

		$this->end_controls_section();


		// --- STYLE: CARD SUBTITLE & TITLE ---
		$this->start_controls_section(
			'section_card_titles_style',
			[
				'label' => esc_html__( 'Card Subtitle & Title Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subtitle Style
		$this->add_control(
			'heading_card_subtitle_style',
			[
				'label' => esc_html__( 'Card Subtitle / Tag', 'custom-elementor-widgets' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'card_subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_subtitle_typography',
				'selector' => '{{WRAPPER}} .ce-project-card-subtitle',
			]
		);

		$this->add_responsive_control(
			'card_subtitle_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Title Style
		$this->add_control(
			'heading_card_title_style',
			[
				'label'     => esc_html__( 'Card Title', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_card_title_style' );

		$this->start_controls_tab(
			'tab_card_title_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_card_title_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Title Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#60a5fa',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-item:hover .ce-project-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .ce-project-card-title',
			]
		);

		$this->add_responsive_control(
			'card_title_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: CARD SHORT TEXT / DESCRIPTION ---
		$this->start_controls_section(
			'section_card_desc_style',
			[
				'label' => esc_html__( 'Card Short Text / Description Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .ce-project-card-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_desc_typography',
				'selector' => '{{WRAPPER}} .ce-project-card-desc',
			]
		);

		$this->add_responsive_control(
			'card_desc_max_width',
			[
				'label'      => esc_html__( 'Max Width (%)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 50, 'max' => 100 ] ],
				'default'    => [ 'unit' => '%', 'size' => 90 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_desc_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-card-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: CARD INNER BUTTON ---
		$this->start_controls_section(
			'section_card_inner_btn_style',
			[
				'label' => esc_html__( 'Card Inner Button Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_inner_btn_typography',
				'selector' => '{{WRAPPER}} .ce-project-inner-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_card_inner_btn_style' );

		// Normal State
		$this->start_controls_tab(
			'tab_card_inner_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_inner_btn_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-project-inner-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-project-inner-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_inner_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-project-inner-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_inner_btn_border',
				'selector' => '{{WRAPPER}} .ce-project-inner-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_inner_btn_box_shadow',
				'selector' => '{{WRAPPER}} .ce-project-inner-btn',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'tab_card_inner_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_inner_btn_hover_color',
			[
				'label'     => esc_html__( 'Hover Text & Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-project-inner-btn:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-project-inner-btn:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_inner_btn_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .ce-project-inner-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_inner_btn_hover_border',
				'selector' => '{{WRAPPER}} .ce-project-inner-btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_inner_btn_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-project-inner-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_inner_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-inner-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'card_inner_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-inner-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_inner_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-inner-btn i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .ce-project-inner-btn svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important; max-width: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_inner_btn_icon_gap',
			[
				'label'      => esc_html__( 'Icon Space / Gap', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-project-inner-btn' => 'gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: RIGHT SIDE CONTENT ---
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Section Header Style (Right)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subheading
		$this->add_control(
			'heading_subheading_style',
			[
				'label' => esc_html__( 'Subheading / Tag', 'custom-elementor-widgets' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'subheading_color',
			[
				'label'     => esc_html__( 'Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-subheading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'selector' => '{{WRAPPER}} .ce-sticky-subheading',
			]
		);

		$this->add_responsive_control(
			'subheading_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-subheading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Main Heading
		$this->add_control(
			'heading_main_heading_style',
			[
				'label'     => esc_html__( 'Main Heading', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ce-sticky-heading',
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Description
		$this->add_control(
			'heading_desc_style',
			[
				'label'     => esc_html__( 'Description', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ce-sticky-desc',
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 30 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: BUTTON ---
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Right Button Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'custom-elementor-widgets' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'custom-elementor-widgets' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'custom-elementor-widgets' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-btn-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .ce-sticky-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		// Button Normal
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-sticky-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#222938',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .ce-sticky-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ce-sticky-btn',
			]
		);

		$this->end_controls_tab();

		// Button Hover
		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-btn:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-sticky-btn:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .ce-sticky-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_hover_border',
				'selector' => '{{WRAPPER}} .ce-sticky-btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-sticky-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => '14', 'right' => '34', 'bottom' => '14', 'left' => '34', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-sticky-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$heading_tag = ! empty( $settings['heading_tag'] ) ? esc_html( $settings['heading_tag'] ) : 'h2';

		$base_top  = isset( $settings['base_sticky_top']['size'] ) ? intval( $settings['base_sticky_top']['size'] ) : 90;
		$shift_top = isset( $settings['stacking_shift']['size'] ) ? intval( $settings['stacking_shift']['size'] ) : 20;
		?>

		<div class="ce-sticky-projects-section">
			<div class="ce-sticky-projects-row">

				<!-- Left Column: Stacking Project Cards -->
				<div class="ce-sticky-left-col">
					<?php if ( ! empty( $settings['project_cards'] ) ) : ?>
						<?php foreach ( $settings['project_cards'] as $index => $card ) :
							$repeater_setting_key = $this->get_repeater_setting_key( 'card_title', 'project_cards', $index );
							$this->add_inline_editing_attributes( $repeater_setting_key, 'none' );

							$calc_top_px = $base_top + ( $index * $shift_top );

							$link_url = ! empty( $card['card_link']['url'] ) ? $card['card_link']['url'] : '#';
							$target   = ! empty( $card['card_link']['is_external'] ) ? ' target="_blank"' : '';
							$nofollow = ! empty( $card['card_link']['nofollow'] ) ? ' rel="nofollow"' : '';
							
							$img_src = ! empty( $card['card_image']['url'] ) ? $card['card_image']['url'] : Utils::get_placeholder_image_src();
						?>
							<div class="ce-project-card-item elementor-repeater-item-<?php echo esc_attr( $card['_id'] ); ?>" style="top: <?php echo esc_attr( $calc_top_px ); ?>px; z-index: <?php echo esc_attr( $index + 1 ); ?>;">
								<a href="<?php echo esc_url( $link_url ); ?>" class="ce-project-card-link"<?php echo $target . $nofollow; ?>>
									<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $card['card_title'] ); ?>" class="ce-project-card-img" />
									
									<div class="ce-project-card-overlay"></div>

									<div class="ce-project-card-content">
										<?php if ( ! empty( $card['card_subtitle'] ) ) : ?>
											<span class="ce-project-card-subtitle">
												<?php echo esc_html( $card['card_subtitle'] ); ?>
											</span>
										<?php endif; ?>

										<h3 class="ce-project-card-title" <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
											<?php echo esc_html( $card['card_title'] ); ?>
										</h3>

										<?php 
										$desc_display = ! empty( $settings['card_desc_display'] ) ? $settings['card_desc_display'] : 'hover';
										if ( 'none' !== $desc_display && ! empty( $card['card_desc'] ) ) : 
											$desc_class = ( 'hover' === $desc_display ) ? 'ce-project-card-desc ce-reveal-hover' : 'ce-project-card-desc';
										?>
											<p class="<?php echo esc_attr( $desc_class ); ?>">
												<?php echo esc_html( $card['card_desc'] ); ?>
											</p>
										<?php endif; ?>

										<?php 
										$btn_display = ! empty( $settings['card_btn_display'] ) ? $settings['card_btn_display'] : 'hover';
										if ( 'none' !== $btn_display && ! empty( $card['card_btn_text'] ) ) : 
											$btn_class = ( 'hover' === $btn_display ) ? 'ce-project-inner-btn ce-reveal-hover' : 'ce-project-inner-btn';
										?>
											<span class="<?php echo esc_attr( $btn_class ); ?>">
												<span><?php echo esc_html( $card['card_btn_text'] ); ?></span>
												<?php if ( ! empty( $card['card_btn_icon']['value'] ) ) : ?>
													<?php \Elementor\Icons_Manager::render_icon( $card['card_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
												<?php else : ?>
													<i class="fas fa-arrow-right" aria-hidden="true" style="font-size: 11px;"></i>
												<?php endif; ?>
											</span>
										<?php endif; ?>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<!-- Right Column: Sticky Info Panel -->
				<div class="ce-sticky-right-col">
					<div class="ce-sticky-right-content">

						<!-- Subheading -->
						<?php if ( ! empty( $settings['subheading'] ) ) : ?>
							<span class="ce-sticky-subheading">
								<?php echo esc_html( $settings['subheading'] ); ?>
							</span>
						<?php endif; ?>

						<!-- Main Heading -->
						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<<?php echo $heading_tag; ?> class="ce-sticky-heading">
								<?php echo esc_html( $settings['heading'] ); ?>
							</<?php echo $heading_tag; ?>>
						<?php endif; ?>

						<!-- Description -->
						<?php if ( ! empty( $settings['description'] ) ) : ?>
							<p class="ce-sticky-desc">
								<?php echo esc_html( $settings['description'] ); ?>
							</p>
						<?php endif; ?>

						<!-- Button -->
						<?php if ( ! empty( $settings['button_text'] ) ) : 
							$btn_url = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
							$btn_target = ! empty( $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
							$btn_nofollow = ! empty( $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
						?>
							<div class="ce-sticky-btn-wrap">
								<a href="<?php echo esc_url( $btn_url ); ?>" class="ce-sticky-btn"<?php echo $btn_target . $btn_nofollow; ?>>
									<?php if ( 'before' === $settings['button_icon_position'] && ! empty( $settings['button_icon']['value'] ) ) : ?>
										<span class="ce-sticky-btn-icon style-before">
											<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $settings['button_text'] ); ?></span>

									<?php if ( 'after' === $settings['button_icon_position'] && ! empty( $settings['button_icon']['value'] ) ) : ?>
										<span class="ce-sticky-btn-icon style-after">
											<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
								</a>
							</div>
						<?php endif; ?>

					</div>
				</div>

			</div>
		</div>

		<?php
	}
}
