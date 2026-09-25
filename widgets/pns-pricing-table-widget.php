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
 * PNS Pricing Table Widget for Elementor
 *
 * Full-control pricing table widget with live monthly/yearly billing switch,
 * multi-plan grid or single-card mode, responsive layouts, badges, and complete styling.
 */
class PNS_Pricing_Table_Widget extends Widget_Base {

	/**
	 * Widget Name
	 */
	public function get_name() {
		return 'pns_pricing_table_widget';
	}

	/**
	 * Widget Title
	 */
	public function get_title() {
		return esc_html__( 'PNS Pricing Table', 'pns-addons-for-elementor' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'eicon-price-table';
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
		return [ 'pns-pricing-table-style' ];
	}

	/**
	 * Script dependencies
	 */
	public function get_script_depends() {
		return [ 'pns-pricing-table-script' ];
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
				'label' => esc_html__( 'Layout & Mode', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_mode',
			[
				'label'   => esc_html__( 'Layout Mode', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'   => esc_html__( 'Multi-Plan Grid (All-in-One)', 'pns-addons-for-elementor' ),
					'single' => esc_html__( 'Single Card (For Columns)', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label'           => esc_html__( 'Columns', 'pns-addons-for-elementor' ),
				'type'            => Controls_Manager::SELECT,
				'default'         => '3',
				'tablet_default'  => '2',
				'mobile_default'  => '1',
				'options'         => [
					'1' => esc_html__( '1 Column', 'pns-addons-for-elementor' ),
					'2' => esc_html__( '2 Columns', 'pns-addons-for-elementor' ),
					'3' => esc_html__( '3 Columns', 'pns-addons-for-elementor' ),
					'4' => esc_html__( '4 Columns', 'pns-addons-for-elementor' ),
				],
				'condition'       => [
					'layout_mode' => 'grid',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'        => esc_html__( 'Content Alignment', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
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
				'default'      => 'center',
				'prefix_class' => 'pns-align%s-',
				'selectors'    => [
					'{{WRAPPER}} .pns-pricing-header'      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-box'         => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-action'      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-footer'      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-footer-note' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'equal_height',
			[
				'label'        => esc_html__( 'Equal Height Cards', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'layout_mode' => 'grid',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 2. CONTENT TAB: BILLING SWITCHER
		// ==========================================
		$this->start_controls_section(
			'section_billing_switcher',
			[
				'label' => esc_html__( 'Billing Switcher (Monthly / Yearly)', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_switcher',
			[
				'label'        => esc_html__( 'Enable Switcher', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'period_1_label',
			[
				'label'     => esc_html__( 'Period 1 Label', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Monthly', 'pns-addons-for-elementor' ),
				'condition' => [
					'show_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'period_2_label',
			[
				'label'     => esc_html__( 'Period 2 Label', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Yearly', 'pns-addons-for-elementor' ),
				'condition' => [
					'show_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'default_period',
			[
				'label'     => esc_html__( 'Default Active Period', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => esc_html__( 'Period 1 (e.g. Monthly)', 'pns-addons-for-elementor' ),
					'2' => esc_html__( 'Period 2 (e.g. Yearly)', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'show_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'discount_badge_text',
			[
				'label'       => esc_html__( 'Discount Badge Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Save 20%', 'pns-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Save 25%', 'pns-addons-for-elementor' ),
				'condition'   => [
					'show_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'sync_group_id',
			[
				'label'       => esc_html__( 'Sync Group ID', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If using single cards in separate columns, enter the same ID (e.g., "my-pricing") across cards to sync their monthly/yearly toggle.', 'pns-addons-for-elementor' ),
				'condition'   => [
					'layout_mode' => 'single',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 3. CONTENT TAB: GRID PLANS (For Grid Mode)
		// ==========================================
		$this->start_controls_section(
			'section_grid_plans',
			[
				'label'     => esc_html__( 'Pricing Plans', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_mode' => 'grid',
				],
			]
		);

		$plan_repeater = new Repeater();

		$plan_repeater->add_control(
			'plan_title',
			[
				'label'       => esc_html__( 'Plan Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Standard Plan', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$plan_repeater->add_control(
			'plan_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Tagline', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ideal for growing businesses and teams', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$plan_repeater->add_control(
			'plan_icon',
			[
				'label'       => esc_html__( 'Plan Icon', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$plan_repeater->add_control(
			'is_featured',
			[
				'label'        => esc_html__( 'Featured / Highlighted Plan', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$plan_repeater->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Featured Badge Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Most Popular', 'pns-addons-for-elementor' ),
				'condition'   => [
					'is_featured' => 'yes',
				],
			]
		);

		$plan_repeater->add_control(
			'badge_style',
			[
				'label'     => esc_html__( 'Badge Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'pill',
				'options'   => [
					'pill'   => esc_html__( 'Floating Pill', 'pns-addons-for-elementor' ),
					'ribbon' => esc_html__( 'Corner Ribbon', 'pns-addons-for-elementor' ),
					'flag'   => esc_html__( 'Top Flag', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'is_featured' => 'yes',
				],
			]
		);

		$plan_repeater->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-ribbon-corner, {{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-badge-pill, {{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-badge-flag' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'is_featured' => 'yes',
				],
			]
		);

		$plan_repeater->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-ribbon-corner, {{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-badge-pill, {{WRAPPER}} {{CURRENT_ITEM}} .pns-pricing-badge-flag' => 'background-color: {{VALUE}} !important; background-image: none !important;',
				],
				'condition' => [
					'is_featured' => 'yes',
				],
			]
		);

		$plan_repeater->add_control(
			'price_prefix',
			[
				'label'       => esc_html__( 'Price Prefix (e.g. Price: )', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Price: ',
				'placeholder' => 'Price: ',
			]
		);

		$plan_repeater->add_control(
			'currency',
			[
				'label'   => esc_html__( 'Currency Symbol', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
			]
		);

		$plan_repeater->add_control(
			'period_1_price',
			[
				'label'   => esc_html__( 'Period 1 Price (Monthly)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '29',
			]
		);

		$plan_repeater->add_control(
			'period_1_original_price',
			[
				'label'       => esc_html__( 'Period 1 Original Price (Strikethrough)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '39',
				'placeholder' => esc_html__( 'Optional strikethrough price', 'pns-addons-for-elementor' ),
			]
		);

		$plan_repeater->add_control(
			'period_1_duration',
			[
				'label'   => esc_html__( 'Period 1 Duration Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/ month', 'pns-addons-for-elementor' ),
			]
		);

		$plan_repeater->add_control(
			'period_2_price',
			[
				'label'   => esc_html__( 'Period 2 Price (Yearly)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '290',
			]
		);

		$plan_repeater->add_control(
			'period_2_original_price',
			[
				'label'       => esc_html__( 'Period 2 Original Price (Strikethrough)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '390',
				'placeholder' => esc_html__( 'Optional strikethrough price', 'pns-addons-for-elementor' ),
			]
		);

		$plan_repeater->add_control(
			'period_2_duration',
			[
				'label'   => esc_html__( 'Period 2 Duration Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/ year', 'pns-addons-for-elementor' ),
			]
		);

		$plan_repeater->add_control(
			'price_note',
			[
				'label'       => esc_html__( 'Price Description / Note', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Billed annually or month-to-month', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$plan_repeater->add_control(
			'features_list_text',
			[
				'label'       => esc_html__( 'Features (One per line)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => "✓ Full Access to All Core Features\n✓ 10 Team Members Included\n✓ 50 GB High-Speed Cloud Storage\n✓ Priority Email & Chat Support\n- Advanced Custom Analytics\n- Dedicated Account Manager",
				'description' => esc_html__( 'Formatting tips: Prefix line with "-" or "x" for excluded item; prefix with "*" for highlighted item; append "[tooltip: Details here]" for an info tooltip.', 'pns-addons-for-elementor' ),
				'rows'        => 8,
			]
		);

		$plan_repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Order Now', 'pns-addons-for-elementor' ),
			]
		);

		$plan_repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link (Default / Period 1)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url' => '#',
				],
				'placeholder' => 'https://your-domain.com/checkout',
			]
		);

		$plan_repeater->add_control(
			'button_link_period_2',
			[
				'label'       => esc_html__( 'Button Link Period 2 (Optional URL for Yearly)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-domain.com/checkout-annual',
			]
		);

		$plan_repeater->add_control(
			'button_icon',
			[
				'label'   => esc_html__( 'Button Icon', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => '',
				],
			]
		);

		$plan_repeater->add_control(
			'button_note',
			[
				'label'   => esc_html__( 'Button Sub-note', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$plan_repeater->add_control(
			'footer_note',
			[
				'label'   => esc_html__( 'Bottom Guarantee / Footer Note', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'plans',
			[
				'label'       => esc_html__( 'Plans', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $plan_repeater->get_controls(),
				'default'     => [
					[
						'plan_title'              => esc_html__( 'Basic', 'pns-addons-for-elementor' ),
						'plan_subtitle'           => '',
						'plan_icon'               => [
							'value'   => 'fas fa-paper-plane',
							'library' => 'fa-solid',
						],
						'price_prefix'            => 'Price: ',
						'currency'                => '$',
						'period_1_price'          => '150',
						'period_1_original_price' => '',
						'period_1_duration'       => '/ mo',
						'period_2_price'          => '1500',
						'period_2_original_price' => '',
						'period_2_duration'       => '/ yr',
						'button_text'             => esc_html__( 'Order Now', 'pns-addons-for-elementor' ),
						'is_featured'             => 'no',
						'features_list_text'      => "✓ 50 Products Upload\n✓ Domain + Hosting (1 Year)\n✓ Mobile Responsive Design\n✓ Product Variations (Size, Color)\n✓ Live Chat Support\n✓ Basic SEO Setup\n✓ Free Training & Support",
					],
					[
						'plan_title'              => esc_html__( 'Standard', 'pns-addons-for-elementor' ),
						'plan_subtitle'           => '',
						'plan_icon'               => [
							'value'   => 'fas fa-rocket',
							'library' => 'fa-solid',
						],
						'price_prefix'            => 'Price: ',
						'currency'                => '$',
						'period_1_price'          => '250',
						'period_1_original_price' => '',
						'period_1_duration'       => '/ mo',
						'period_2_price'          => '2500',
						'period_2_original_price' => '',
						'period_2_duration'       => '/ yr',
						'button_text'             => esc_html__( 'Order Now', 'pns-addons-for-elementor' ),
						'is_featured'             => 'yes',
						'badge_text'              => esc_html__( 'Most Popular', 'pns-addons-for-elementor' ),
						'badge_style'             => 'pill',
						'features_list_text'      => "✓ Everything in Basic Plan\n✓ 100 Products Upload\n✓ Blog & Content Section\n✓ Coupon / Discount System\n✓ Live Chat & Instant Support\n✓ Courier Automation Setup\n✓ Facebook Pixel & Analytics",
					],
					[
						'plan_title'              => esc_html__( 'Premium', 'pns-addons-for-elementor' ),
						'plan_subtitle'           => '',
						'plan_icon'               => [
							'value'   => 'fas fa-crown',
							'library' => 'fa-solid',
						],
						'price_prefix'            => 'Price: ',
						'currency'                => '$',
						'period_1_price'          => '350',
						'period_1_original_price' => '',
						'period_1_duration'       => '/ mo',
						'period_2_price'          => '3500',
						'period_2_original_price' => '',
						'period_2_duration'       => '/ yr',
						'button_text'             => esc_html__( 'Order Now', 'pns-addons-for-elementor' ),
						'is_featured'             => 'no',
						'features_list_text'      => "✓ 250+ Products Upload\n✓ Advanced Courier Automation\n✓ Advanced SEO & Speed Optimization\n✓ 24/7 Priority VIP Support\n✓ Custom Features & Integration\n✓ Advanced Courier Automation\n✓ 2 Months Free Maintenance",
					],
				],
				'title_field' => '{{{ plan_title }}}',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 4. CONTENT TAB: SINGLE CARD MODE CONTROLS
		// ==========================================
		$this->start_controls_section(
			'section_single_header',
			[
				'label'     => esc_html__( 'Card Header & Badge', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_mode' => 'single',
				],
			]
		);

		$this->add_control(
			'single_title',
			[
				'label'       => esc_html__( 'Plan Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Standard', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'single_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'single_icon',
			[
				'label'   => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'single_is_featured',
			[
				'label'        => esc_html__( 'Featured / Highlighted Card', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'single_badge_text',
			[
				'label'     => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Most Popular', 'pns-addons-for-elementor' ),
				'condition' => [
					'single_is_featured' => 'yes',
				],
			]
		);

		$this->add_control(
			'single_badge_style',
			[
				'label'     => esc_html__( 'Badge Style', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'pill',
				'options'   => [
					'pill'   => esc_html__( 'Floating Pill', 'pns-addons-for-elementor' ),
					'ribbon' => esc_html__( 'Corner Ribbon', 'pns-addons-for-elementor' ),
					'flag'   => esc_html__( 'Top Flag', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'single_is_featured' => 'yes',
				],
			]
		);

		$this->add_control(
			'single_badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-flag' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'single_is_featured' => 'yes',
				],
			]
		);

		$this->add_control(
			'single_badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-flag' => 'background-color: {{VALUE}} !important; background-image: none !important;',
				],
				'condition' => [
					'single_is_featured' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Single Mode: Pricing
		$this->start_controls_section(
			'section_single_pricing',
			[
				'label'     => esc_html__( 'Card Pricing', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_mode' => 'single',
				],
			]
		);

		$this->add_control(
			'single_price_prefix',
			[
				'label'       => esc_html__( 'Price Prefix (e.g. Price: )', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Price: ',
				'placeholder' => 'Price: ',
			]
		);

		$this->add_control(
			'single_currency',
			[
				'label'   => esc_html__( 'Currency Symbol', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
			]
		);

		$this->add_control(
			'single_period_1_price',
			[
				'label'   => esc_html__( 'Period 1 Price (Monthly)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '49',
			]
		);

		$this->add_control(
			'single_period_1_original_price',
			[
				'label'   => esc_html__( 'Period 1 Original Price (Strikethrough)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '65',
			]
		);

		$this->add_control(
			'single_period_1_duration',
			[
				'label'   => esc_html__( 'Period 1 Duration Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/ month', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'single_period_2_price',
			[
				'label'   => esc_html__( 'Period 2 Price (Yearly)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '490',
			]
		);

		$this->add_control(
			'single_period_2_original_price',
			[
				'label'   => esc_html__( 'Period 2 Original Price (Strikethrough)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '650',
			]
		);

		$this->add_control(
			'single_period_2_duration',
			[
				'label'   => esc_html__( 'Period 2 Duration Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/ year', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'single_price_note',
			[
				'label'   => esc_html__( 'Price Description / Note', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Billed annually or month-to-month', 'pns-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		// Single Mode: Features Repeater
		$this->start_controls_section(
			'section_single_features',
			[
				'label'     => esc_html__( 'Card Features List', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_mode' => 'single',
				],
			]
		);

		$feature_repeater = new Repeater();

		$feature_repeater->add_control(
			'feature_text',
			[
				'label'       => esc_html__( 'Feature Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Feature item description', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$feature_repeater->add_control(
			'is_included',
			[
				'label'        => esc_html__( 'Included in this Plan?', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$feature_repeater->add_control(
			'custom_icon',
			[
				'label'       => esc_html__( 'Custom Icon Override', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Leave empty to use default check/cross icon', 'pns-addons-for-elementor' ),
			]
		);

		$feature_repeater->add_control(
			'tooltip_text',
			[
				'label'       => esc_html__( 'Tooltip / Subtext Hint', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Optional tooltip message on hover', 'pns-addons-for-elementor' ),
			]
		);

		$feature_repeater->add_control(
			'is_highlight',
			[
				'label'        => esc_html__( 'Highlight Feature (Bold / Star)', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'single_features',
			[
				'label'       => esc_html__( 'Features', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $feature_repeater->get_controls(),
				'default'     => [
					[
						'feature_text' => esc_html__( 'Unlimited Active Projects', 'pns-addons-for-elementor' ),
						'is_included'  => 'yes',
						'is_highlight' => 'yes',
						'tooltip_text' => esc_html__( 'Create and manage unlimited client projects', 'pns-addons-for-elementor' ),
					],
					[
						'feature_text' => esc_html__( '50 GB Cloud Storage Included', 'pns-addons-for-elementor' ),
						'is_included'  => 'yes',
					],
					[
						'feature_text' => esc_html__( 'Team Collaboration (up to 5 users)', 'pns-addons-for-elementor' ),
						'is_included'  => 'yes',
					],
					[
						'feature_text' => esc_html__( 'Priority 24/7 Email & Chat Support', 'pns-addons-for-elementor' ),
						'is_included'  => 'yes',
					],
					[
						'feature_text' => esc_html__( 'Custom Domain & White Labeling', 'pns-addons-for-elementor' ),
						'is_included'  => 'no',
					],
				],
				'title_field' => '{{{ feature_text }}}',
			]
		);

		$this->end_controls_section();

		// Single Mode: Action & Footer
		$this->start_controls_section(
			'section_single_action',
			[
				'label'     => esc_html__( 'Action Button & Footer', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_mode' => 'single',
				],
			]
		);

		$this->add_control(
			'single_button_text',
			[
				'label'   => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Order Now', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'single_button_link',
			[
				'label'   => esc_html__( 'Button Link (Default / Period 1)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'single_button_link_period_2',
			[
				'label'       => esc_html__( 'Button Link Period 2 (Yearly URL)', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-domain.com/checkout-annual',
			]
		);

		$this->add_control(
			'single_button_icon',
			[
				'label'   => esc_html__( 'Button Icon', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => '',
				],
			]
		);

		$this->add_control(
			'single_button_note',
			[
				'label'   => esc_html__( 'Button Sub-note', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'No credit card required', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'single_footer_note',
			[
				'label'   => esc_html__( 'Footer Guarantee Note', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '30-day money-back guarantee • Cancel anytime', 'pns-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 5. STYLE TAB: CARD BOX
		// ==========================================
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card Container', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		$this->start_controls_tab(
			'tab_card_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .pns-pricing-card',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_card_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_background_hover',
				'label'    => esc_html__( 'Background Hover', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-card:hover',
			]
		);

		$this->add_control(
			'card_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color Hover', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .pns-pricing-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_card_featured',
			[
				'label' => esc_html__( 'Featured Card', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_card_background',
				'label'    => esc_html__( 'Featured Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-card.pns-featured-card',
			]
		);

		$this->add_control(
			'featured_border_color',
			[
				'label'     => esc_html__( 'Featured Border Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6366f1',
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-card.pns-featured-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_box_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-card.pns-featured-card',
			]
		);

		$this->add_control(
			'featured_card_scale',
			[
				'label'     => esc_html__( 'Card Scale / Lift', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.95,
						'max'  => 1.15,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-card.pns-featured-card' => 'transform: scale({{SIZE}});',
					'{{WRAPPER}} .pns-pricing-card.pns-featured-card:hover' => 'transform: scale(calc({{SIZE}} + 0.02)) translateY(-4px);',
				],
			]
		);

		$this->add_control(
			'heading_featured_badge_style',
			[
				'label'     => esc_html__( 'Popular Badge / Ribbon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-pill, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-flag' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'featured_badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-pill, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-flag' => 'background-color: {{VALUE}} !important; background-image: none !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_badge_background',
				'label'    => esc_html__( 'Badge Background (Gradient / Image)', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-pill, {{WRAPPER}} .pns-featured-card .pns-pricing-badge-flag',
			]
		);

		$this->add_control(
			'heading_featured_text_colors',
			[
				'label'     => esc_html__( 'Featured Card Text Colors', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_icon_color',
			[
				'label'     => esc_html__( 'Header Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_icon_bg',
			[
				'label'     => esc_html__( 'Header Icon Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_price_color',
			[
				'label'     => esc_html__( 'Price & Currency Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-amount'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .pns-featured-card .pns-pricing-currency' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pns-featured-card .pns-pricing-prefix'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_original_price_color',
			[
				'label'     => esc_html__( 'Original Price (Strikethrough) Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-original' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_period_color',
			[
				'label'     => esc_html__( 'Period Duration Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_price_note_color',
			[
				'label'     => esc_html__( 'Price Note Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-period-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_featured_features_colors',
			[
				'label'     => esc_html__( 'Featured Features List', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_feature_text_color',
			[
				'label'     => esc_html__( 'Feature Item Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-feature--included .pns-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_feature_excluded_color',
			[
				'label'     => esc_html__( 'Excluded Feature Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-feature--excluded .pns-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_feature_icon_color',
			[
				'label'     => esc_html__( 'Included Checkmark Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-feature--included .pns-feature-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_feature_icon_bg',
			[
				'label'     => esc_html__( 'Included Checkmark Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-feature--included .pns-feature-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_footer_note_color',
			[
				'label'     => esc_html__( 'Footer Guarantee & Sub-note Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-footer-note' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pns-featured-card .pns-pricing-btn-note'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_divider_color',
			[
				'label'     => esc_html__( 'Divider Lines Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-box'    => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .pns-featured-card .pns-pricing-footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_featured_btn_card_style',
			[
				'label'     => esc_html__( 'Featured Card Button', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_card_btn_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_card_btn_bg',
				'label'    => esc_html__( 'Button Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 6. STYLE TAB: BILLING SWITCHER
		// ==========================================
		$this->start_controls_section(
			'section_style_switcher',
			[
				'label'     => esc_html__( 'Billing Switcher', 'pns-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_switcher' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'switcher_alignment',
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
				'default'   => 'center',
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switcher-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'switcher_spacing_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 48,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-switcher-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_switcher_container_style',
			[
				'label'     => esc_html__( 'Switcher Bar Container', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'switcher_container_bg',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-switcher',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'switcher_container_border',
				'selector' => '{{WRAPPER}} .pns-pricing-switcher',
			]
		);

		$this->add_responsive_control(
			'switcher_container_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-switcher' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'switcher_container_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-switcher',
			]
		);

		$this->add_responsive_control(
			'switcher_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-switcher' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_switch_buttons_style',
			[
				'label'     => esc_html__( 'Switch Buttons (Monthly / Yearly)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'switcher_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-switch-btn',
			]
		);

		$this->add_responsive_control(
			'switcher_btn_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-switch-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_switcher_btn_states' );

		// Tab: Inactive (Normal)
		$this->start_controls_tab(
			'tab_switcher_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'switcher_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switch-btn:not(.active)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'switcher_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switch-btn:not(.active):hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_switcher_btn_active',
			[
				'label' => esc_html__( 'Active Pill', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'switcher_active_text_color',
			[
				'label'     => esc_html__( 'Active Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-switch-btn.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'switcher_active_bg',
				'label'    => esc_html__( 'Active Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-switch-btn.active',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'switcher_active_border',
				'selector' => '{{WRAPPER}} .pns-pricing-switch-btn.active',
			]
		);

		$this->add_responsive_control(
			'switcher_active_radius',
			[
				'label'      => esc_html__( 'Active Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-switch-btn.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'switcher_active_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-switch-btn.active',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Heading: Discount Badge
		$this->add_control(
			'heading_discount_badge',
			[
				'label'     => esc_html__( 'Discount Badge', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'discount_badge_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-discount-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'discount_badge_bg_group',
				'label'    => esc_html__( 'Badge Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-discount-badge',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'discount_badge_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-discount-badge',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'discount_badge_border',
				'selector' => '{{WRAPPER}} .pns-pricing-discount-badge',
			]
		);

		$this->add_responsive_control(
			'discount_badge_radius',
			[
				'label'      => esc_html__( 'Badge Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-discount-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'discount_badge_padding',
			[
				'label'      => esc_html__( 'Badge Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-discount-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'discount_badge_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-discount-badge',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 7. STYLE TAB: HEADER & BADGE
		// ==========================================
		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Header & Badges', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_alignment',
			[
				'label'     => esc_html__( 'Header Alignment', 'pns-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_title_color',
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
				'name'     => 'header_title_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-title',
			]
		);

		$this->add_control(
			'header_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_subtitle_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-subtitle',
			]
		);

		$this->add_control(
			'heading_badge_style',
			[
				'label'     => esc_html__( 'Featured Badge / Ribbon', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-flag' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-flag' => 'background-color: {{VALUE}} !important; background-image: none !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'badge_background',
				'label'    => esc_html__( 'Badge Background (Gradient / Image)', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-ribbon-corner, {{WRAPPER}} .pns-pricing-badge-pill, {{WRAPPER}} .pns-pricing-badge-flag',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 8. STYLE TAB: PRICING
		// ==========================================
		$this->start_controls_section(
			'section_style_pricing',
			[
				'label' => esc_html__( 'Pricing & Currency', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pricing_alignment',
			[
				'label'     => esc_html__( 'Pricing Alignment', 'pns-addons-for-elementor' ),
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
				'prefix_class' => 'pns-pricing-align%s-',
				'selectors'    => [
					'{{WRAPPER}} .pns-pricing-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_amount_color',
			[
				'label'     => esc_html__( 'Price Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-amount'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-currency' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pns-pricing-prefix'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_amount_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-amount',
			]
		);

		$this->add_control(
			'price_currency_color',
			[
				'label'     => esc_html__( 'Currency Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_currency_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-currency',
			]
		);

		$this->add_control(
			'original_price_color',
			[
				'label'     => esc_html__( 'Original Price (Strikethrough) Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-original' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_duration_color',
			[
				'label'     => esc_html__( 'Duration Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_duration_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-period',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 9. STYLE TAB: FEATURES LIST
		// ==========================================
		$this->start_controls_section(
			'section_style_features',
			[
				'label' => esc_html__( 'Features List', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'features_alignment',
			[
				'label'     => esc_html__( 'Features Alignment', 'pns-addons-for-elementor' ),
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
				'prefix_class' => 'pns-features-align%s-',
				'selectors'    => [
					'{{WRAPPER}} .pns-pricing-feature-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'features_container_width',
			[
				'label'      => esc_html__( 'Container Width', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [
						'min' => 40,
						'max' => 100,
					],
					'px' => [
						'min' => 150,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-features' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'features_gap',
			[
				'label'      => esc_html__( 'Item Gap', 'pns-addons-for-elementor' ),
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
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-features' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'features_item_padding',
			[
				'label'      => esc_html__( 'Item Padding (Top / Bottom)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 2,
						'max' => 24,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 7,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-feature-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_text_color',
			[
				'label'     => esc_html__( 'Feature Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-feature--included .pns-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_excluded_color',
			[
				'label'     => esc_html__( 'Excluded Item Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-feature--excluded .pns-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-feature-item',
			]
		);

		$this->add_control(
			'heading_feature_icons',
			[
				'label'     => esc_html__( 'Feature Icons', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'feature_included_icon_color',
			[
				'label'     => esc_html__( 'Included Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-feature--included .pns-feature-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_included_icon_bg',
			[
				'label'     => esc_html__( 'Included Icon Background', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-feature--included .pns-feature-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_excluded_icon_color',
			[
				'label'     => esc_html__( 'Excluded Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-feature--excluded .pns-feature-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 10. STYLE TAB: BUTTON
		// ==========================================
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Action Button', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_alignment',
			[
				'label'     => esc_html__( 'Button Alignment', 'pns-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-action' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_full_width',
			[
				'label'        => esc_html__( 'Full Width Button', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'pns-btn-full-',
			]
		);

		$this->add_responsive_control(
			'button_note_alignment',
			[
				'label'     => esc_html__( 'Sub-note Alignment', 'pns-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-btn-note' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_btn_style' );

		$this->start_controls_tab(
			'tab_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'btn_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'btn_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'btn_border',
				'selector' => '{{WRAPPER}} .pns-pricing-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'btn_box_shadow',
				'selector' => '{{WRAPPER}} .pns-pricing-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'btn_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'btn_background_hover',
				'label'    => esc_html__( 'Background Hover', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-pricing-btn:hover',
			]
		);

		$this->add_control(
			'btn_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color Hover', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .pns-pricing-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_featured_btn_style',
			[
				'label'     => esc_html__( 'Featured Plan Button', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_featured_btn_style' );

		$this->start_controls_tab(
			'tab_featured_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'featured_btn_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_btn_background',
				'label'    => esc_html__( 'Background', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'featured_btn_border',
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_btn_box_shadow',
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_featured_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'featured_btn_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_btn_background_hover',
				'label'    => esc_html__( 'Background Hover', 'pns-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn:hover',
			]
		);

		$this->add_control(
			'featured_btn_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color Hover', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-featured-card .pns-pricing-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .pns-featured-card .pns-pricing-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-pricing-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// 11. STYLE TAB: FOOTER NOTE
		// ==========================================
		$this->start_controls_section(
			'section_style_footer',
			[
				'label' => esc_html__( 'Footer Guarantee Note', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'footer_alignment',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-footer, {{WRAPPER}} .pns-pricing-footer-note' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'footer_note_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-pricing-footer-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'footer_note_typography',
				'selector' => '{{WRAPPER}} .pns-pricing-footer-note',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Helper: Parse multiline features string into structured array
	 */
	protected function parse_features_text( $text ) {
		$lines = explode( "\n", str_replace( "\r", '', $text ) );
		$features = [];

		foreach ( $lines as $line ) {
			$trimmed = trim( $line );
			if ( empty( $trimmed ) ) {
				continue;
			}

			$is_included = true;
			$is_highlight = false;
			$tooltip = '';

			// Check for tooltip syntax [tooltip: ...]
			if ( preg_match( '/\[tooltip:\s*([^\]]+)\]/i', $trimmed, $matches ) ) {
				$tooltip = trim( $matches[1] );
				$trimmed = trim( preg_replace( '/\[tooltip:\s*[^\]]+\]/i', '', $trimmed ) );
			}

			// Check for excluded prefix: - or x or ✕ or ✗
			if ( preg_match( '/^[-x✕✗]\s*(.*)$/u', $trimmed, $matches ) ) {
				$is_included = false;
				$trimmed = $matches[1];
			} elseif ( preg_match( '/^[✓+✔]\s*(.*)$/u', $trimmed, $matches ) ) {
				$is_included = true;
				$trimmed = $matches[1];
			}

			// Check for highlight prefix: *
			if ( preg_match( '/^\*\s*(.*)$/u', $trimmed, $matches ) ) {
				$is_highlight = true;
				$trimmed = $matches[1];
			}

			$features[] = [
				'text'        => $trimmed,
				'is_included' => $is_included,
				'is_highlight'=> $is_highlight,
				'tooltip'     => $tooltip,
			];
		}

		return $features;
	}

	/**
	 * Helper: Render a single feature item
	 */
	protected function render_feature_item( $feature, $custom_icon = null ) {
		$item_classes = [ 'pns-pricing-feature-item' ];
		$item_classes[] = $feature['is_included'] ? 'pns-feature--included' : 'pns-feature--excluded';
		if ( ! empty( $feature['is_highlight'] ) ) {
			$item_classes[] = 'pns-feature--highlight';
		}

		?>
		<li class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
			<span class="pns-feature-icon" aria-hidden="true">
				<?php
				if ( ! empty( $custom_icon ) && ! empty( $custom_icon['value'] ) ) {
					Icons_Manager::render_icon( $custom_icon, [ 'aria-hidden' => 'true' ] );
				} elseif ( $feature['is_included'] ) {
					// Modern Clean SVG Checkmark
					echo '<svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>';
				} else {
					// Modern Clean SVG Crossmark
					echo '<svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
				}
				?>
			</span>
			<span class="pns-feature-text"><?php echo esc_html( $feature['text'] ); ?></span>
			<?php if ( ! empty( $feature['tooltip'] ) ) : ?>
				<span class="pns-feature-tooltip-trigger" tabindex="0" role="button" aria-label="<?php echo esc_attr( $feature['tooltip'] ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
						<path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
					</svg>
					<span class="pns-feature-tooltip-content"><?php echo esc_html( $feature['tooltip'] ); ?></span>
				</span>
			<?php endif; ?>
		</li>
		<?php
	}

	/**
	 * Helper: Render a card HTML
	 */
	protected function render_card_html( $plan, $settings, $default_period = '1' ) {
		$is_featured = ( ! empty( $plan['is_featured'] ) && 'yes' === $plan['is_featured'] );
		$card_classes = [ 'pns-pricing-card' ];
		if ( $is_featured ) {
			$card_classes[] = 'pns-featured-card';
		}
		if ( ! empty( $plan['_id'] ) ) {
			$card_classes[] = 'elementor-repeater-item-' . $plan['_id'];
		}

		$badge_text = ! empty( $plan['badge_text'] ) ? $plan['badge_text'] : '';
		$badge_style = ! empty( $plan['badge_style'] ) ? $plan['badge_style'] : 'pill';
		$currency = ! empty( $plan['currency'] ) ? $plan['currency'] : '$';

		$p1_active = ( '1' === $default_period ) ? 'active' : '';
		$p2_active = ( '2' === $default_period ) ? 'active' : '';

		$btn_url_1 = ! empty( $plan['button_link']['url'] ) ? $plan['button_link']['url'] : '#';
		$btn_url_2 = ! empty( $plan['button_link_period_2']['url'] ) ? $plan['button_link_period_2']['url'] : $btn_url_1;
		$current_btn_url = ( '2' === $default_period && ! empty( $plan['button_link_period_2']['url'] ) ) ? $btn_url_2 : $btn_url_1;

		$badge_inline = [];
		if ( ! empty( $plan['badge_text_color'] ) ) {
			$badge_inline[] = 'color: ' . esc_attr( $plan['badge_text_color'] ) . ' !important;';
		}
		if ( ! empty( $plan['badge_bg_color'] ) ) {
			$badge_inline[] = 'background-color: ' . esc_attr( $plan['badge_bg_color'] ) . ' !important; background-image: none !important;';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

			<?php
			// Render Badge if featured
			if ( $is_featured && ! empty( $badge_text ) ) {
				$badge_class = 'pns-pricing-badge-pill';
				if ( 'ribbon' === $badge_style ) {
					$badge_class = 'pns-pricing-ribbon-corner';
				} elseif ( 'flag' === $badge_style ) {
					$badge_class = 'pns-pricing-badge-flag';
				}
				?>
				<div class="<?php echo esc_attr( $badge_class ); ?>"<?php if ( ! empty( $badge_inline ) ) : ?> style="<?php echo esc_attr( implode( ' ', $badge_inline ) ); ?>"<?php endif; ?>><?php echo esc_html( $badge_text ); ?></div>
				<?php
			}
			?>

			<!-- Header -->
			<div class="pns-pricing-header">
				<?php if ( ! empty( $plan['plan_icon'] ) && ! empty( $plan['plan_icon']['value'] ) ) : ?>
					<div class="pns-pricing-icon" aria-hidden="true">
						<?php Icons_Manager::render_icon( $plan['plan_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $plan['plan_title'] ) ) : ?>
					<h3 class="pns-pricing-title"><?php echo esc_html( $plan['plan_title'] ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $plan['plan_subtitle'] ) ) : ?>
					<p class="pns-pricing-subtitle"><?php echo esc_html( $plan['plan_subtitle'] ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Pricing Box -->
			<div class="pns-pricing-box">
				<!-- Period 1 Price -->
				<div class="pns-period-price pns-period-1 <?php echo esc_attr( $p1_active ); ?>">
					<?php if ( ! empty( $plan['period_1_original_price'] ) ) : ?>
						<div class="pns-pricing-original"><?php echo esc_html( $currency . $plan['period_1_original_price'] ); ?></div>
					<?php endif; ?>
					<div class="pns-pricing-amount-wrap">
						<?php if ( ! empty( $plan['price_prefix'] ) ) : ?>
							<span class="pns-pricing-prefix"><?php echo esc_html( $plan['price_prefix'] ); ?></span>
						<?php endif; ?>
						<span class="pns-pricing-currency"><?php echo esc_html( $currency ); ?></span>
						<span class="pns-pricing-amount"><?php echo esc_html( $plan['period_1_price'] ); ?></span>
						<?php if ( ! empty( $plan['period_1_duration'] ) ) : ?>
							<span class="pns-pricing-period"><?php echo esc_html( $plan['period_1_duration'] ); ?></span>
						<?php endif; ?>
					</div>
				</div>

				<!-- Period 2 Price -->
				<div class="pns-period-price pns-period-2 <?php echo esc_attr( $p2_active ); ?>">
					<?php if ( ! empty( $plan['period_2_original_price'] ) ) : ?>
						<div class="pns-pricing-original"><?php echo esc_html( $currency . $plan['period_2_original_price'] ); ?></div>
					<?php endif; ?>
					<div class="pns-pricing-amount-wrap">
						<?php if ( ! empty( $plan['price_prefix'] ) ) : ?>
							<span class="pns-pricing-prefix"><?php echo esc_html( $plan['price_prefix'] ); ?></span>
						<?php endif; ?>
						<span class="pns-pricing-currency"><?php echo esc_html( $currency ); ?></span>
						<span class="pns-pricing-amount"><?php echo esc_html( $plan['period_2_price'] ); ?></span>
						<?php if ( ! empty( $plan['period_2_duration'] ) ) : ?>
							<span class="pns-pricing-period"><?php echo esc_html( $plan['period_2_duration'] ); ?></span>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( ! empty( $plan['price_note'] ) ) : ?>
					<div class="pns-pricing-period-note"><?php echo esc_html( $plan['price_note'] ); ?></div>
				<?php endif; ?>
			</div>

			<!-- Features List -->
			<ul class="pns-pricing-features">
				<?php
				if ( isset( $plan['features_list_text'] ) ) {
					$features = $this->parse_features_text( $plan['features_list_text'] );
					foreach ( $features as $feat ) {
						$this->render_feature_item( $feat );
					}
				}
				?>
			</ul>

			<!-- CTA Button -->
			<div class="pns-pricing-action">
				<?php if ( ! empty( $plan['button_text'] ) ) : ?>
					<a href="<?php echo esc_url( $current_btn_url ); ?>"
					   class="pns-pricing-btn <?php echo ( $is_featured ) ? 'pns-btn-primary' : ''; ?>"
					   data-url-period-1="<?php echo esc_url( $btn_url_1 ); ?>"
					   data-url-period-2="<?php echo esc_url( $btn_url_2 ); ?>"
					   <?php if ( ! empty( $plan['button_link']['is_external'] ) ) echo 'target="_blank"'; ?>
					   <?php if ( ! empty( $plan['button_link']['nofollow'] ) ) echo 'rel="nofollow"'; ?>>
						<span class="pns-pricing-btn-text"><?php echo esc_html( $plan['button_text'] ); ?></span>
						<?php if ( ! empty( $plan['button_icon'] ) && ! empty( $plan['button_icon']['value'] ) ) : ?>
							<span class="pns-pricing-btn-icon" aria-hidden="true">
								<?php Icons_Manager::render_icon( $plan['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $plan['button_note'] ) ) : ?>
					<div class="pns-pricing-btn-note"><?php echo esc_html( $plan['button_note'] ); ?></div>
				<?php endif; ?>
			</div>

			<!-- Footer Guarantee Note -->
			<?php if ( ! empty( $plan['footer_note'] ) ) : ?>
				<div class="pns-pricing-footer">
					<p class="pns-pricing-footer-note"><?php echo esc_html( $plan['footer_note'] ); ?></p>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}

	/**
	 * Render Widget Output on the Frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$layout_mode = ! empty( $settings['layout_mode'] ) ? $settings['layout_mode'] : 'grid';
		$show_switch = ( ! empty( $settings['show_switcher'] ) && 'yes' === $settings['show_switcher'] );
		$default_per = ! empty( $settings['default_period'] ) ? $settings['default_period'] : '1';
		$sync_group  = ! empty( $settings['sync_group_id'] ) ? $settings['sync_group_id'] : '';
		$alignment   = ! empty( $settings['content_alignment'] ) ? $settings['content_alignment'] : 'center';
		$wrapper_classes = [ 'pns-pricing-table-wrapper', 'pns-align-' . $alignment ];

		if ( 'grid' === $layout_mode && ! empty( $settings['equal_height'] ) && 'yes' === $settings['equal_height'] ) {
			$wrapper_classes[] = 'pns-pricing-equal-height';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" <?php if ( ! empty( $sync_group ) ) : ?>data-sync-group="<?php echo esc_attr( $sync_group ); ?>"<?php endif; ?>>

			<?php
			// Render Billing Switcher
			if ( $show_switch ) :
				$period_1_label = ! empty( $settings['period_1_label'] ) ? $settings['period_1_label'] : esc_html__( 'Monthly', 'pns-addons-for-elementor' );
				$period_2_label = ! empty( $settings['period_2_label'] ) ? $settings['period_2_label'] : esc_html__( 'Yearly', 'pns-addons-for-elementor' );
				$discount_badge = ! empty( $settings['discount_badge_text'] ) ? $settings['discount_badge_text'] : '';
				?>
				<div class="pns-pricing-switcher-wrapper">
					<div class="pns-pricing-switcher" role="tablist">
						<button type="button"
						        class="pns-pricing-switch-btn <?php echo ( '1' === $default_per ) ? 'active' : ''; ?>"
						        data-period="1"
						        role="tab"
						        aria-selected="<?php echo ( '1' === $default_per ) ? 'true' : 'false'; ?>">
							<?php echo esc_html( $period_1_label ); ?>
						</button>
						<button type="button"
						        class="pns-pricing-switch-btn <?php echo ( '2' === $default_per ) ? 'active' : ''; ?>"
						        data-period="2"
						        role="tab"
						        aria-selected="<?php echo ( '2' === $default_per ) ? 'true' : 'false'; ?>">
							<?php echo esc_html( $period_2_label ); ?>
							<?php if ( ! empty( $discount_badge ) ) : ?>
								<span class="pns-pricing-discount-badge"><?php echo esc_html( $discount_badge ); ?></span>
							<?php endif; ?>
						</button>
					</div>
				</div>
			<?php endif; ?>

			<?php
			// ==========================================
			// GRID MODE RENDERING
			// ==========================================
			if ( 'grid' === $layout_mode ) :
				$cols = ! empty( $settings['grid_columns'] ) ? $settings['grid_columns'] : '3';
				$plans = ! empty( $settings['plans'] ) ? $settings['plans'] : [];
				?>
				<div class="pns-pricing-grid pns-pricing-cols-<?php echo esc_attr( $cols ); ?>">
					<?php
					foreach ( $plans as $plan ) {
						$this->render_card_html( $plan, $settings, $default_per );
					}
					?>
				</div>

			<?php
			// ==========================================
			// SINGLE CARD MODE RENDERING
			// ==========================================
			else :
				$single_is_featured = ( ! empty( $settings['single_is_featured'] ) && 'yes' === $settings['single_is_featured'] );
				$single_card_classes = [ 'pns-pricing-card' ];
				if ( $single_is_featured ) {
					$single_card_classes[] = 'pns-featured-card';
				}

				$badge_text  = ! empty( $settings['single_badge_text'] ) ? $settings['single_badge_text'] : '';
				$badge_style = ! empty( $settings['single_badge_style'] ) ? $settings['single_badge_style'] : 'pill';
				$currency    = ! empty( $settings['single_currency'] ) ? $settings['single_currency'] : '$';

				$p1_active = ( '1' === $default_per ) ? 'active' : '';
				$p2_active = ( '2' === $default_per ) ? 'active' : '';

				$btn_url_1 = ! empty( $settings['single_button_link']['url'] ) ? $settings['single_button_link']['url'] : '#';
				$btn_url_2 = ! empty( $settings['single_button_link_period_2']['url'] ) ? $settings['single_button_link_period_2']['url'] : $btn_url_1;
				$current_btn_url = ( '2' === $default_per && ! empty( $settings['single_button_link_period_2']['url'] ) ) ? $btn_url_2 : $btn_url_1;

				$single_badge_inline = [];
				if ( ! empty( $settings['single_badge_text_color'] ) ) {
					$single_badge_inline[] = 'color: ' . esc_attr( $settings['single_badge_text_color'] ) . ' !important;';
				}
				if ( ! empty( $settings['single_badge_bg_color'] ) ) {
					$single_badge_inline[] = 'background-color: ' . esc_attr( $settings['single_badge_bg_color'] ) . ' !important; background-image: none !important;';
				}
				?>
				<div class="<?php echo esc_attr( implode( ' ', $single_card_classes ) ); ?>">

					<?php
					if ( $single_is_featured && ! empty( $badge_text ) ) {
						$single_badge_class = 'pns-pricing-badge-pill';
						if ( 'ribbon' === $badge_style ) {
							$single_badge_class = 'pns-pricing-ribbon-corner';
						} elseif ( 'flag' === $badge_style ) {
							$single_badge_class = 'pns-pricing-badge-flag';
						}
						?>
						<div class="<?php echo esc_attr( $single_badge_class ); ?>"<?php if ( ! empty( $single_badge_inline ) ) : ?> style="<?php echo esc_attr( implode( ' ', $single_badge_inline ) ); ?>"<?php endif; ?>><?php echo esc_html( $badge_text ); ?></div>
						<?php
					}
					?>

					<!-- Header -->
					<div class="pns-pricing-header">
						<?php if ( ! empty( $settings['single_icon'] ) && ! empty( $settings['single_icon']['value'] ) ) : ?>
							<div class="pns-pricing-icon" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['single_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['single_title'] ) ) : ?>
							<h3 class="pns-pricing-title"><?php echo esc_html( $settings['single_title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $settings['single_subtitle'] ) ) : ?>
							<p class="pns-pricing-subtitle"><?php echo esc_html( $settings['single_subtitle'] ); ?></p>
						<?php endif; ?>
					</div>

					<!-- Pricing Box -->
					<div class="pns-pricing-box">
						<div class="pns-period-price pns-period-1 <?php echo esc_attr( $p1_active ); ?>">
							<?php if ( ! empty( $settings['single_period_1_original_price'] ) ) : ?>
								<div class="pns-pricing-original"><?php echo esc_html( $currency . $settings['single_period_1_original_price'] ); ?></div>
							<?php endif; ?>
							<div class="pns-pricing-amount-wrap">
								<?php if ( ! empty( $settings['single_price_prefix'] ) ) : ?>
									<span class="pns-pricing-prefix"><?php echo esc_html( $settings['single_price_prefix'] ); ?></span>
								<?php endif; ?>
								<span class="pns-pricing-currency"><?php echo esc_html( $currency ); ?></span>
								<span class="pns-pricing-amount"><?php echo esc_html( $settings['single_period_1_price'] ); ?></span>
								<?php if ( ! empty( $settings['single_period_1_duration'] ) ) : ?>
									<span class="pns-pricing-period"><?php echo esc_html( $settings['single_period_1_duration'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>

						<div class="pns-period-price pns-period-2 <?php echo esc_attr( $p2_active ); ?>">
							<?php if ( ! empty( $settings['single_period_2_original_price'] ) ) : ?>
								<div class="pns-pricing-original"><?php echo esc_html( $currency . $settings['single_period_2_original_price'] ); ?></div>
							<?php endif; ?>
							<div class="pns-pricing-amount-wrap">
								<?php if ( ! empty( $settings['single_price_prefix'] ) ) : ?>
									<span class="pns-pricing-prefix"><?php echo esc_html( $settings['single_price_prefix'] ); ?></span>
								<?php endif; ?>
								<span class="pns-pricing-currency"><?php echo esc_html( $currency ); ?></span>
								<span class="pns-pricing-amount"><?php echo esc_html( $settings['single_period_2_price'] ); ?></span>
								<?php if ( ! empty( $settings['single_period_2_duration'] ) ) : ?>
									<span class="pns-pricing-period"><?php echo esc_html( $settings['single_period_2_duration'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>

						<?php if ( ! empty( $settings['single_price_note'] ) ) : ?>
							<div class="pns-pricing-period-note"><?php echo esc_html( $settings['single_price_note'] ); ?></div>
						<?php endif; ?>
					</div>

					<!-- Features List Repeater -->
					<ul class="pns-pricing-features">
						<?php
						$single_features = ! empty( $settings['single_features'] ) ? $settings['single_features'] : [];
						foreach ( $single_features as $s_feat ) {
							$feat_data = [
								'text'        => ! empty( $s_feat['feature_text'] ) ? $s_feat['feature_text'] : '',
								'is_included' => ( ! empty( $s_feat['is_included'] ) && 'yes' === $s_feat['is_included'] ),
								'is_highlight'=> ( ! empty( $s_feat['is_highlight'] ) && 'yes' === $s_feat['is_highlight'] ),
								'tooltip'     => ! empty( $s_feat['tooltip_text'] ) ? $s_feat['tooltip_text'] : '',
							];
							$custom_icon = ! empty( $s_feat['custom_icon'] ) ? $s_feat['custom_icon'] : null;
							$this->render_feature_item( $feat_data, $custom_icon );
						}
						?>
					</ul>

					<!-- Action CTA Button -->
					<div class="pns-pricing-action">
						<?php if ( ! empty( $settings['single_button_text'] ) ) : ?>
							<a href="<?php echo esc_url( $current_btn_url ); ?>"
							   class="pns-pricing-btn <?php echo ( $single_is_featured ) ? 'pns-btn-primary' : ''; ?>"
							   data-url-period-1="<?php echo esc_url( $btn_url_1 ); ?>"
							   data-url-period-2="<?php echo esc_url( $btn_url_2 ); ?>"
							   <?php if ( ! empty( $settings['single_button_link']['is_external'] ) ) echo 'target="_blank"'; ?>
							   <?php if ( ! empty( $settings['single_button_link']['nofollow'] ) ) echo 'rel="nofollow"'; ?>>
								<span class="pns-pricing-btn-text"><?php echo esc_html( $settings['single_button_text'] ); ?></span>
								<?php if ( ! empty( $settings['single_button_icon'] ) && ! empty( $settings['single_button_icon']['value'] ) ) : ?>
									<span class="pns-pricing-btn-icon" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['single_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $settings['single_button_note'] ) ) : ?>
							<div class="pns-pricing-btn-note"><?php echo esc_html( $settings['single_button_note'] ); ?></div>
						<?php endif; ?>
					</div>

					<!-- Footer Guarantee Note -->
					<?php if ( ! empty( $settings['single_footer_note'] ) ) : ?>
						<div class="pns-pricing-footer">
							<p class="pns-pricing-footer-note"><?php echo esc_html( $settings['single_footer_note'] ); ?></p>
						</div>
					<?php endif; ?>

				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}
