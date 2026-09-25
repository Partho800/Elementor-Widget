<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * PNS FAQ Accordion Widget for Elementor
 */
class PNS_FAQ_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget Name
	 */
	public function get_name() {
		return 'pns_faq_widget';
	}

	/**
	 * Widget Title
	 */
	public function get_title() {
		return esc_html__( 'PNS FAQ Accordion', 'pns-addons-for-elementor' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'eicon-help-o';
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
		return [ 'pns-faq-style' ];
	}

	/**
	 * Script dependencies
	 */
	public function get_script_depends() {
		return [ 'pns-faq-script' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// ==========================================
		// CONTENT TAB: FAQ Items
		// ==========================================
		$this->start_controls_section(
			'section_faq_items',
			[
				'label' => esc_html__( 'FAQ Items', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'question',
			[
				'label'       => esc_html__( 'Question', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'What is PNS Addons for Elementor?', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'answer',
			[
				'label'       => esc_html__( 'Answer', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'PNS Addons is a powerful, lightweight, and modern collection of premium widgets built to elevate your Elementor page building experience with stunning interactions and animations.', 'pns-addons-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'is_active_default',
			[
				'label'        => esc_html__( 'Open by Default', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'faq_list',
			[
				'label'       => esc_html__( 'Questions & Answers', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'question'          => esc_html__( 'What is PNS Addons for Elementor?', 'pns-addons-for-elementor' ),
						'answer'            => esc_html__( 'PNS Addons is a powerful, lightweight, and modern collection of premium widgets built to elevate your Elementor page building experience with stunning interactions and animations.', 'pns-addons-for-elementor' ),
						'is_active_default' => 'yes',
					],
					[
						'question'          => esc_html__( 'Is this plugin fully responsive and mobile-friendly?', 'pns-addons-for-elementor' ),
						'answer'            => esc_html__( 'Yes! Every single widget in PNS Addons is engineered from the ground up to be 100% responsive across desktop, tablet, and mobile displays.', 'pns-addons-for-elementor' ),
						'is_active_default' => 'no',
					],
					[
						'question'          => esc_html__( 'Can I customize the typography, colors, and layout?', 'pns-addons-for-elementor' ),
						'answer'            => esc_html__( 'Absolutely. You have total creative freedom over typography, gradients, colors, padding, borders, icons, animations, and spacing right inside the Elementor editor.', 'pns-addons-for-elementor' ),
						'is_active_default' => 'no',
					],
				],
				'title_field' => '{{{ question }}}',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT TAB: Additional Settings
		// ==========================================
		$this->start_controls_section(
			'section_faq_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'accordion_mode',
			[
				'label'        => esc_html__( 'Accordion Mode', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'When enabled, only one FAQ item stays open at a time.', 'pns-addons-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'enable_search',
			[
				'label'        => esc_html__( 'Live Search Filter', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Add a real-time instant search input above the FAQ list.', 'pns-addons-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label'       => esc_html__( 'Search Placeholder', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Search questions...', 'pns-addons-for-elementor' ),
				'condition'   => [ 'enable_search' => 'yes' ],
			]
		);

		$this->add_control(
			'enable_numbering',
			[
				'label'        => esc_html__( 'Enable Numbering Badge', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'number_prefix',
			[
				'label'       => esc_html__( 'Number Prefix', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Q or #', 'pns-addons-for-elementor' ),
				'condition'   => [ 'enable_numbering' => 'yes' ],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Question HTML Tag', 'pns-addons-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
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
			'enable_schema',
			[
				'label'        => esc_html__( 'FAQPage Schema (SEO)', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Automatically injects Google-compliant FAQPage JSON-LD schema markup for enhanced search engine rich snippets.', 'pns-addons-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// CONTENT TAB: Icon Controls
		// ==========================================
		$this->start_controls_section(
			'section_faq_icons',
			[
				'label' => esc_html__( 'Toggle Icons', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label'        => esc_html__( 'Show Toggle Icon', 'pns-addons-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'right' => esc_html__( 'Right Side', 'pns-addons-for-elementor' ),
					'left'  => esc_html__( 'Left Side', 'pns-addons-for-elementor' ),
				],
				'condition' => [ 'show_icon' => 'yes' ],
			]
		);

		$this->add_control(
			'toggle_icon',
			[
				'label'       => esc_html__( 'Toggle Icon', 'pns-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'show_icon' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Item & Container
		// ==========================================
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item & Container', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'      => esc_html__( 'Gap Between Items (px)', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .pns-faq-item',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .pns-faq-item',
			]
		);

		$this->add_control(
			'active_item_heading',
			[
				'label'     => esc_html__( 'Active Item State', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'active_item_border_color',
			[
				'label'     => esc_html__( 'Active Border Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-item.pns-faq-active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'active_item_box_shadow',
				'selector' => '{{WRAPPER}} .pns-faq-item.pns-faq-active',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Question Header
		// ==========================================
		$this->start_controls_section(
			'section_style_question',
			[
				'label' => esc_html__( 'Question Header', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'question_typography',
				'selector' => '{{WRAPPER}} .pns-faq-title',
			]
		);

		$this->start_controls_tabs( 'tabs_question_colors' );

		// Normal State
		$this->start_controls_tab(
			'tab_question_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'question_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'question_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-faq-question' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active State
		$this->start_controls_tab(
			'tab_question_active',
			[ 'label' => esc_html__( 'Active', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'question_active_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1e40af',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-active .pns-faq-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'question_active_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-active .pns-faq-question' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'question_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator'  => 'before',
				'default'    => [
					'top'      => 18,
					'right'    => 24,
					'bottom'   => 18,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-question' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Number / Badge
		// ==========================================
		$this->start_controls_section(
			'section_style_number',
			[
				'label'     => esc_html__( 'Number Badge', 'pns-addons-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_numbering' => 'yes' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .pns-faq-number',
			]
		);

		$this->start_controls_tabs( 'tabs_number_colors' );

		$this->start_controls_tab(
			'tab_number_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eff6ff',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-number' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_number_active',
			[ 'label' => esc_html__( 'Active', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'number_active_color',
			[
				'label'     => esc_html__( 'Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-active .pns-faq-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_active_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-active .pns-faq-number' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'number_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Toggle Icon
		// ==========================================
		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Toggle Icon', 'pns-addons-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_icon' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 40 ],
				],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-icon-wrapper'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pns-faq-icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Normal Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-icon-wrapper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-active .pns-faq-icon-wrapper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Answer Content
		// ==========================================
		$this->start_controls_section(
			'section_style_answer',
			[
				'label' => esc_html__( 'Answer Content', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'answer_typography',
				'selector' => '{{WRAPPER}} .pns-faq-answer-inner',
			]
		);

		$this->add_control(
			'answer_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-answer-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'answer_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-faq-answer-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'answer_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 16,
					'right'    => 24,
					'bottom'   => 22,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-answer-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: Search Bar
		// ==========================================
		$this->start_controls_section(
			'section_style_search',
			[
				'label'     => esc_html__( 'Search Bar Style', 'pns-addons-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_search' => 'yes' ],
			]
		);

		$this->add_control(
			'search_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-search-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_bg_color',
			[
				'label'     => esc_html__( 'Input Background', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pns-faq-search-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'search_border',
				'selector' => '{{WRAPPER}} .pns-faq-search-input',
			]
		);

		$this->add_responsive_control(
			'search_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pns-faq-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['faq_list'] ) ) {
			return;
		}

		$accordion_attr = ( 'yes' === $settings['accordion_mode'] ) ? 'yes' : 'no';
		$title_tag      = ! empty( $settings['title_tag'] ) ? tag_escape( $settings['title_tag'] ) : 'h4';
		$icon_pos_class = ( 'left' === $settings['icon_position'] ) ? 'pns-faq-icon-left' : '';

		// Optional FAQPage Schema items
		$schema_entities = [];
		?>

		<div class="pns-faq-container <?php echo esc_attr( $icon_pos_class ); ?>" data-accordion="<?php echo esc_attr( $accordion_attr ); ?>">

			<?php if ( 'yes' === $settings['enable_search'] ) : ?>
				<div class="pns-faq-search-wrapper">
					<span class="pns-faq-search-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="11" cy="11" r="8"></circle>
							<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
						</svg>
					</span>
					<input 
						type="text" 
						class="pns-faq-search-input" 
						placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" 
						aria-label="<?php echo esc_attr__( 'Search FAQ questions', 'pns-addons-for-elementor' ); ?>"
					/>
				</div>
			<?php endif; ?>

			<ul class="pns-faq-list">
				<?php 
				$counter = 0;
				foreach ( $settings['faq_list'] as $index => $item ) :
					$counter++;
					$is_active = ( 'yes' === $item['is_active_default'] );
					$active_class = $is_active ? 'pns-faq-active' : '';
					$aria_expanded = $is_active ? 'true' : 'false';

					$num_str = str_pad( (string) $counter, 2, '0', STR_PAD_LEFT );
					if ( ! empty( $settings['number_prefix'] ) ) {
						$num_str = esc_html( $settings['number_prefix'] ) . $num_str;
					}

					// Collect schema if enabled
					if ( 'yes' === $settings['enable_schema'] && ! empty( $item['question'] ) ) {
						$schema_entities[] = [
							'@type'          => 'Question',
							'name'           => wp_strip_all_tags( $item['question'] ),
							'acceptedAnswer' => [
								'@type' => 'Answer',
								'text'  => wp_strip_all_tags( $item['answer'] ),
							],
						];
					}
				?>
					<li class="pns-faq-item <?php echo esc_attr( $active_class ); ?>">
						<div class="pns-faq-question" role="button" aria-expanded="<?php echo esc_attr( $aria_expanded ); ?>" tabindex="0">
							<div class="pns-faq-question-left">
								<?php if ( 'yes' === $settings['enable_numbering'] ) : ?>
									<span class="pns-faq-number"><?php echo esc_html( $num_str ); ?></span>
								<?php endif; ?>

								<<?php echo esc_html( $title_tag ); ?> class="pns-faq-title">
									<?php echo esc_html( $item['question'] ); ?>
								</<?php echo esc_html( $title_tag ); ?>>
							</div>

							<?php if ( 'yes' === $settings['show_icon'] && ! empty( $settings['toggle_icon']['value'] ) ) : ?>
								<span class="pns-faq-icon-wrapper" aria-hidden="true">
									<?php \Elementor\Icons_Manager::render_icon( $settings['toggle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="pns-faq-answer">
							<div class="pns-faq-answer-inner">
								<?php echo wp_kses_post( $item['answer'] ); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php if ( 'yes' === $settings['enable_search'] ) : ?>
				<div class="pns-faq-no-results">
					<?php echo esc_html__( 'No matching questions found.', 'pns-addons-for-elementor' ); ?>
				</div>
			<?php endif; ?>

		</div>

		<?php 
		// Output FAQPage Schema JSON-LD if enabled
		if ( 'yes' === $settings['enable_schema'] && ! empty( $schema_entities ) ) : 
			$schema_data = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_entities,
			];
		?>
			<script type="application/ld+json">
				<?php echo wp_json_encode( $schema_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE ); ?>
			</script>
		<?php endif; ?>

		<?php
	}
}