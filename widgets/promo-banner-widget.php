<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

class Custom_Promo_Banner_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_promo_banner_widget';
	}

	public function get_title() {
		return esc_html__( 'Promo Banner Card', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_style_depends() {
		return [ 'custom-promo-banner-style' ];
	}

	protected function register_controls() {

		// ==========================================
		// CONTENT TAB: BANNER SETTINGS
		// ==========================================
		$this->start_controls_section(
			'section_banner_content',
			[
				'label' => esc_html__( 'Banner Settings', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'banner_image',
			[
				'label'   => esc_html__( 'Background Image', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'banner_title_line_1',
			[
				'label'   => esc_html__( 'Title Line 1 (Before button)', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Switch', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'banner_title_line_2',
			[
				'label'   => esc_html__( 'Title Line 2', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'to Solar, Save', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'banner_title_line_3',
			[
				'label'   => esc_html__( 'Title Line 3', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'the Planet Today!', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'show_dashed_pattern',
			[
				'label'        => esc_html__( 'Show Radiating Dashed Accent', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT TAB: INLINE BUTTON SETTINGS
		// ==========================================
		$this->start_controls_section(
			'section_pill_content',
			[
				'label' => esc_html__( 'Inline Pill Button', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'pill_text',
			[
				'label'   => esc_html__( 'Button Text', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact Us', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'pill_link',
			[
				'label'       => esc_html__( 'Link URL', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'custom-elementor-widgets' ),
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'show_pill_dot',
			[
				'label'        => esc_html__( 'Show White Toggle Dot', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT TAB: FLOATING CARD SETTINGS
		// ==========================================
		$this->start_controls_section(
			'section_card_content',
			[
				'label' => esc_html__( 'Floating Contact Card', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'show_floating_card',
			[
				'label'        => esc_html__( 'Show Floating Card', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Specialist Avatars Repeater
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'avatar_image',
			[
				'label'   => esc_html__( 'Avatar Image', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'avatar_list',
			[
				'label'       => esc_html__( 'Specialist Avatars', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'avatar_image' => [ 'url' => Utils::get_placeholder_image_src() ] ],
					[ 'avatar_image' => [ 'url' => Utils::get_placeholder_image_src() ] ],
					[ 'avatar_image' => [ 'url' => Utils::get_placeholder_image_src() ] ],
				],
				'title_field' => 'Avatar Image',
				'condition'   => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'specialist_label',
			[
				'label'     => esc_html__( 'Specialist Title', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Energy', 'custom-elementor-widgets' ),
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'specialist_badge',
			[
				'label'     => esc_html__( 'Badge Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '20+', 'custom-elementor-widgets' ),
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'specialist_sublabel',
			[
				'label'     => esc_html__( 'Specialist Subtitle', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Specialist', 'custom-elementor-widgets' ),
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'card_description',
			[
				'label'     => esc_html__( 'Card Subtitle/Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => esc_html__( 'Get in touch for sustainable energy today.', 'custom-elementor-widgets' ),
				'rows'      => 3,
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'card_phone_text',
			[
				'label'     => esc_html__( 'Footer Call Link/Phone Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '123 456 7890', 'custom-elementor-widgets' ),
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'card_phone_link',
			[
				'label'       => esc_html__( 'Footer Call Link URL', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'tel:1234567890', 'custom-elementor-widgets' ),
				'default'     => [
					'url'         => 'tel:1234567890',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'   => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'card_arrow_link',
			[
				'label'       => esc_html__( 'Footer Circle Button Link URL', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'custom-elementor-widgets' ),
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'   => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: BANNER STYLES
		// ==========================================
		$this->start_controls_section(
			'section_banner_style',
			[
				'label' => esc_html__( 'Banner Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'banner_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.75)',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-overlay' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ce-promo-title',
			]
		);

		$this->add_responsive_control(
			'title_max_width',
			[
				'label'      => esc_html__( 'Title Max Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 1000 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-title' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Banner Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top' => '60', 'right' => '60', 'bottom' => '60', 'left' => '60', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'banner_border_radius',
			[
				'label'      => esc_html__( 'Banner Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dashed_pattern_color',
			[
				'label'     => esc_html__( 'Dashed Accent Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-radial-pattern' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ce-promo-radial-pattern::before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ce-promo-radial-pattern::after' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 'show_dashed_pattern' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: INLINE PILL BUTTON STYLES
		// ==========================================
		$this->start_controls_section(
			'section_pill_style',
			[
				'label' => esc_html__( 'Inline Pill Button Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_pill_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_pill_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'pill_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#22c55e',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-inline-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-inline-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_dot_color',
			[
				'label'     => esc_html__( 'White Dot Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-btn-dot' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_pill_dot' => 'yes' ],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_pill_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'pill_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#16a34a',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-inline-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_text_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-inline-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_dot_hover_color',
			[
				'label'     => esc_html__( 'White Dot Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-inline-btn:hover .ce-promo-btn-dot' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_pill_dot' => 'yes' ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pill_typography',
				'selector'  => '{{WRAPPER}} .ce-promo-inline-btn',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'pill_padding',
			[
				'label'      => esc_html__( 'Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '8', 'right' => '10', 'bottom' => '8', 'left' => '18', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-inline-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pill_margin',
			[
				'label'      => esc_html__( 'Margins', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => '0', 'right' => '8', 'bottom' => '0', 'left' => '8', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-inline-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pill_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '30', 'right' => '30', 'bottom' => '30', 'left' => '30', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-inline-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: FLOATING CARD STYLES
		// ==========================================
		$this->start_controls_section(
			'section_card_style',
			[
				'label'     => esc_html__( 'Floating Card Style', 'custom-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_floating_card' => 'yes' ],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Card Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_width',
			[
				'label'      => esc_html__( 'Card Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 600 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 320 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-card' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_min_height',
			[
				'label'      => esc_html__( 'Card Min Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 800 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-card' => 'min-height: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .ce-promo-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top' => '30', 'right' => '30', 'bottom' => '30', 'left' => '30', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-promo-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .ce-promo-card',
			]
		);

		// Avatars Stack Border
		$this->add_control(
			'avatar_border_color',
			[
				'label'     => esc_html__( 'Avatar Border Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-avatar-img' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		// Specialist Text Style
		$this->add_control(
			'heading_specialist_text_style',
			[
				'label'     => esc_html__( 'Specialist Name', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'specialist_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-specialist-top' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'specialist_typography',
				'selector' => '{{WRAPPER}} .ce-promo-specialist-top',
			]
		);

		// Badge styles
		$this->add_control(
			'heading_badge_style',
			[
				'label'     => esc_html__( 'Badge Style', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#22c55e',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-badge' => 'color: {{VALUE}};',
				],
			]
		);

		// Sublabel Style
		$this->add_control(
			'sublabel_color',
			[
				'label'     => esc_html__( 'Specialist Subtitle Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-specialist-sub' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sublabel_typography',
				'selector' => '{{WRAPPER}} .ce-promo-specialist-sub',
			]
		);

		// Card Description Style
		$this->add_control(
			'heading_desc_style',
			[
				'label'     => esc_html__( 'Card Subtitle/Description Style', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-card-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .ce-promo-card-desc',
			]
		);

		// Call link styles
		$this->add_control(
			'heading_phone_style',
			[
				'label'     => esc_html__( 'Call Link Style', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_phone_style' );

		// Phone Normal Tab
		$this->start_controls_tab(
			'tab_phone_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'phone_color',
			[
				'label'     => esc_html__( 'Link Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-phone-link' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Phone Hover Tab
		$this->start_controls_tab(
			'tab_phone_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'phone_hover_color',
			[
				'label'     => esc_html__( 'Link Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-phone-link:hover' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'phone_typography',
				'selector'  => '{{WRAPPER}} .ce-promo-phone-link',
				'separator' => 'before',
			]
		);

		// Arrow button styles
		$this->add_control(
			'heading_arrow_btn_style',
			[
				'label'     => esc_html__( 'Arrow Button Style', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_arrow_btn_style' );

		// Arrow Normal Tab
		$this->start_controls_tab(
			'tab_arrow_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'arrow_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-arrow-btn' => 'background-color: {{VALUE}}; box-shadow: 0 4px 12px {{VALUE}}4d;',
				],
			]
		);

		$this->add_control(
			'arrow_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-arrow-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Arrow Hover Tab
		$this->start_controls_tab(
			'tab_arrow_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'arrow_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e04b00',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-arrow-btn:hover' => 'background-color: {{VALUE}}; box-shadow: 0 6px 16px {{VALUE}}66;',
				],
			]
		);

		$this->add_control(
			'arrow_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-promo-arrow-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Build Inline Button HTML
		$button_html = '';
		if ( ! empty( $settings['pill_text'] ) ) {
			$btn_url = ! empty( $settings['pill_link']['url'] ) ? $settings['pill_link']['url'] : '#';
			$btn_is_external = ! empty( $settings['pill_link']['is_external'] ) ? ' target="_blank"' : '';
			$btn_nofollow = ! empty( $settings['pill_link']['nofollow'] ) ? ' rel="nofollow"' : '';
			
			$button_html = '<a href="' . esc_url( $btn_url ) . '" class="ce-promo-inline-btn"' . $btn_is_external . $btn_nofollow . '>';
			$button_html .= esc_html( $settings['pill_text'] );
			if ( 'yes' === $settings['show_pill_dot'] ) {
				$button_html .= '<span class="ce-promo-btn-dot"></span>';
			}
			$button_html .= '</a>';
		}

		// Assemble title HTML: Line 1 + Button + Break + Line 2 + Break + Line 3
		$title_line_1 = ! empty( $settings['banner_title_line_1'] ) ? $settings['banner_title_line_1'] : '';
		$title_line_2 = ! empty( $settings['banner_title_line_2'] ) ? $settings['banner_title_line_2'] : '';
		$title_line_3 = ! empty( $settings['banner_title_line_3'] ) ? $settings['banner_title_line_3'] : '';

		$title_html = '';
		if ( ! empty( $title_line_1 ) ) {
			$title_html .= $title_line_1;
		}
		if ( ! empty( $button_html ) ) {
			$title_html .= ' ' . $button_html;
		}
		if ( ! empty( $title_line_2 ) ) {
			$title_html .= '<br>' . $title_line_2;
		}
		if ( ! empty( $title_line_3 ) ) {
			$title_html .= '<br>' . $title_line_3;
		}

		// Banner background image
		$banner_bg = '';
		if ( ! empty( $settings['banner_image']['url'] ) ) {
			$banner_bg = ' style="background-image: url(' . esc_url( $settings['banner_image']['url'] ) . ');"';
		}
		?>

		<div class="ce-promo-banner-wrap">
			<div class="ce-promo-banner"<?php echo $banner_bg; ?>>
				<div class="ce-promo-overlay"></div>
				
				<?php if ( 'yes' === $settings['show_dashed_pattern'] ) : ?>
					<div class="ce-promo-radial-pattern"></div>
				<?php endif; ?>

				<!-- Left Side: Title & Inline CTA Button -->
				<div class="ce-promo-left">
					<h2 class="ce-promo-title">
						<?php echo wp_kses( $title_html, [
							'a'    => [
								'href'   => [],
								'class'  => [],
								'target' => [],
								'rel'    => [],
							],
							'span' => [
								'class'  => [],
							],
							'br'   => [],
						] ); ?>
					</h2>
				</div>

				<!-- Right Side: Floating Contact Card -->
				<?php if ( 'yes' === $settings['show_floating_card'] ) : ?>
					<div class="ce-promo-right">
						<div class="ce-promo-card">
							
							<!-- Specialist Header Info -->
							<div class="ce-promo-card-header">
								
								<!-- Overlapping Avatars -->
								<?php if ( ! empty( $settings['avatar_list'] ) ) : ?>
									<div class="ce-promo-avatars">
										<?php foreach ( $settings['avatar_list'] as $avatar ) : ?>
											<?php if ( ! empty( $avatar['avatar_image']['url'] ) ) : ?>
												<img src="<?php echo esc_url( $avatar['avatar_image']['url'] ); ?>" class="ce-promo-avatar-img" alt="<?php echo esc_attr__( 'Avatar', 'custom-elementor-widgets' ); ?>">
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<!-- Specialist Text & Badge -->
								<div class="ce-promo-specialist-info">
									<div class="ce-promo-specialist-top">
										<?php echo esc_html( $settings['specialist_label'] ); ?>
										<?php if ( ! empty( $settings['specialist_badge'] ) ) : ?>
											<span class="ce-promo-badge"><?php echo esc_html( $settings['specialist_badge'] ); ?></span>
										<?php endif; ?>
									</div>
									<div class="ce-promo-specialist-sub">
										<?php echo esc_html( $settings['specialist_sublabel'] ); ?>
									</div>
								</div>

							</div>

							<!-- Card Subtitle/Description -->
							<?php if ( ! empty( $settings['card_description'] ) ) : ?>
								<p class="ce-promo-card-desc">
									<?php echo esc_html( $settings['card_description'] ); ?>
								</p>
							<?php endif; ?>

							<!-- Card Footer: Call & Button -->
							<div class="ce-promo-card-footer">
								<?php if ( ! empty( $settings['card_phone_text'] ) ) : 
									$phone_url = ! empty( $settings['card_phone_link']['url'] ) ? $settings['card_phone_link']['url'] : '#';
									$phone_external = ! empty( $settings['card_phone_link']['is_external'] ) ? ' target="_blank"' : '';
									$phone_nofollow = ! empty( $settings['card_phone_link']['nofollow'] ) ? ' rel="nofollow"' : '';
									?>
									<a href="<?php echo esc_url( $phone_url ); ?>" class="ce-promo-phone-link"<?php echo $phone_external . $phone_nofollow; ?>>
										<?php echo esc_html( $settings['card_phone_text'] ); ?>
									</a>
								<?php endif; ?>

								<?php 
								$arrow_url = ! empty( $settings['card_arrow_link']['url'] ) ? $settings['card_arrow_link']['url'] : '#';
								$arrow_external = ! empty( $settings['card_arrow_link']['is_external'] ) ? ' target="_blank"' : '';
								$arrow_nofollow = ! empty( $settings['card_arrow_link']['nofollow'] ) ? ' rel="nofollow"' : '';
								?>
								<a href="<?php echo esc_url( $arrow_url ); ?>" class="ce-promo-arrow-btn"<?php echo $arrow_external . $arrow_nofollow; ?>>
									&#x2197;
								</a>
							</div>

						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<?php
	}
}
