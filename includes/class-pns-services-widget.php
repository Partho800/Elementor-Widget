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
use Elementor\Icons_Manager;
use Elementor\Utils;

/**
 * PNS Services Widget (Card Grid)
 *
 * Fully customizable feature card grid widget for Elementor.
 * Supports both Icon cards and Full Top Banner Image cards.
 */
class PNS_Services_Widget extends Widget_Base {

	public function get_name() {
		return 'pns_core_services';
	}

	public function get_title() {
		return esc_html__( 'Card Grid', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-apps';
	}

	public function get_categories() {
		return [ 'pns-addons-category' ];
	}

	public function get_keywords() {
		return [ 'services', 'card', 'grid', 'box', 'feature', 'icon box', 'image card', 'banner', 'pns' ];
	}

	public function get_style_depends() {
		return [ 'pns-blog-styles' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// 1. SECTION: HEADER & LAYOUT
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header & Layout', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label'        => esc_html__( 'Show Section Header', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'WHAT WE DO', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'Our Core <span class="elegant-serif">Services</span>', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'desc_text',
			[
				'label'       => esc_html__( 'Description Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Comprehensive systems and methodologies that build sustainable, zero-waste ecosystems for a greener tomorrow.', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'header_align',
			[
				'label'       => esc_html__( 'Header Alignment', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
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
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .sdg-header-split' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
					'{{WRAPPER}} .sdg-header-left'  => 'text-align: {{VALUE}};',
				],
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'header_bottom_spacing',
			[
				'label'      => esc_html__( 'Header Bottom Spacing', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .sdg-header-split' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_grid_layout',
			[
				'label'     => esc_html__( 'Grid Layout', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'pns-addons-for-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .wwd-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr) !important;',
				],
			]
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label'      => esc_html__( 'Columns Gap', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rows_gap',
			[
				'label'      => esc_html__( 'Rows Gap', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'      => esc_html__( 'Container Max Width', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min'  => 300,
						'max'  => 1920,
						'step' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1252,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-container' => 'max-width: {{SIZE}}{{UNIT}} !important; margin: 0 auto;',
				],
			]
		);

		$this->end_controls_section();

		// 2. SECTION: SERVICE CARDS (REPEATER)
		$this->start_controls_section(
			'section_services_items',
			[
				'label' => esc_html__( 'Service Cards', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'number',
			[
				'label'   => esc_html__( 'Step/Card Number', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '01',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Card Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Service Title', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label'   => esc_html__( 'Accent Color', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#3BB852',
			]
		);

		$repeater->add_control(
			'bg_color',
			[
				'label'   => esc_html__( 'Icon Background Color', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(59, 184, 82, 0.12)',
			]
		);

		$repeater->add_control(
			'icon_type',
			[
				'label'   => esc_html__( 'Media Type', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => esc_html__( 'Icon Library', 'pns-addons-for-elementor' ),
					'image' => esc_html__( 'Card Image (Top Banner)', 'pns-addons-for-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'elementor_icon',
			[
				'label'     => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-bullhorn',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label'     => esc_html__( 'Choose Card Image', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'item_image_height',
			[
				'label'      => esc_html__( 'Image Height (Override)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 600,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .wwd-image-wrap' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
				'condition'  => [
					'icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'   => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Empowering citizens with environmental knowledge and waste separation advocacy.', 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'link_text',
			[
				'label'   => esc_html__( 'Link Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'link_url',
			[
				'label'       => esc_html__( 'Link URL', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'services_list',
			[
				'label'       => esc_html__( 'Service Cards List', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'number'         => '01',
						'title'          => 'Awareness and Advocacy',
						'color'          => '#3BB852',
						'bg_color'       => 'rgba(59, 184, 82, 0.12)',
						'icon_type'      => 'icon',
						'elementor_icon' => [
							'value'   => 'fas fa-bullhorn',
							'library' => 'fa-solid',
						],
						'desc'           => 'Empowering citizens with environmental knowledge and waste separation advocacy.',
						'link_text'      => 'Learn More',
					],
					[
						'number'         => '02',
						'title'          => 'Capacity Building of ULBs & PRIs',
						'color'          => '#0d9488',
						'bg_color'       => 'rgba(13, 148, 136, 0.12)',
						'icon_type'      => 'icon',
						'elementor_icon' => [
							'value'   => 'fas fa-building',
							'library' => 'fa-solid',
						],
						'desc'           => 'Training municipalities and rural bodies for sustainable policy implementations.',
						'link_text'      => 'Learn More',
					],
					[
						'number'         => '03',
						'title'          => 'Setting Up End to End SWM',
						'color'          => '#d97706',
						'bg_color'       => 'rgba(217, 119, 6, 0.12)',
						'icon_type'      => 'icon',
						'elementor_icon' => [
							'value'   => 'fas fa-project-diagram',
							'library' => 'fa-solid',
						],
						'desc'           => 'Deploying complete, sustainable waste collection and processing systems.',
						'link_text'      => 'Learn More',
					],
				],
				'title_field' => '{{{ title }}} (Step {{{ number }}})',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// 1. SECTION: SECTION HEADER STYLE
		$this->start_controls_section(
			'section_style_header',
			[
				'label'     => esc_html__( 'Section Header Style', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		// Badge Style
		$this->add_control(
			'heading_badge_style',
			[
				'label' => esc_html__( 'Badge', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sdg-header-left .badge' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sdg-header-left .badge' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .sdg-header-left .badge',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Badge Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sdg-header-left .badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Badge Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sdg-header-left .badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'badge_margin_bottom',
			[
				'label'      => esc_html__( 'Badge Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .sdg-header-left .badge' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Title Style
		$this->add_control(
			'heading_title_style',
			[
				'label'     => esc_html__( 'Title', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sdg-header-left h2' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_title_typography',
				'selector' => '{{WRAPPER}} .sdg-header-left h2',
			]
		);

		$this->add_responsive_control(
			'header_title_margin_bottom',
			[
				'label'      => esc_html__( 'Title Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .sdg-header-left h2' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Description Style
		$this->add_control(
			'heading_desc_style',
			[
				'label'     => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'header_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sdg-header-left .sdg-header-desc' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_desc_typography',
				'selector' => '{{WRAPPER}} .sdg-header-left .sdg-header-desc',
			]
		);

		$this->end_controls_section();

		// 2. SECTION: CARD ITEM STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card Item Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_alignment',
			[
				'label'     => esc_html__( 'Text Alignment', 'pns-addons-for-elementor' ),
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
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .wwd-card' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'      => esc_html__( 'Card Height', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card' => 'height: {{SIZE}}{{UNIT}} !important; min-height: 0 !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_min_height',
			[
				'label'      => esc_html__( 'Card Min Height', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card' => 'min-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card:not(.wwd-has-image) .wwd-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .wwd-card:not(.wwd-has-image)'                 => 'padding: 0 !important;',
					'{{WRAPPER}} .wwd-card.wwd-has-image'                       => 'padding: 0 !important;',
					'{{WRAPPER}} .wwd-card.wwd-has-image .wwd-card-inner'       => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'enable_glow',
			[
				'label'        => esc_html__( 'Card Glow Effect', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Off', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'glow_color',
			[
				'label'     => esc_html__( 'Glow Accent Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'enable_glow' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card-glow' => 'background: radial-gradient(circle at 10% 10%, {{VALUE}}, transparent 60%) !important;',
				],
			]
		);

		// Card Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_card_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wwd-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .wwd-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .wwd-card',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'card_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_hover_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wwd-card:hover',
			]
		);

		$this->add_control(
			'card_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'selector' => '{{WRAPPER}} .wwd-card:hover',
			]
		);

		$this->add_responsive_control(
			'card_hover_translate_y',
			[
				'label'      => esc_html__( 'Hover Lift (Translate Y)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => -30,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}}) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 3. SECTION: CARD IMAGE STYLE (FULL / FLUSH BANNER)
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Card Image Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em' ],
				'range'      => [
					'px' => [
						'min'  => 50,
						'max'  => 800,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-image-wrap' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 1200,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-image-wrap' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'image_align',
			[
				'label'     => esc_html__( 'Image Alignment', 'pns-addons-for-elementor' ),
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
					'left'   => 'margin-left: 0 !important; margin-right: auto !important;',
					'center' => 'margin-left: auto !important; margin-right: auto !important;',
					'right'  => 'margin-left: auto !important; margin-right: 0 !important;',
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-image-wrap' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'image_object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'      => esc_html__( 'Cover (Crop to fill)', 'pns-addons-for-elementor' ),
					'contain'    => esc_html__( 'Contain (Fit inside)', 'pns-addons-for-elementor' ),
					'fill'       => esc_html__( 'Fill (Stretch)', 'pns-addons-for-elementor' ),
					'scale-down' => esc_html__( 'Scale Down', 'pns-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card-img' => 'object-fit: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wwd-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .wwd-card-img'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing_bottom',
			[
				'label'      => esc_html__( 'Spacing Below Image', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-image-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_image_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_image_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'   => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card-img' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_control(
			'image_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-image-overlay' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_image_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'image_hover_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-card-img' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_control(
			'image_hover_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-image-overlay' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'image_hover_scale',
			[
				'label'     => esc_html__( 'Hover Zoom Scale', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 1.5,
						'step' => 0.02,
					],
				],
				'default'   => [
					'size' => 1.06,
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-card-img' => 'transform: scale({{SIZE}}) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 4. SECTION: ICON STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon & Icon Box', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label'      => esc_html__( 'Icon Box Size', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 30,
						'max' => 180,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-icon' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Font / SVG Size', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 26,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-icon i'   => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .wwd-icon svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Icon Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '18',
					'right'  => '18',
					'bottom' => '18',
					'left'   => '18',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_row_spacing',
			[
				'label'      => esc_html__( 'Icon Row Bottom Spacing', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-icon-row' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Icon Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_icon_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-icon'     => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-icon i'   => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-icon svg' => 'fill: {{VALUE}} !important; color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => esc_html__( 'Icon Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-icon' => 'background: {{VALUE}} !important; background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .wwd-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} .wwd-icon',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-icon'     => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-card:hover .wwd-icon i'   => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-card:hover .wwd-icon svg' => 'fill: {{VALUE}} !important; color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'icon_hover_bg_color',
			[
				'label'     => esc_html__( 'Icon Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-icon' => 'background: {{VALUE}} !important; background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-icon' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_hover_box_shadow',
				'selector' => '{{WRAPPER}} .wwd-card:hover .wwd-icon',
			]
		);

		$this->add_control(
			'icon_hover_scale',
			[
				'label'     => esc_html__( 'Hover Scale', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.5,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-icon' => 'transform: scale({{SIZE}}) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 5. SECTION: STEP / NUMBER STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__( 'Step / Number Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_number',
			[
				'label'        => esc_html__( 'Show Number', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .wwd-number, {{WRAPPER}} .wwd-image-number',
			]
		);

		// Number Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_number_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_number_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-number'       => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-image-number' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'number_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-number'       => 'opacity: {{SIZE}} !important;',
					'{{WRAPPER}} .wwd-image-number' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_number_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'number_hover_color',
			[
				'label'     => esc_html__( 'Number Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-number'       => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-card:hover .wwd-image-number' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'number_hover_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-number'       => 'opacity: {{SIZE}} !important;',
					'{{WRAPPER}} .wwd-card:hover .wwd-image-number' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_control(
			'number_hover_scale',
			[
				'label'     => esc_html__( 'Hover Scale', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.5,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-number'       => 'transform: scale({{SIZE}}) !important;',
					'{{WRAPPER}} .wwd-card:hover .wwd-image-number' => 'transform: scale({{SIZE}}) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 6. SECTION: CARD TITLE STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Card Title Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'pns-addons-for-elementor' ),
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
					'p'    => 'p',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .wwd-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-title' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Title Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_title_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-title' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-title:hover'           => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 7. SECTION: CARD DESCRIPTION STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_desc',
			[
				'label' => esc_html__( 'Card Description Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_desc_typography',
				'selector' => '{{WRAPPER}} .wwd-desc',
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[
				'label'      => esc_html__( 'Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-desc' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		// Description Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_desc_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_desc_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-desc' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_desc_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'desc_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-desc' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// 8. SECTION: ACTION LINK / FOOTER STYLE (NORMAL & HOVER)
		$this->start_controls_section(
			'section_style_link',
			[
				'label' => esc_html__( 'Learn More Link & Footer', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Top Divider', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'show_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-card-footer' => 'border-top-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'divider_height',
			[
				'label'      => esc_html__( 'Divider Thickness', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1,
				],
				'condition'  => [
					'show_divider' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card-footer' => 'border-top-width: {{SIZE}}{{UNIT}} !important; border-top-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding_top',
			[
				'label'      => esc_html__( 'Footer Padding Top', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card-footer' => 'padding-top: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .wwd-explore',
			]
		);

		$this->add_responsive_control(
			'link_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Icon Size', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-explore svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'link_arrow_gap',
			[
				'label'      => esc_html__( 'Text & Arrow Gap', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-explore' => 'gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'show_underline',
			[
				'label'        => esc_html__( 'Hover Underline Bar', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'show_underline' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-explore::after' => 'background: {{VALUE}} !important;',
				],
			]
		);

		// Link Tabs: Normal & Hover
		$this->start_controls_tabs( 'tabs_link_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_link_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Link Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-explore' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'link_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-explore svg' => 'color: {{VALUE}} !important; stroke: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_link_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label'     => esc_html__( 'Link Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-explore' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-explore:hover'           => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'link_hover_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card:hover .wwd-explore svg' => 'color: {{VALUE}} !important; stroke: {{VALUE}} !important;',
					'{{WRAPPER}} .wwd-explore:hover svg'           => 'color: {{VALUE}} !important; stroke: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_hover_translate_x',
			[
				'label'      => esc_html__( 'Arrow Hover Slide', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors'  => [
					'{{WRAPPER}} .wwd-card:hover .wwd-explore svg' => 'transform: translateX({{SIZE}}{{UNIT}}) !important;',
					'{{WRAPPER}} .wwd-explore:hover svg'           => 'transform: translateX({{SIZE}}{{UNIT}}) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$title_tag      = ! empty( $settings['title_html_tag'] ) ? Utils::validate_html_tag( $settings['title_html_tag'] ) : 'h3';
		$show_number    = isset( $settings['show_number'] ) ? ( 'yes' === $settings['show_number'] ) : true;
		$show_divider   = isset( $settings['show_divider'] ) ? ( 'yes' === $settings['show_divider'] ) : true;
		$show_underline = isset( $settings['show_underline'] ) ? ( 'yes' === $settings['show_underline'] ) : true;
		$enable_glow    = isset( $settings['enable_glow'] ) ? ( 'yes' === $settings['enable_glow'] ) : true;
		?>
		<div class="blogs-page">
		  <section class="section what-we-do-section" style="padding: 0; background: transparent;">
			<div class="wwd-container">
			  <!-- Section Header -->
			  <?php if ( 'yes' === $settings['show_header'] ) : ?>
				  <div class="sdg-header-split">
					<div class="sdg-header-left">
					  <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<span class="badge badge-accent"><?php echo esc_html( $settings['badge_text'] ); ?></span>
					  <?php endif; ?>
					  
					  <?php if ( ! empty( $settings['title_text'] ) ) : ?>
						<h2 class="sdg-header-title"><?php echo wp_kses( $settings['title_text'], array( 'span' => array( 'class' => array() ), 'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array() ) ); ?></h2>
					  <?php endif; ?>

					  <?php if ( ! empty( $settings['desc_text'] ) ) : ?>
						<p class="sdg-header-desc">
						  <?php echo esc_html( $settings['desc_text'] ); ?>
						</p>
					  <?php endif; ?>
					</div>
				  </div>
			  <?php endif; ?>

			  <!-- Cards Grid -->
			  <div class="wwd-grid">
				  <?php 
				  if ( ! empty( $settings['services_list'] ) ) :
					foreach ( $settings['services_list'] as $i => $item ) :
					  $display_index = ! empty( $item['number'] ) ? $item['number'] : sprintf( '%02d', $i + 1 );
					  $color         = ! empty( $item['color'] ) ? $item['color'] : '#3BB852';
					  $bg_color      = ! empty( $item['bg_color'] ) ? $item['bg_color'] : 'rgba(59, 184, 82, 0.12)';
					  
					  $has_image      = ( 'image' === $item['icon_type'] );
					  $icon_image_url = '';
					  if ( $has_image ) {
						  if ( is_array( $item['icon_image'] ) && ! empty( $item['icon_image']['url'] ) ) {
							  $icon_image_url = $item['icon_image']['url'];
						  } elseif ( is_string( $item['icon_image'] ) ) {
							  $icon_image_url = $item['icon_image'];
						  }
					  }
					  $is_full_image = ( $has_image && ! empty( $icon_image_url ) );
					  $card_classes  = [ 'wwd-card', 'card', 'glass-panel' ];
					  if ( $is_full_image ) {
						  $card_classes[] = 'wwd-has-image';
					  }
				  ?>
					<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>" style="--ac: <?php echo esc_attr( $color ); ?>; --pns-item-icon-bg: <?php echo esc_attr( $bg_color ); ?>; --pns-item-icon-color: <?php echo esc_attr( $color ); ?>;">
					  <?php if ( $enable_glow ) : ?>
						<div class="wwd-card-glow"></div>
					  <?php endif; ?>

					  <?php if ( $is_full_image ) : ?>
						<!-- Top Flush Card Banner Image -->
						<div class="wwd-image-wrap">
						  <img src="<?php echo esc_url( $icon_image_url ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" class="wwd-card-img" />
						  <div class="wwd-image-overlay"></div>
						  <?php if ( $show_number ) : ?>
							<span class="wwd-number wwd-image-number"><?php echo esc_html( $display_index ); ?></span>
						  <?php endif; ?>
						</div>
					  <?php endif; ?>

					  <div class="wwd-card-inner">
						<?php if ( ! $is_full_image ) : ?>
						  <!-- Icon Row (For Standard Icon Cards) -->
						  <div class="wwd-icon-row">
							<div class="wwd-icon">
							  <?php if ( ! empty( $item['elementor_icon']['value'] ) ) : ?>
								<?php Icons_Manager::render_icon( $item['elementor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							  <?php endif; ?>
							</div>
							<?php if ( $show_number ) : ?>
							  <span class="wwd-number"><?php echo esc_html( $display_index ); ?></span>
							<?php endif; ?>
						  </div>
						<?php endif; ?>

						<!-- Card Title & Description -->
						<div class="wwd-card-content">
						  <<?php echo esc_attr( $title_tag ); ?> class="wwd-title"><?php echo esc_html( $item['title'] ); ?></<?php echo esc_attr( $title_tag ); ?>>
						  <p class="wwd-desc"><?php echo esc_html( $item['desc'] ); ?></p>
						</div>

						<!-- Action Link / Footer -->
						<?php if ( ! empty( $item['link_text'] ) ) : ?>
						  <?php 
						  $url = ! empty( $item['link_url']['url'] ) ? $item['link_url']['url'] : '#';
						  $footer_inline_style = ( ! $show_divider ) ? 'border-top: none !important;' : '';
						  ?>
						  <div class="wwd-card-footer"<?php if ( ! empty( $footer_inline_style ) ) : ?> style="<?php echo esc_attr( $footer_inline_style ); ?>"<?php endif; ?>>
							<a href="<?php echo esc_url( $url ); ?>" class="wwd-explore<?php echo ( ! $show_underline ) ? ' pns-no-underline' : ''; ?>"<?php if ( ! empty( $item['link_url']['is_external'] ) ) : ?> target="_blank"<?php endif; ?><?php if ( ! empty( $item['link_url']['nofollow'] ) ) : ?> rel="nofollow"<?php endif; ?>>
							  <span><?php echo esc_html( $item['link_text'] ); ?></span>
							  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
							</a>
						  </div>
						<?php endif; ?>
					  </div>
					</div>
				  <?php 
					endforeach;
				  endif; 
				  ?>
			  </div>
			</div>
		  </section>
		</div>
		<?php
	}
}
