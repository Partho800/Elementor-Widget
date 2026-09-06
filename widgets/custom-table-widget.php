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

class Custom_Table_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_table_widget';
	}

	public function get_title() {
		return esc_html__( 'Custom Responsive HTML Table', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'table', 'grid', 'html table', 'responsive table', 'pricing table', 'comparison', 'data table' ];
	}

	public function get_style_depends() {
		return [ 'custom-table-widget-style' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: TOP HEADER (TABLE TITLE) ---
		$this->start_controls_section(
			'section_table_header',
			[
				'label' => esc_html__( 'Top Header Section', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label'        => esc_html__( 'Show Table Header Title', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'header_text',
			[
				'label'       => esc_html__( 'Header Title Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Flooring Project Overview', 'custom-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter table heading', 'custom-elementor-widgets' ),
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_tag',
			[
				'label'     => esc_html__( 'Header HTML Tag', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
				'default'   => 'h3',
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// --- SECTION: TABLE COLUMNS ---
		$this->start_controls_section(
			'section_table_columns',
			[
				'label' => esc_html__( 'Table Columns (Headers)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$column_repeater = new Repeater();

		$column_repeater->add_control(
			'col_title',
			[
				'label'       => esc_html__( 'Column Title', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Column Title', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$column_repeater->add_control(
			'col_width',
			[
				'label'      => esc_html__( 'Column Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 50, 'max' => 600, 'step' => 1 ],
					'%'  => [ 'min' => 5, 'max' => 100, 'step' => 1 ],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$column_repeater->add_control(
			'col_align',
			[
				'label'   => esc_html__( 'Alignment', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'columns_list',
			[
				'label'       => esc_html__( 'Columns Config', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $column_repeater->get_controls(),
				'default'     => [
					[ 'col_title' => esc_html__( 'S.No.', 'custom-elementor-widgets' ), 'col_align' => 'center' ],
					[ 'col_title' => esc_html__( 'AREA', 'custom-elementor-widgets' ), 'col_align' => 'center' ],
					[ 'col_title' => esc_html__( 'FLOORING TYPE', 'custom-elementor-widgets' ), 'col_align' => 'center' ],
					[ 'col_title' => esc_html__( 'METHOD', 'custom-elementor-widgets' ), 'col_align' => 'center' ],
					[ 'col_title' => esc_html__( 'ESSENTIAL PRODUCT', 'custom-elementor-widgets' ), 'col_align' => 'left' ],
					[ 'col_title' => esc_html__( 'LOCATION', 'custom-elementor-widgets' ), 'col_align' => 'center' ],
				],
				'title_field' => '{{{ col_title }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: TABLE ROWS & CONTENT ---
		$this->start_controls_section(
			'section_table_rows',
			[
				'label' => esc_html__( 'Table Rows Content', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'first_col_is_header',
			[
				'label'        => esc_html__( 'First Column acts as Row Header', 'custom-elementor-widgets' ),
				'description'  => esc_html__( 'Check this if the leftmost cell in each row is a label/header.', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$cell_repeater = new Repeater();

		$cell_repeater->add_control(
			'cell_content',
			[
				'label'       => esc_html__( 'Cell Content', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'cells_list',
			[
				'label'       => esc_html__( 'All Table Cells (Click + for next cell)', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cell_repeater->get_controls(),
				'default'     => [
					[ 'cell_content' => '1' ],
					[ 'cell_content' => '155000 SQFT' ],
					[ 'cell_content' => 'FM2 FLOORING' ],
					[ 'cell_content' => 'TRUSS SCREED FLOORING' ],
					[ 'cell_content' => 'VAPOUR BARRIER SHEET' ],
					[ 'cell_content' => 'LUCKNOW' ],
				],
				'title_field' => '{{{ cell_content || "Empty Cell" }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: RESPONSIVENESS & SCROLL ---
		$this->start_controls_section(
			'section_table_responsive',
			[
				'label' => esc_html__( 'Responsiveness & Scroll', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'horizontal_scroll',
			[
				'label'        => esc_html__( 'Enable Horizontal Scroll', 'custom-elementor-widgets' ),
				'description'  => esc_html__( 'Scroll will appear only inside the table if column widths exceed the layout width.', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_scroll_hint',
			[
				'label'        => esc_html__( 'Show Swipe Hint on Mobile/Tablet', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'horizontal_scroll' => 'yes',
				],
			]
		);

		$this->add_control(
			'scroll_hint_text',
			[
				'label'       => esc_html__( 'Swipe Hint Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '← Swipe horizontally to view full table →', 'custom-elementor-widgets' ),
				'condition'   => [
					'horizontal_scroll' => 'yes',
					'show_scroll_hint'  => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'table_max_width',
			[
				'label'      => esc_html__( 'Table Container Max Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 1600 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-main-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// --- STYLE: TOP HEADER ---
		$this->start_controls_section(
			'section_header_style',
			[
				'label'     => esc_html__( 'Top Header Style', 'custom-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'header_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'custom-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .ce-table-title-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-table-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-table-title-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .ce-table-title',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => esc_html__( 'Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-title-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_margin',
			[
				'label'      => esc_html__( 'Margin', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '0', 'right' => '0', 'bottom' => '15', 'left' => '0', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-title-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: COLUMN HEADERS ---
		$this->start_controls_section(
			'section_th_style',
			[
				'label' => esc_html__( 'Column Headers Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'th_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a64b2a',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table thead tr th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'th_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table thead tr th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'th_typography',
				'selector' => '{{WRAPPER}} .ce-custom-table thead tr th',
			]
		);

		$this->add_responsive_control(
			'th_padding',
			[
				'label'      => esc_html__( 'Header Cell Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-custom-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: ROW HEADER (FIRST COLUMN) ---
		$this->start_controls_section(
			'section_row_header_style',
			[
				'label'     => esc_html__( 'Row Header (First Column) Style', 'custom-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'first_col_is_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_header_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'row_header_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'row_header_typography',
				'selector' => '{{WRAPPER}} .ce-custom-table tbody tr th',
			]
		);

		$this->end_controls_section();


		// --- STYLE: BODY CELLS ---
		$this->start_controls_section(
			'section_td_style',
			[
				'label' => esc_html__( 'Body Cells Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'td_bg_color',
			[
				'label'     => esc_html__( 'Cell Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'td_text_color',
			[
				'label'     => esc_html__( 'Cell Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'td_typography',
				'selector' => '{{WRAPPER}} .ce-custom-table tbody tr td, {{WRAPPER}} .ce-custom-table tbody tr th',
			]
		);

		$this->add_responsive_control(
			'td_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-custom-table tbody tr td, {{WRAPPER}} .ce-custom-table tbody tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_height',
			[
				'label'      => esc_html__( 'Min Row Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 200 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-custom-table tbody tr' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Zebra Stripes
		$this->add_control(
			'enable_zebra',
			[
				'label'        => esc_html__( 'Zebra Stripes (Odd/Even Rows)', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'zebra_odd_bg',
			[
				'label'     => esc_html__( 'Odd Rows Background', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:nth-child(odd) td' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'enable_zebra' => 'yes',
				],
			]
		);

		$this->add_control(
			'zebra_odd_color',
			[
				'label'     => esc_html__( 'Odd Rows Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:nth-child(odd) td' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_zebra' => 'yes',
				],
			]
		);

		$this->add_control(
			'zebra_even_bg',
			[
				'label'     => esc_html__( 'Even Rows Background', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:nth-child(even) td' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'enable_zebra' => 'yes',
				],
			]
		);

		$this->add_control(
			'zebra_even_color',
			[
				'label'     => esc_html__( 'Even Rows Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:nth-child(even) td' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_zebra' => 'yes',
				],
			]
		);

		// Row Hover Effects
		$this->add_control(
			'enable_hover',
			[
				'label'        => esc_html__( 'Row Hover Highlight', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'hover_row_bg',
			[
				'label'     => esc_html__( 'Hover Row Background', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:hover td' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ce-custom-table tbody tr:hover th' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'enable_hover' => 'yes',
				],
			]
		);

		$this->add_control(
			'hover_row_color',
			[
				'label'     => esc_html__( 'Hover Row Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table tbody tr:hover td' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-custom-table tbody tr:hover th' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_hover' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: BORDERS & SHADOW ---
		$this->start_controls_section(
			'section_borders_shadow_style',
			[
				'label' => esc_html__( 'Borders, Shadow & Box Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'table_border',
				'selector' => '{{WRAPPER}} .ce-table-main-wrapper',
			]
		);

		$this->add_control(
			'cell_border_color',
			[
				'label'     => esc_html__( 'Grid/Cell Border Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .ce-custom-table th' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ce-custom-table td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_width',
			[
				'label'      => esc_html__( 'Grid/Cell Border Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-custom-table th' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ce-custom-table td' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_border_radius',
			[
				'label'      => esc_html__( 'Table Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-main-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ce-table-scrollable-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} .ce-table-main-wrapper',
			]
		);

		$this->add_responsive_control(
			'table_wrapper_margin',
			[
				'label'      => esc_html__( 'Table Wrapper Margin', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-main-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: SWIPE HINT ---
		$this->start_controls_section(
			'section_hint_style',
			[
				'label'     => esc_html__( 'Swipe Hint Style', 'custom-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'horizontal_scroll' => 'yes',
					'show_scroll_hint'  => 'yes',
				],
			]
		);

		$this->add_control(
			'hint_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .ce-table-swipe-hint' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hint_typography',
				'selector' => '{{WRAPPER}} .ce-table-swipe-hint',
			]
		);

		$this->add_responsive_control(
			'hint_margin_top',
			[
				'label'      => esc_html__( 'Margin Top', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-table-swipe-hint' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$columns  = $settings['columns_list'];
		
		if ( empty( $columns ) ) {
			return;
		}

		$first_col_is_header = $settings['first_col_is_header'];
		$scroll_enabled      = $settings['horizontal_scroll'] === 'yes';

		// Parse table rows data based on cells_list
		$rows_data = [];
		$cells = ! empty( $settings['cells_list'] ) ? $settings['cells_list'] : [];
		$col_count = count( $columns );
		if ( $col_count > 0 ) {
			$current_row = [];
			foreach ( $cells as $cell ) {
				$current_row[] = isset( $cell['cell_content'] ) ? $cell['cell_content'] : '';
				if ( count( $current_row ) === $col_count ) {
					$rows_data[] = [ 'cells' => $current_row ];
					$current_row = [];
				}
			}
			// If there are leftover cells that didn't fill a complete row
			if ( ! empty( $current_row ) ) {
				// Pad the row with empty strings to match column count
				$current_row = array_pad( $current_row, $col_count, '' );
				$rows_data[] = [ 'cells' => $current_row ];
			}
		}
		
		?>
		<div class="ce-table-main-wrapper">
			
			<!-- Table Title / Top Header -->
			<?php if ( 'yes' === $settings['show_header'] && ! empty( $settings['header_text'] ) ) : ?>
				<div class="ce-table-title-wrap">
					<<?php echo esc_attr( $settings['header_tag'] ); ?> class="ce-table-title">
						<?php echo esc_html( $settings['header_text'] ); ?>
					</<?php echo esc_attr( $settings['header_tag'] ); ?>>
				</div>
			<?php endif; ?>

			<!-- Scrollable Container -->
			<div class="ce-table-scrollable-inner <?php echo $scroll_enabled ? 'ce-table-scroll-active' : ''; ?>">
				<table class="ce-custom-table">
					<thead>
						<tr>
							<?php foreach ( $columns as $index => $column ) : 
								$col_style = '';
								if ( ! empty( $column['col_align'] ) ) {
									$col_style .= 'text-align: ' . esc_attr( $column['col_align'] ) . ';';
								}
								?>
								<th class="ce-table-th elementor-repeater-item-<?php echo esc_attr( $column['_id'] ); ?>" style="<?php echo $col_style; ?>" data-col-index="<?php echo esc_attr( $index ); ?>">
									<span class="ce-th-content"><?php echo esc_html( $column['col_title'] ); ?></span>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $rows_data as $row_index => $row_item ) : ?>
							<tr class="ce-table-tr">
								<?php 
								$cell_values = $row_item['cells'];

								// Loop through column schema to render corresponding cell content
								foreach ( $columns as $col_index => $column ) :
									$cell_val = isset( $cell_values[$col_index] ) ? $cell_values[$col_index] : '';
									
									$cell_style = '';
									if ( ! empty( $column['col_align'] ) ) {
										$cell_style .= 'text-align: ' . esc_attr( $column['col_align'] ) . ';';
									}

									// First Column row header condition
									$is_row_header = ( 0 === $col_index && 'yes' === $first_col_is_header );

									if ( $is_row_header ) : ?>
										<th scope="row" class="ce-table-th-row elementor-repeater-item-<?php echo esc_attr( $column['_id'] ); ?>" style="<?php echo $cell_style; ?>" data-col-index="<?php echo esc_attr( $col_index ); ?>">
											<?php echo wp_kses_post( $cell_val ); ?>
										</th>
									<?php else : ?>
										<td class="ce-table-td elementor-repeater-item-<?php echo esc_attr( $column['_id'] ); ?>" style="<?php echo $cell_style; ?>" data-col-index="<?php echo esc_attr( $col_index ); ?>">
											<?php echo wp_kses_post( $cell_val ); ?>
										</td>
									<?php endif;
								endforeach;
								?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- Mobile scroll/swipe hint -->
			<?php if ( $scroll_enabled && 'yes' === $settings['show_scroll_hint'] && ! empty( $settings['scroll_hint_text'] ) ) : ?>
				<div class="ce-table-swipe-hint">
					<?php echo esc_html( $settings['scroll_hint_text'] ); ?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}
