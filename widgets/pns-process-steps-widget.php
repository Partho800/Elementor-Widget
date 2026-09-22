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

class PNS_Process_Steps_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_process_steps_widget';
	}

	public function get_title() {
		return esc_html__( 'Progress Timeline', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'progress', 'process', 'steps', 'timeline', 'progress timeline', 'process timeline', 'alternating', 'cards', 'workflow', 'custom' ];
	}

	public function get_style_depends() {
		return [ 'custom-process-widget-style' ];
	}

	public function get_script_depends() {
		return [ 'pns-video-lightbox' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: PROCESS STEPS REPEATER ---
		$this->start_controls_section(
			'section_process_steps',
			[
				'label' => esc_html__( 'Process Steps List', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'step_number',
			[
				'label'       => esc_html__( 'Step Number', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01.',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_title',
			[
				'label'       => esc_html__( 'Step Title', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Consultation & Assessment', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_desc',
			[
				'label'   => esc_html__( 'Step Description', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'We assess your energy needs through consultation and site evaluation to design a customized solution.', 'pns-addons-for-elementor' ),
				'rows'    => 4,
			]
		);

		$repeater->add_control(
			'step_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Learn More (Leave empty to hide)', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_btn_url',
			[
				'label'       => esc_html__( 'Button Link', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
				'default'     => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'label_block' => true,
				'condition'   => [
					'step_btn_text!' => '',
				],
			]
		);

		$repeater->add_control(
			'step_media_type',
			[
				'label'   => esc_html__( 'Media Type', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'pns-addons-for-elementor' ),
					'video' => esc_html__( 'Video', 'pns-addons-for-elementor' ),
				],
				'default' => 'image',
			]
		);

		$repeater->add_control(
			'step_image',
			[
				'label'     => esc_html__( 'Step Image', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'step_media_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'step_video_source',
			[
				'label'     => esc_html__( 'Video Source', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'external'    => esc_html__( 'External URL (YouTube/Vimeo)', 'pns-addons-for-elementor' ),
					'self_hosted' => esc_html__( 'Self Hosted (Upload Video)', 'pns-addons-for-elementor' ),
				],
				'default'   => 'external',
				'condition' => [
					'step_media_type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'step_video_url',
			[
				'label'       => esc_html__( 'Video URL', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. https://www.youtube.com/watch?v=XHOmBV4js_E', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => [
					'step_media_type'   => 'video',
					'step_video_source' => 'external',
				],
			]
		);

		$repeater->add_control(
			'step_video_file',
			[
				'label'      => esc_html__( 'Upload Video File', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => [
					'step_media_type'   => 'video',
					'step_video_source' => 'self_hosted',
				],
			]
		);

		$repeater->add_control(
			'step_video_poster',
			[
				'label'     => esc_html__( 'Video Poster/Thumbnail Image', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'step_media_type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'step_layout_override',
			[
				'label'   => esc_html__( 'Layout Override (Optional)', 'pns-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'auto'        => esc_html__( 'Auto Alternating', 'pns-addons-for-elementor' ),
					'image_left'  => esc_html__( 'Image Left / Card Right', 'pns-addons-for-elementor' ),
					'image_right' => esc_html__( 'Card Left / Image Right', 'pns-addons-for-elementor' ),
				],
				'default' => 'auto',
			]
		);

		$this->add_control(
			'process_steps',
			[
				'label'       => esc_html__( 'Steps Repeater', 'pns-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'step_number'     => '01.',
						'step_title'      => esc_html__( 'Consultation & Assessment', 'pns-addons-for-elementor' ),
						'step_desc'       => esc_html__( 'We assess your energy needs through consultation and site evaluation to design a customized solution.', 'pns-addons-for-elementor' ),
						'step_media_type' => 'image',
						'step_image'      => [ 'url' => Utils::get_placeholder_image_src() ],
						'step_btn_text'   => esc_html__( 'Learn More', 'pns-addons-for-elementor' ),
						'step_btn_url'    => [ 'url' => '#', 'is_external' => false, 'nofollow' => false ],
					],
					[
						'step_number'     => '02.',
						'step_title'      => esc_html__( 'System Design & Installation', 'pns-addons-for-elementor' ),
						'step_desc'       => esc_html__( 'After assessment, we design and install a customized solar system for maximum efficiency.', 'pns-addons-for-elementor' ),
						'step_media_type' => 'image',
						'step_image'      => [ 'url' => Utils::get_placeholder_image_src() ],
						'step_btn_text'   => esc_html__( 'Learn More', 'pns-addons-for-elementor' ),
						'step_btn_url'    => [ 'url' => '#', 'is_external' => false, 'nofollow' => false ],
					],
					[
						'step_number'     => '03.',
						'step_title'      => esc_html__( 'Maintenance & Monitoring', 'pns-addons-for-elementor' ),
						'step_desc'       => esc_html__( 'We ensure continuous peak performance with regular inspections, repairs, and 24/7 system tracking.', 'pns-addons-for-elementor' ),
						'step_media_type' => 'image',
						'step_image'      => [ 'url' => Utils::get_placeholder_image_src() ],
						'step_btn_text'   => esc_html__( 'Learn More', 'pns-addons-for-elementor' ),
						'step_btn_url'    => [ 'url' => '#', 'is_external' => false, 'nofollow' => false ],
					],
				],
				'title_field' => '{{{ step_number }}} {{{ step_title }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: TIMELINE CONNECTOR SETTINGS ---
		$this->start_controls_section(
			'section_connector_settings',
			[
				'label' => esc_html__( 'Timeline Connector Line Settings', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_connector',
			[
				'label'        => esc_html__( 'Show Connector Lines', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_connector_arrow',
			[
				'label'        => esc_html__( 'Show Arrow Head Pointer', 'pns-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_connector' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// --- STYLE: TEXT CONTENT CARDS ---
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Content Card Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Card Normal Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .ce-process-card',
			]
		);

		$this->end_controls_tab();

		// Card Hover Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[ 'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'card_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-process-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-card:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_hover_border',
				'selector' => '{{WRAPPER}} .ce-process-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '44', 'right' => '40', 'bottom' => '44', 'left' => '40', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP NUMBER ---
		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Step Number Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .ce-process-number',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP TITLE ---
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Step Title Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ce-process-title',
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-process-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[ 'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Hover Title Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-card:hover .ce-process-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Bottom', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP DESCRIPTION ---
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => esc_html__( 'Step Description Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .ce-process-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .ce-process-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: BUTTON ---
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .ce-process-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		// Button Normal Tab
		$this->start_controls_tab(
			'tab_button_normal',
			[ 'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .ce-process-btn',
			]
		);

		$this->end_controls_tab();

		// Button Hover Tab
		$this->start_controls_tab(
			'tab_button_hover',
			[ 'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ) ]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e04b00',
				'selectors' => [
					'{{WRAPPER}} .ce-process-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-process-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '12', 'right' => '24', 'bottom' => '12', 'left' => '24', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin_top',
			[
				'label'      => esc_html__( 'Margin Top', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-btn' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP IMAGE BOX ---
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Step Image Box & Column Width Style', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_col_width',
			[
				'label'      => esc_html__( 'Image Column Width (%)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 20, 'max' => 50 ] ],
				'default'    => [ 'unit' => '%', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-col-image' => 'flex: 0 0 {{SIZE}}%; max-width: {{SIZE}}%;',
					'{{WRAPPER}} .ce-process-connector' => 'left: calc({{SIZE}}% / 2); right: calc({{SIZE}}% / 2);',
				],
			]
		);

		$this->add_responsive_control(
			'card_col_width',
			[
				'label'      => esc_html__( 'Card Column Width (%)', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 45, 'max' => 75 ] ],
				'default'    => [ 'unit' => '%', 'size' => 56 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-col-card' => 'flex: 0 0 {{SIZE}}%; max-width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Box Height', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 180, 'max' => 600 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 285 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-image-wrap' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-image-wrap',
			]
		);

		// Play Button Style Controls
		$this->add_control(
			'heading_play_btn_style',
			[
				'label'     => esc_html__( 'Play Button Style (Video)', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_play_btn_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_play_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'play_btn_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
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
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Hover', 'pns-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'play_btn_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-image-wrap:hover .ce-process-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_btn_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-image-wrap:hover .ce-process-play-btn svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		// --- STYLE: TIMELINE CONNECTOR LINE & SPACING ---
		$this->start_controls_section(
			'section_connector_style',
			[
				'label' => esc_html__( 'Timeline Line & Row Spacing', 'pns-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Vertical Gap Between Steps', 'pns-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-steps-list' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ce-process-connector' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'connector_color',
			[
				'label'     => esc_html__( 'Connector Line Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .ce-process-connector-path' => 'stroke: {{VALUE}};',
				],
				'condition' => [
					'show_connector' => 'yes',
				],
			]
		);

		$this->add_control(
			'connector_arrow_color',
			[
				'label'     => esc_html__( 'Connector Arrow Color', 'pns-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-arrow-head' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_connector' => 'yes',
					'show_connector_arrow' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['process_steps'] ) ) {
			return;
		}

		$total_steps    = count( $settings['process_steps'] );
		$show_connector = ( 'yes' === $settings['show_connector'] );
		$show_arrow     = ( 'yes' === $settings['show_connector_arrow'] );
		?>

		<div class="ce-process-steps-section">
			<div class="ce-process-steps-list">

				<?php foreach ( $settings['process_steps'] as $index => $step ) :
					$override_dir = ! empty( $step['step_layout_override'] ) ? $step['step_layout_override'] : 'auto';
					
					// Determine alternating direction: Even index (0, 2...) = Image Left, Odd index (1, 3...) = Image Right
					if ( 'auto' === $override_dir ) {
						$row_class = ( 0 === $index % 2 ) ? 'ce-layout-image-left' : 'ce-layout-image-right';
					} elseif ( 'image_left' === $override_dir ) {
						$row_class = 'ce-layout-image-left';
					} else {
						$row_class = 'ce-layout-image-right';
					}

					$img_src = ! empty( $step['step_image']['url'] ) ? $step['step_image']['url'] : Utils::get_placeholder_image_src();

					$step_title_setting_key = $this->get_repeater_setting_key( 'step_title', 'process_steps', $index );
					$this->add_inline_editing_attributes( $step_title_setting_key, 'none' );
				?>

					<div class="ce-process-step-row <?php echo esc_attr( $row_class ); ?>">

						<!-- Image / Video Column -->
						<div class="ce-process-col-image">
							<?php 
							$media_type = ! empty( $step['step_media_type'] ) ? $step['step_media_type'] : 'image';
							if ( 'video' === $media_type ) :
								$poster_src = ! empty( $step['step_video_poster']['url'] ) ? $step['step_video_poster']['url'] : ( ! empty( $step['step_image']['url'] ) ? $step['step_image']['url'] : Utils::get_placeholder_image_src() );
								$video_source = ! empty( $step['step_video_source'] ) ? $step['step_video_source'] : 'external';
								$video_url = '';
								
								if ( 'external' === $video_source ) {
									$video_url = ! empty( $step['step_video_url'] ) ? $step['step_video_url'] : '';
								} else {
									$video_url = ! empty( $step['step_video_file']['url'] ) ? $step['step_video_file']['url'] : '';
								}
							?>
								<div class="ce-process-image-wrap ce-process-video-trigger" data-media-type="video" data-video-source="<?php echo esc_attr( $video_source ); ?>" data-video-url="<?php echo esc_url( $video_url ); ?>">
									<img src="<?php echo esc_url( $poster_src ); ?>" alt="<?php echo esc_attr( $step['step_title'] ); ?>" class="ce-process-img" />
									<div class="ce-process-play-btn">
										<svg viewBox="0 0 24 24" width="28" height="28">
											<path fill="#ffffff" d="M8 5v14l11-7z"/>
										</svg>
									</div>
								</div>
							<?php else : ?>
								<div class="ce-process-image-wrap" data-media-type="image">
									<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $step['step_title'] ); ?>" class="ce-process-img" />
								</div>
							<?php endif; ?>
						</div>

						<!-- Card Column -->
						<div class="ce-process-col-card">
							<div class="ce-process-card">

								<?php if ( ! empty( $step['step_number'] ) ) : ?>
									<span class="ce-process-number">
										<?php echo esc_html( $step['step_number'] ); ?>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $step['step_title'] ) ) : ?>
									<h3 class="ce-process-title" <?php $this->print_render_attribute_string( $step_title_setting_key ); ?>>
										<?php echo esc_html( $step['step_title'] ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( ! empty( $step['step_desc'] ) ) : ?>
									<p class="ce-process-desc">
										<?php echo esc_html( $step['step_desc'] ); ?>
									</p>
								<?php endif; ?>

								<?php if ( ! empty( $step['step_btn_text'] ) ) : 
									$btn_link_key = $this->get_repeater_setting_key( 'step_btn_url', 'process_steps', $index );
									if ( ! empty( $step['step_btn_url']['url'] ) ) {
										$this->add_link_attributes( $btn_link_key, $step['step_btn_url'] );
									} else {
										$this->add_render_attribute( $btn_link_key, 'href', '#' );
									}
								?>
									<a class="ce-process-btn" <?php $this->print_render_attribute_string( $btn_link_key ); ?>>
										<?php echo esc_html( $step['step_btn_text'] ); ?>
									</a>
								<?php endif; ?>

							</div>
						</div>

						<!-- Curved Connector SVG Line for between steps -->
						<?php if ( $show_connector && $index < ( $total_steps - 1 ) ) : 
							$is_left_to_right = ( 'ce-layout-image-left' === $row_class );
						?>
							<div class="ce-process-connector">
								<svg class="ce-process-connector-svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
									<?php if ( $is_left_to_right ) : ?>
										<!-- Curve connecting from Left Image down towards Right Image -->
										<path class="ce-process-connector-path" d="M 0,0 L 0,20 Q 0,50 30,50 L 970,50 Q 1000,50 1000,80 L 1000,100" />
									<?php else : ?>
										<!-- Curve connecting from Right Image down towards Left Image -->
										<path class="ce-process-connector-path" d="M 1000,0 L 1000,20 Q 1000,50 970,50 L 30,50 Q 0,50 0,80 L 0,100" />
									<?php endif; ?>
								</svg>
								<?php if ( $show_arrow ) : ?>
									<div class="ce-process-arrow <?php echo $is_left_to_right ? 'ce-arrow-right' : 'ce-arrow-left'; ?>">
										<svg viewBox="0 0 10 10">
											<polygon class="ce-process-arrow-head" points="2,1 8,5 2,9" />
										</svg>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>

				<?php endforeach; ?>

			</div>
		</div>

		<div class="ce-video-lightbox">
			<div class="ce-video-lightbox-overlay"></div>
			<div class="ce-video-lightbox-content">
				<span class="ce-video-lightbox-close">&times;</span>
				<div class="ce-video-lightbox-container"></div>
			</div>
		</div>

		<?php
		// Video lightbox JS is enqueued via get_script_depends() -> 'pns-video-lightbox'
		?>

		<?php
	}
}

