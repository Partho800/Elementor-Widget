<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

class PNS_Pricing_Table_Widget extends Widget_Base {

	public function get_name() {
		return 'pns_pricing_table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_style_depends() {
		return [ 'pns-pricing-table-style' ];
	}

	public function get_script_depends() {
		return [ 'pns-pricing-table-script' ];
	}

	protected function register_controls() {

		// ==========================================
		// CONTENT: HEADER & BADGE
		// ==========================================
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Header & Badge', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'plan_title',
			[
				'label'       => esc_html__( 'Plan Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Professional', 'pns-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Standard, Pro, Enterprise', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'plan_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Description', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Ideal for growing teams, businesses and professional agencies.', 'pns-addons-for-elementor' ),
				'rows'        => 2,
				'label_block' => true,
			]
		);

		$this->add_control(
			'is_featured',
			[
				'label'        => esc_html__( 'Highlight as Featured', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'        => esc_html__( 'Show Badge / Ribbon', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Most Popular', 'pns-addons-for-elementor' ),
				'condition'   => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_style',
			[
				'label'       => esc_html__( 'Badge Style', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'pill'   => esc_html__( 'Floating Pill', 'pns-addons-for-elementor' ),
					'ribbon' => esc_html__( 'Corner Ribbon', 'pns-addons-for-elementor' ),
				],
				'default'     => 'pill',
				'condition'   => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT: PRICING & SWITCHER
		// ==========================================
		$this->start_controls_section(
			'section_pricing',
			[
				'label' => esc_html__( 'Pricing & Switcher', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'   => esc_html__( 'Currency Symbol', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
			]
		);

		$this->add_control(
			'currency_position',
			[
				'label'   => esc_html__( 'Currency Position', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'before' => esc_html__( 'Before (e.g. $49)', 'pns-addons-for-elementor' ),
					'after'  => esc_html__( 'After (e.g. 49$)', 'pns-addons-for-elementor' ),
				],
				'default' => 'before',
			]
		);

		$this->add_control(
			'price_monthly',
			[
				'label'   => esc_html__( 'Monthly Price', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '49',
			]
		);

		$this->add_control(
			'price_monthly_original',
			[
				'label'       => esc_html__( 'Original Price (Strikethrough)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '79',
				'placeholder' => esc_html__( 'Leave empty to hide', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'period_monthly',
			[
				'label'   => esc_html__( 'Monthly Period Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/month', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'enable_switcher',
			[
				'label'        => esc_html__( 'Enable Monthly/Yearly Switcher', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'switcher_monthly_label',
			[
				'label'     => esc_html__( 'Switcher Monthly Label', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Monthly', 'pns-addons-for-elementor' ),
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'switcher_yearly_label',
			[
				'label'     => esc_html__( 'Switcher Yearly Label', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Yearly', 'pns-addons-for-elementor' ),
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'switcher_discount_badge',
			[
				'label'     => esc_html__( 'Yearly Discount Badge', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Save 25%', 'pns-addons-for-elementor' ),
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'price_yearly',
			[
				'label'     => esc_html__( 'Yearly Price (per month/year)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '39',
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'price_yearly_original',
			[
				'label'     => esc_html__( 'Yearly Original Price', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '59',
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'period_yearly',
			[
				'label'     => esc_html__( 'Yearly Period Text', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '/mo (billed annually)', 'pns-addons-for-elementor' ),
				'condition' => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT: FEATURES LIST
		// ==========================================
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Features List', 'pns-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'feature_text',
			[
				'label'       => esc_html__( 'Feature Description', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Full Feature Access', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'feature_status',
			[
				'label'   => esc_html__( 'Status', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'included' => esc_html__( 'Included (✓)', 'pns-addons-for-elementor' ),
					'excluded' => esc_html__( 'Excluded (✗)', 'pns-addons-for-elementor' ),
				],
				'default' => 'included',
			]
		);

		$repeater->add_control(
			'feature_icon',
			[
				'label'       => esc_html__( 'Custom Icon', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'recommended' => [
					'fa-solid' => [ 'check', 'check-circle', 'times', 'times-circle', 'star' ],
				],
			]
		);

		$repeater->add_control(
			'feature_tooltip',
			[
				'label'       => esc_html__( 'Tooltip Note (Optional)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Help note shown on hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'features_list',
			[
				'label'       => esc_html__( 'Feature Items', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ feature_text }}}',
				'default'     => [
					[
						'feature_text'   => esc_html__( 'Unlimited Active Projects', 'pns-addons-for-elementor' ),
						'feature_status' => 'included',
					],
					[
						'feature_text'   => esc_html__( 'All 20+ Premium Widgets Access', 'pns-addons-for-elementor' ),
						'feature_status' => 'included',
					],
					[
						'feature_text'   => esc_html__( 'Priority 24/7 VIP Support', 'pns-addons-for-elementor' ),
						'feature_status' => 'included',
					],
					[
						'feature_text'   => esc_html__( 'Regular Updates & Performance Fixes', 'pns-addons-for-elementor' ),
						'feature_status' => 'included',
					],
					[
						'feature_text'   => esc_html__( 'Custom White-Label Branding', 'pns-addons-for-elementor' ),
						'feature_status' => 'excluded',
					],
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT: CALL TO ACTION (CTA)
		// ==========================================
		$this->start_controls_section(
			'section_cta',
			[
				'label' => esc_html__( 'Action Button & Footnote', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose Plan', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link (Monthly)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_yearly_link',
			[
				'label'       => esc_html__( 'Button Link (Yearly)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com?plan=yearly',
				'condition'   => [
					'enable_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'pns-addons-for-elementor' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'left'  => esc_html__( 'Before Text', 'pns-addons-for-elementor' ),
					'right' => esc_html__( 'After Text', 'pns-addons-for-elementor' ),
				],
				'default'   => 'right',
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'footnote_text',
			[
				'label'       => esc_html__( 'Footnote / Microcopy', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '14-day money-back guarantee • Cancel anytime', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: CARD CONTAINER
		// ==========================================
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card Container', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-table-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'label'    => esc_html__( 'Border', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .pns-pricing-table-card',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-table-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'pns-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .pns-pricing-table-card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-table-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'featured_border_color',
			[
				'label'     => esc_html__( 'Featured Card Border Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-table-card.pns-is-featured' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: HEADER & BADGE
		// ==========================================
		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Header & Badge', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-title',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-subtitle' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-subtitle',
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-ribbon' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-ribbon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: PRICING & SWITCHER
		// ==========================================
		$this->start_controls_section(
			'section_style_pricing',
			[
				'label' => esc_html__( 'Pricing & Switcher', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'amount_color',
			[
				'label'     => esc_html__( 'Price Amount Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'amount_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-amount',
			]
		);

		$this->add_control(
			'currency_color',
			[
				'label'     => esc_html__( 'Currency Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-currency' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'original_price_color',
			[
				'label'     => esc_html__( 'Original Price Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-original-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label'     => esc_html__( 'Period Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'switcher_bg_color',
			[
				'label'     => esc_html__( 'Switcher Container Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switcher' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'switcher_active_pill_bg',
			[
				'label'     => esc_html__( 'Active Option Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switcher-option.is-active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: FEATURES LIST
		// ==========================================
		$this->start_controls_section(
			'section_style_features',
			[
				'label' => esc_html__( 'Features List', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_item_spacing',
			[
				'label'      => esc_html__( 'Item Spacing', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 4,
						'max' => 40,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-features-list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'included_icon_color',
			[
				'label'     => esc_html__( 'Included Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-feature-icon.is-included' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'excluded_icon_color',
			[
				'label'     => esc_html__( 'Excluded Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-feature-icon.is-excluded' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-feature-item' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_text_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-feature-item',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: CALL TO ACTION (BUTTON)
		// ==========================================
		$this->start_controls_section(
			'section_style_cta',
			[
				'label' => esc_html__( 'Action Button', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-button',
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
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-button' => 'color: {{VALUE}};',
				],
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
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'footnote_color',
			[
				'label'     => esc_html__( 'Footnote Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-footnote' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$card_classes = [ 'pns-pricing-table-card' ];
		if ( 'yes' === $settings['is_featured'] ) {
			$card_classes[] = 'pns-is-featured';
		}

		$currency_symbol   = ! empty( $settings['currency_symbol'] ) ? $settings['currency_symbol'] : '';
		$currency_position = $settings['currency_position'];
		$enable_switcher   = 'yes' === $settings['enable_switcher'];

		// Monthly values
		$price_monthly          = $settings['price_monthly'];
		$price_monthly_original = $settings['price_monthly_original'];
		$period_monthly         = $settings['period_monthly'];

		// Yearly values
		$price_yearly          = ! empty( $settings['price_yearly'] ) ? $settings['price_yearly'] : $price_monthly;
		$price_yearly_original = ! empty( $settings['price_yearly_original'] ) ? $settings['price_yearly_original'] : '';
		$period_yearly         = ! empty( $settings['period_yearly'] ) ? $settings['period_yearly'] : $period_monthly;

		$button_monthly_url = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
		$button_yearly_url  = ! empty( $settings['button_yearly_link']['url'] ) ? $settings['button_yearly_link']['url'] : $button_monthly_url;
		?>
		<div class="pns-pricing-table-wrapper">
			<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

				<?php if ( 'yes' === $settings['show_badge'] && ! empty( $settings['badge_text'] ) ) : ?>
					<?php if ( 'ribbon' === $settings['badge_style'] ) : ?>
						<div class="pns-pricing-badge-ribbon"><?php echo esc_html( $settings['badge_text'] ); ?></div>
					<?php else : ?>
						<span class="pns-pricing-badge-pill"><?php echo esc_html( $settings['badge_text'] ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<div class="pns-pricing-header">
					<?php if ( ! empty( $settings['plan_title'] ) ) : ?>
						<h3 class="pns-pricing-title"><?php echo esc_html( $settings['plan_title'] ); ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $settings['plan_subtitle'] ) ) : ?>
						<p class="pns-pricing-subtitle"><?php echo esc_html( $settings['plan_subtitle'] ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $enable_switcher ) : ?>
					<div class="pns-pricing-switcher" role="group" aria-label="<?php esc_attr_e( 'Billing Cycle Switcher', 'pns-addons-for-elementor' ); ?>">
						<div class="pns-pricing-switcher-option is-active" data-period="monthly">
							<?php echo esc_html( $settings['switcher_monthly_label'] ); ?>
						</div>
						<div class="pns-pricing-switcher-option" data-period="yearly">
							<?php echo esc_html( $settings['switcher_yearly_label'] ); ?>
							<?php if ( ! empty( $settings['switcher_discount_badge'] ) ) : ?>
								<span class="pns-pricing-switcher-discount"><?php echo esc_html( $settings['switcher_discount_badge'] ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="pns-pricing-price-wrap">
					<?php if ( ! empty( $price_monthly_original ) ) : ?>
						<span class="pns-pricing-original-price" 
							data-monthly-original="<?php echo esc_attr( $currency_position === 'before' ? $currency_symbol . $price_monthly_original : $price_monthly_original . $currency_symbol ); ?>"
							data-yearly-original="<?php echo esc_attr( $currency_position === 'before' ? $currency_symbol . $price_yearly_original : $price_yearly_original . $currency_symbol ); ?>">
							<?php echo esc_html( $currency_position === 'before' ? $currency_symbol . $price_monthly_original : $price_monthly_original . $currency_symbol ); ?>
						</span>
					<?php endif; ?>

					<?php if ( 'before' === $currency_position && ! empty( $currency_symbol ) ) : ?>
						<span class="pns-pricing-currency"><?php echo esc_html( $currency_symbol ); ?></span>
					<?php endif; ?>

					<span class="pns-pricing-amount" 
						data-monthly-price="<?php echo esc_attr( $price_monthly ); ?>" 
						data-yearly-price="<?php echo esc_attr( $price_yearly ); ?>">
						<?php echo esc_html( $price_monthly ); ?>
					</span>

					<?php if ( 'after' === $currency_position && ! empty( $currency_symbol ) ) : ?>
						<span class="pns-pricing-currency"><?php echo esc_html( $currency_symbol ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $period_monthly ) ) : ?>
						<span class="pns-pricing-period"
							data-monthly-period="<?php echo esc_attr( $period_monthly ); ?>"
							data-yearly-period="<?php echo esc_attr( $period_yearly ); ?>">
							<?php echo esc_html( $period_monthly ); ?>
						</span>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $settings['features_list'] ) ) : ?>
					<ul class="pns-pricing-features-list">
						<?php foreach ( $settings['features_list'] as $item ) : ?>
							<?php
							$is_included  = ( 'included' === $item['feature_status'] );
							$status_class = $is_included ? 'is-included' : 'is-excluded';
							?>
							<li class="pns-pricing-feature-item <?php echo esc_attr( $status_class ); ?>">
								<span class="pns-pricing-feature-icon <?php echo esc_attr( $status_class ); ?>">
									<?php
									if ( ! empty( $item['feature_icon']['value'] ) ) {
										Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] );
									} else {
										// Default fallback icon
										if ( $is_included ) {
											echo '<i class="fas fa-check-circle" aria-hidden="true"></i>';
										} else {
											echo '<i class="fas fa-times-circle" aria-hidden="true"></i>';
										}
									}
									?>
								</span>
								<span class="pns-pricing-feature-text"><?php echo esc_html( $item['feature_text'] ); ?></span>

								<?php if ( ! empty( $item['feature_tooltip'] ) ) : ?>
									<span class="pns-pricing-feature-tooltip" data-tooltip="<?php echo esc_attr( $item['feature_tooltip'] ); ?>" aria-label="<?php echo esc_attr( $item['feature_tooltip'] ); ?>">
										<i class="fas fa-info-circle" aria-hidden="true"></i>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="pns-pricing-cta-wrap">
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<?php
						$this->add_link_attributes( 'button', $settings['button_link'] );
						$this->add_render_attribute( 'button', 'class', 'pns-pricing-button' );
						$this->add_render_attribute( 'button', 'data-monthly-link', esc_url( $button_monthly_url ) );
						$this->add_render_attribute( 'button', 'data-yearly-link', esc_url( $button_yearly_url ) );
						?>
						<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
							<?php if ( ! empty( $settings['button_icon']['value'] ) && 'left' === $settings['button_icon_align'] ) : ?>
								<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>

							<span><?php echo esc_html( $settings['button_text'] ); ?></span>

							<?php if ( ! empty( $settings['button_icon']['value'] ) && 'right' === $settings['button_icon_align'] ) : ?>
								<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $settings['footnote_text'] ) ) : ?>
						<span class="pns-pricing-footnote"><?php echo esc_html( $settings['footnote_text'] ); ?></span>
					<?php endif; ?>
				</div>

			</div>
		</div>
		<?php
	}
}
