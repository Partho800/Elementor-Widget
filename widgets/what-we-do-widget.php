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

class Custom_What_We_Do_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_what_we_do_widget';
	}

	public function get_title() {
		return esc_html__( 'What We Do Section', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'business', 'feature', 'card', 'what we do', 'about', 'custom' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: FEATURE CARDS (LEFT GRID) ---
		$this->start_controls_section(
			'section_cards_content',
			[
				'label' => esc_html__( 'Feature Cards (Left Grid)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_cards = new Repeater();

		$repeater_cards->add_control(
			'card_icon',
			[
				'label'   => esc_html__( 'Icon', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-coins',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater_cards->add_control(
			'card_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#5eead4',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ce-card-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater_cards->add_control(
			'card_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ce-card-icon-box' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .ce-card-icon-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater_cards->add_control(
			'card_title',
			[
				'label'       => esc_html__( 'Title', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Financial Investment', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_cards->add_control(
			'card_desc',
			[
				'label'   => esc_html__( 'Description', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip commodo.', 'custom-elementor-widgets' ),
				'rows'    => 3,
			]
		);

		$repeater_cards->add_control(
			'card_link',
			[
				'label'       => esc_html__( 'Link', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'custom-elementor-widgets' ),
				'default'     => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'feature_cards',
			[
				'label'       => esc_html__( 'Cards List', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_cards->get_controls(),
				'default'     => [
					[
						'card_title'      => esc_html__( 'Financial Investment', 'custom-elementor-widgets' ),
						'card_desc'       => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip commodo.', 'custom-elementor-widgets' ),
						'card_icon'       => [ 'value' => 'fas fa-coins', 'library' => 'fa-solid' ],
						'card_icon_bg'    => '#5eead4',
						'card_icon_color' => '#ffffff',
					],
					[
						'card_title'      => esc_html__( 'Strategic Guidance', 'custom-elementor-widgets' ),
						'card_desc'       => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip commodo.', 'custom-elementor-widgets' ),
						'card_icon'       => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
						'card_icon_bg'    => '#a78bfa',
						'card_icon_color' => '#ffffff',
					],
					[
						'card_title'      => esc_html__( 'Exit Strategy', 'custom-elementor-widgets' ),
						'card_desc'       => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip commodo.', 'custom-elementor-widgets' ),
						'card_icon'       => [ 'value' => 'fas fa-cogs', 'library' => 'fa-solid' ],
						'card_icon_bg'    => '#a78bfa',
						'card_icon_color' => '#ffffff',
					],
					[
						'card_title'      => esc_html__( 'Advising Startups', 'custom-elementor-widgets' ),
						'card_desc'       => esc_html__( 'Quis nostrud exercitation ullamco laboris nisi ut aliquip commodo.', 'custom-elementor-widgets' ),
						'card_icon'       => [ 'value' => 'fas fa-home', 'library' => 'fa-solid' ],
						'card_icon_bg'    => '#5eead4',
						'card_icon_color' => '#ffffff',
					],
				],
				'title_field' => '{{{ card_title }}}',
			]
		);

		$this->add_responsive_control(
			'right_column_offset',
			[
				'label'      => esc_html__( 'Right Column Offset (Top/Bottom)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -150,
						'max'  => 150,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-cards-col-right' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'left_column_offset',
			[
				'label'      => esc_html__( 'Left Column Offset (Top/Bottom)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -150,
						'max'  => 150,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-cards-col-left' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'cards_vertical_gap',
			[
				'label'      => esc_html__( 'Card Vertical Space', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 80,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-cards-col' => 'gap: {{SIZE}}{{UNIT}};',
				],
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
				'default'     => esc_html__( 'WHAT WE DO', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Main Heading', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Always ready to invest in any business', 'custom-elementor-widgets' ),
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
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod diti tempor incididunt ut labore et dolore magna aliqua.', 'custom-elementor-widgets' ),
				'rows'    => 4,
			]
		);

		$this->end_controls_section();


		// --- SECTION: CHECKLIST CONTENT ---
		$this->start_controls_section(
			'section_checklist_content',
			[
				'label' => esc_html__( 'Checklist Section', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'checklist_title',
			[
				'label'       => esc_html__( 'Checklist Subheading', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'How we help your business', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_checklist = new Repeater();

		$repeater_checklist->add_control(
			'item_text',
			[
				'label'       => esc_html__( 'Item Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Stage-focused investing', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater_checklist->add_control(
			'item_icon',
			[
				'label'   => esc_html__( 'Item Icon', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'checklist_items',
			[
				'label'       => esc_html__( 'Checklist Items', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_checklist->get_controls(),
				'default'     => [
					[ 'item_text' => esc_html__( 'Stage-focused investing', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Sector specialization', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Active involvement', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Portfolio diversification', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Achieving a return', 'custom-elementor-widgets' ) ],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: IMAGES CONTENT ---
		$this->start_controls_section(
			'section_images_content',
			[
				'label' => esc_html__( 'Visual Media / Images', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'primary_media_type',
			[
				'label'   => esc_html__( 'Primary Media Type', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'custom-elementor-widgets' ),
					'video' => esc_html__( 'Video', 'custom-elementor-widgets' ),
				],
				'default' => 'image',
			]
		);

		$this->add_control(
			'primary_image',
			[
				'label'     => esc_html__( 'Primary Image', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'primary_media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'primary_video_source',
			[
				'label'     => esc_html__( 'Video Source', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'external'    => esc_html__( 'External URL (YouTube/Vimeo)', 'custom-elementor-widgets' ),
					'self_hosted' => esc_html__( 'Self Hosted (Upload Video)', 'custom-elementor-widgets' ),
				],
				'default'   => 'external',
				'condition' => [
					'primary_media_type' => 'video',
				],
			]
		);

		$this->add_control(
			'primary_video_url',
			[
				'label'       => esc_html__( 'Video URL', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. https://www.youtube.com/watch?v=XHOmBV4js_E', 'custom-elementor-widgets' ),
				'label_block' => true,
				'condition'   => [
					'primary_media_type'   => 'video',
					'primary_video_source' => 'external',
				],
			]
		);

		$this->add_control(
			'primary_video_file',
			[
				'label'      => esc_html__( 'Upload Video File', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => [
					'primary_media_type'   => 'video',
					'primary_video_source' => 'self_hosted',
				],
			]
		);

		$this->add_control(
			'primary_video_poster',
			[
				'label'     => esc_html__( 'Video Poster/Thumbnail Image', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'primary_media_type' => 'video',
				],
			]
		);

		$this->add_control(
			'show_overlay_image',
			[
				'label'        => esc_html__( 'Show Overlay Circular Image', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'overlay_image',
			[
				'label'     => esc_html__( 'Overlay Circular Image', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'show_overlay_image' => 'yes',
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
				'default'     => esc_html__( 'Read More', 'custom-elementor-widgets' ),
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

		// --- STYLE: FEATURE CARDS ---
		$this->start_controls_section(
			'section_cards_style',
			[
				'label' => esc_html__( 'Feature Cards (Left Grid)', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'cards_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-cards-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Card Normal Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[
				'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-card-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .ce-card-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .ce-card-item',
			]
		);

		$this->end_controls_tab();

		// Card Hover Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[
				'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'card_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-card-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-card-item:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_hover_border',
				'selector' => '{{WRAPPER}} .ce-card-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '30', 'right' => '24', 'bottom' => '30', 'left' => '24', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-card-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-card-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Icon Box Styling
		$this->add_control(
			'heading_icon_box_style',
			[
				'label'     => esc_html__( 'Icon Box Settings', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label'      => esc_html__( 'Box Width/Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 30, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 56 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-card-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Font Size', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-card-icon-box' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ce-card-icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_border_radius',
			[
				'label'      => esc_html__( 'Box Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '14', 'right' => '14', 'bottom' => '14', 'left' => '14', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-card-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Card Typography & Colors
		$this->add_control(
			'heading_card_text_style',
			[
				'label'     => esc_html__( 'Card Titles & Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a202c',
				'selectors' => [
					'{{WRAPPER}} .ce-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => [
					'{{WRAPPER}} .ce-card-item:hover .ce-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .ce-card-title',
			]
		);

		$this->add_control(
			'card_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#718096',
				'selectors' => [
					'{{WRAPPER}} .ce-card-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_desc_typography',
				'selector' => '{{WRAPPER}} .ce-card-desc',
			]
		);

		$this->end_controls_section();


		// --- STYLE: SECTION HEADER ---
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Section Header Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subheading Style
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
					'{{WRAPPER}} .ce-subheading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'selector' => '{{WRAPPER}} .ce-subheading',
			]
		);

		$this->add_responsive_control(
			'subheading_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-subheading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Main Heading Style
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
					'{{WRAPPER}} .ce-main-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ce-main-heading',
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-main-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Main Description Style
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
					'{{WRAPPER}} .ce-main-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ce-main-desc',
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-main-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: CHECKLIST ---
		$this->start_controls_section(
			'section_checklist_style',
			[
				'label' => esc_html__( 'Checklist Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'checklist_heading_color',
			[
				'label'     => esc_html__( 'Subheading Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .ce-checklist-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'checklist_heading_typography',
				'selector' => '{{WRAPPER}} .ce-checklist-title',
			]
		);

		$this->add_control(
			'checklist_item_color',
			[
				'label'     => esc_html__( 'Item Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .ce-checklist-item' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'checklist_item_typography',
				'selector' => '{{WRAPPER}} .ce-checklist-item',
			]
		);

		$this->add_control(
			'checklist_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => [
					'{{WRAPPER}} .ce-check-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-check-icon svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'checklist_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(139, 92, 246, 0.12)',
				'selectors' => [
					'{{WRAPPER}} .ce-check-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'checklist_item_spacing',
			[
				'label'      => esc_html__( 'Item Spacing', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-checklist-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: IMAGES COMPOSITION ---
		$this->start_controls_section(
			'section_images_style',
			[
				'label' => esc_html__( 'Images Composition', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Primary Image Style
		$this->add_control(
			'heading_primary_img_style',
			[
				'label' => esc_html__( 'Primary Image', 'custom-elementor-widgets' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'primary_img_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-main-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'primary_img_shadow',
				'selector' => '{{WRAPPER}} .ce-main-image-wrap',
			]
		);

		// Play Button Style Controls
		$this->add_control(
			'heading_play_btn_style',
			[
				'label'     => esc_html__( 'Play Button Style (Video)', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'primary_media_type' => 'video',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_play_btn_style', [
			'condition' => [
				'primary_media_type' => 'video',
			],
		] );

		// Normal Tab
		$this->start_controls_tab(
			'tab_play_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'play_btn_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_btn_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-play-btn svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_play_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'play_btn_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-main-image-wrap:hover .ce-process-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_btn_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-main-image-wrap:hover .ce-process-play-btn svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Overlay Image Style
		$this->add_control(
			'heading_overlay_img_style',
			[
				'label'     => esc_html__( 'Overlay Circular Image', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'overlay_img_size',
			[
				'label'      => esc_html__( 'Image Size (Width & Height)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 200 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 96 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-overlay-image-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'overlay_img_bottom',
			[
				'label'      => esc_html__( 'Offset Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -100, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -24 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-overlay-image-wrap' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'overlay_img_right',
			[
				'label'      => esc_html__( 'Offset Right', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -100, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -20 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-overlay-image-wrap' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_control(
			'overlay_img_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-overlay-image-wrap' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'overlay_img_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-overlay-image-wrap' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'overlay_img_shadow',
				'selector'  => '{{WRAPPER}} .ce-overlay-image-wrap',
				'condition' => [ 'show_overlay_image' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// --- STYLE: BUTTON ---
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .ce-button',
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
					'{{WRAPPER}} .ce-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ce-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .ce-button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ce-button',
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
					'{{WRAPPER}} .ce-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ce-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_hover_border',
				'selector' => '{{WRAPPER}} .ce-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-button:hover',
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
					'{{WRAPPER}} .ce-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'top' => '14', 'right' => '32', 'bottom' => '14', 'left' => '32', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$heading_tag = ! empty( $settings['heading_tag'] ) ? esc_html( $settings['heading_tag'] ) : 'h2';
		?>

		<div class="ce-what-we-do-section">
			<div class="ce-what-we-do-row">

				<!-- Left Column: Feature Cards Grid -->
				<div class="ce-col-left">
					<?php if ( ! empty( $settings['feature_cards'] ) ) : 
						$odd_cards  = [];
						$even_cards = [];
						foreach ( $settings['feature_cards'] as $index => $card ) {
							if ( $index % 2 === 0 ) {
								$odd_cards[] = [ 'index' => $index, 'card' => $card ];
							} else {
								$even_cards[] = [ 'index' => $index, 'card' => $card ];
							}
						}
					?>
						<div class="ce-cards-grid">
							<!-- Left Column Cards (Card 1, Card 3, etc.) -->
							<div class="ce-cards-col ce-cards-col-left">
								<?php foreach ( $odd_cards as $item_data ) : 
									$index = $item_data['index'];
									$card  = $item_data['card'];
									$repeater_setting_key = $this->get_repeater_setting_key( 'card_title', 'feature_cards', $index );
									$this->add_inline_editing_attributes( $repeater_setting_key, 'none' );
									
									$link_url = ! empty( $card['card_link']['url'] ) ? $card['card_link']['url'] : '';
									$target   = ! empty( $card['card_link']['is_external'] ) ? ' target="_blank"' : '';
									$nofollow = ! empty( $card['card_link']['nofollow'] ) ? ' rel="nofollow"' : '';
								?>
									<div class="ce-card-item elementor-repeater-item-<?php echo esc_attr( $card['_id'] ); ?>">
										<div class="ce-card-icon-box">
											<?php \Elementor\Icons_Manager::render_icon( $card['card_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>

										<?php if ( $link_url ) : ?>
											<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $target . $nofollow; ?> style="text-decoration: none;">
										<?php endif; ?>

										<h3 class="ce-card-title" <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
											<?php echo esc_html( $card['card_title'] ); ?>
										</h3>

										<?php if ( $link_url ) : ?>
											</a>
										<?php endif; ?>

										<?php if ( ! empty( $card['card_desc'] ) ) : ?>
											<p class="ce-card-desc">
												<?php echo esc_html( $card['card_desc'] ); ?>
											</p>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>

							<!-- Right Column Cards (Card 2, Card 4, etc.) -->
							<div class="ce-cards-col ce-cards-col-right">
								<?php foreach ( $even_cards as $item_data ) : 
									$index = $item_data['index'];
									$card  = $item_data['card'];
									$repeater_setting_key = $this->get_repeater_setting_key( 'card_title', 'feature_cards', $index );
									$this->add_inline_editing_attributes( $repeater_setting_key, 'none' );
									
									$link_url = ! empty( $card['card_link']['url'] ) ? $card['card_link']['url'] : '';
									$target   = ! empty( $card['card_link']['is_external'] ) ? ' target="_blank"' : '';
									$nofollow = ! empty( $card['card_link']['nofollow'] ) ? ' rel="nofollow"' : '';
								?>
									<div class="ce-card-item elementor-repeater-item-<?php echo esc_attr( $card['_id'] ); ?>">
										<div class="ce-card-icon-box">
											<?php \Elementor\Icons_Manager::render_icon( $card['card_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>

										<?php if ( $link_url ) : ?>
											<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $target . $nofollow; ?> style="text-decoration: none;">
										<?php endif; ?>

										<h3 class="ce-card-title" <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
											<?php echo esc_html( $card['card_title'] ); ?>
										</h3>

										<?php if ( $link_url ) : ?>
											</a>
										<?php endif; ?>

										<?php if ( ! empty( $card['card_desc'] ) ) : ?>
											<p class="ce-card-desc">
												<?php echo esc_html( $card['card_desc'] ); ?>
											</p>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right Column: Content Area -->
				<div class="ce-col-right">
					<div class="ce-right-content">

						<!-- Subheading -->
						<?php if ( ! empty( $settings['subheading'] ) ) : ?>
							<span class="ce-subheading">
								<?php echo esc_html( $settings['subheading'] ); ?>
							</span>
						<?php endif; ?>

						<!-- Main Heading -->
						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<<?php echo $heading_tag; ?> class="ce-main-heading">
								<?php echo esc_html( $settings['heading'] ); ?>
							</<?php echo $heading_tag; ?>>
						<?php endif; ?>

						<!-- Description -->
						<?php if ( ! empty( $settings['description'] ) ) : ?>
							<p class="ce-main-desc">
								<?php echo esc_html( $settings['description'] ); ?>
							</p>
						<?php endif; ?>

						<!-- Sub-feature Checklist & Image Split -->
						<div class="ce-details-split">

							<!-- Checklist Column -->
							<div class="ce-checklist-col">
								<?php if ( ! empty( $settings['checklist_title'] ) ) : ?>
									<h4 class="ce-checklist-title">
										<?php echo esc_html( $settings['checklist_title'] ); ?>
									</h4>
								<?php endif; ?>

								<?php if ( ! empty( $settings['checklist_items'] ) ) : ?>
									<ul class="ce-checklist">
										<?php foreach ( $settings['checklist_items'] as $item ) : ?>
											<li class="ce-checklist-item">
												<span class="ce-check-icon">
													<?php 
													if ( ! empty( $item['item_icon']['value'] ) ) {
														\Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] );
													} else {
														echo '<i class="fas fa-check"></i>';
													}
													?>
												</span>
												<?php echo esc_html( $item['item_text'] ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>

							<!-- Images Column -->
							<?php 
							$primary_media_type = ! empty( $settings['primary_media_type'] ) ? $settings['primary_media_type'] : 'image';
							$has_primary_image = ! empty( $settings['primary_image']['url'] );
							$has_video_poster = ! empty( $settings['primary_video_poster']['url'] );
							
							if ( ( 'image' === $primary_media_type && $has_primary_image ) || 'video' === $primary_media_type ) : 
							?>
								<div class="ce-media-col">
									<?php if ( 'video' === $primary_media_type ) : 
										$poster_src = $has_video_poster ? $settings['primary_video_poster']['url'] : ( $has_primary_image ? $settings['primary_image']['url'] : Utils::get_placeholder_image_src() );
										$video_source = ! empty( $settings['primary_video_source'] ) ? $settings['primary_video_source'] : 'external';
										$video_url = '';
										
										if ( 'external' === $video_source ) {
											$video_url = ! empty( $settings['primary_video_url'] ) ? $settings['primary_video_url'] : '';
										} else {
											$video_url = ! empty( $settings['primary_video_file']['url'] ) ? $settings['primary_video_file']['url'] : '';
										}
									?>
										<div class="ce-main-image-wrap ce-process-video-trigger" data-media-type="video" data-video-source="<?php echo esc_attr( $video_source ); ?>" data-video-url="<?php echo esc_url( $video_url ); ?>" style="cursor: pointer; position: relative;">
											<img src="<?php echo esc_url( $poster_src ); ?>" alt="<?php echo esc_attr( $settings['heading'] ); ?>" />
											<div class="ce-process-play-btn">
												<svg viewBox="0 0 24 24" width="28" height="28">
													<path fill="#ffffff" d="M8 5v14l11-7z"/>
												</svg>
											</div>
										</div>
									<?php else : ?>
										<div class="ce-main-image-wrap" data-media-type="image">
											<img src="<?php echo esc_url( $settings['primary_image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['heading'] ); ?>" />
										</div>
									<?php endif; ?>

									<?php if ( 'yes' === $settings['show_overlay_image'] && ! empty( $settings['overlay_image']['url'] ) ) : ?>
										<div class="ce-overlay-image-wrap">
											<img src="<?php echo esc_url( $settings['overlay_image']['url'] ); ?>" alt="Overlay" />
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>

						<!-- Button -->
						<?php if ( ! empty( $settings['button_text'] ) ) : 
							$btn_url = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
							$btn_target = ! empty( $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
							$btn_nofollow = ! empty( $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
						?>
							<div class="ce-button-wrap">
								<a href="<?php echo esc_url( $btn_url ); ?>" class="ce-button"<?php echo $btn_target . $btn_nofollow; ?>>
									<?php if ( 'before' === $settings['button_icon_position'] && ! empty( $settings['button_icon']['value'] ) ) : ?>
										<span class="ce-button-icon style-before">
											<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $settings['button_text'] ); ?></span>

									<?php if ( 'after' === $settings['button_icon_position'] && ! empty( $settings['button_icon']['value'] ) ) : ?>
										<span class="ce-button-icon style-after">
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

		<div class="ce-video-lightbox">
			<div class="ce-video-lightbox-overlay"></div>
			<div class="ce-video-lightbox-content">
				<span class="ce-video-lightbox-close">&times;</span>
				<div class="ce-video-lightbox-container"></div>
			</div>
		</div>

		<script>
		jQuery(document).ready(function($) {
			if (!window.ceVideoLightboxInitialized) {
				window.ceVideoLightboxInitialized = true;
				
				// Attach click listener for video triggers
				$(document).on('click', '.ce-process-video-trigger', function(e) {
					e.preventDefault();
					const $trigger = $(this);
					const videoSource = $trigger.attr('data-video-source');
					const videoUrl = $trigger.attr('data-video-url');

					if (!videoUrl) return;

					const $lightbox = $('.ce-video-lightbox');
					const $container = $lightbox.find('.ce-video-lightbox-container');
					$container.empty();

					if (videoSource === 'external') {
						let embedUrl = '';
						if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be') || videoUrl.includes('youtube-nocookie.com')) {
							let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\/shorts\/)([^#\&\?]*).*/;
							let match = videoUrl.match(regExp);
							if (match && match[2].length === 11) {
								embedUrl = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&rel=0';
							}
						} else if (videoUrl.includes('vimeo.com')) {
							let regExp = /vimeo\.com\/(?:video\/)?([0-9]+)/;
							let match = videoUrl.match(regExp);
							if (match) {
								embedUrl = 'https://player.vimeo.com/video/' + match[1] + '?autoplay=1';
							}
						}

						if (embedUrl) {
							$container.html(`<iframe src="${embedUrl}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`);
						} else if (videoUrl.match(/\.(mp4|webm|ogg|ogv)($|\?)/i)) {
							$container.html(`<video src="${videoUrl}" controls autoplay style="width:100%; height:100%; object-fit:contain;"></video>`);
						} else {
							$container.html(`<iframe src="${videoUrl}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`);
						}
					} else if (videoSource === 'self_hosted') {
						$container.html(`<video src="${videoUrl}" controls autoplay style="width:100%; height:100%; object-fit:contain;"></video>`);
					}

					$lightbox.addClass('ce-active');
					$('body').css('overflow', 'hidden');
				});

				// Close lightbox listeners
				$(document).on('click', '.ce-video-lightbox-close, .ce-video-lightbox-overlay', function() {
					const $lightbox = $('.ce-video-lightbox');
					$lightbox.removeClass('ce-active');
					$lightbox.find('.ce-video-lightbox-container').empty();
					$('body').css('overflow', '');
				});

				// Close on ESC keypress
				$(document).on('keydown', function(e) {
					if (e.key === 'Escape') {
						const $lightbox = $('.ce-video-lightbox');
						if ($lightbox.hasClass('ce-active')) {
							$lightbox.removeClass('ce-active');
							$lightbox.find('.ce-video-lightbox-container').empty();
							$('body').css('overflow', '');
						}
					}
				});
			}
		});
		</script>

		<?php
	}
}
