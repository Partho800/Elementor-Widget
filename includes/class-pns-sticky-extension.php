<?php
/**
 * PNS Addons for Elementor - Sticky Extension
 *
 * Adds advanced Sticky / Floating options to all Elementor Sections, Containers, Columns, and Widgets.
 *
 * @package PNS_Addons_For_Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PNS_Sticky_Extension {

	/**
	 * Single instance of the class
	 *
	 * @var PNS_Sticky_Extension
	 */
	private static $instance = null;

	/**
	 * Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		// Assets Enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_assets' ], 20 );

		// Register Controls on Section, Container, Column & Widgets
		add_action( 'elementor/element/after_section_end', [ $this, 'register_sticky_controls' ], 10, 3 );

		// Render Attributes
		add_action( 'elementor/frontend/before_render', [ $this, 'before_render' ], 10, 1 );
	}

	/**
	 * Enqueue Styles and Scripts
	 */
	public function enqueue_assets() {
		$css_path = PNS_ADDONS_FOR_ELEMENTOR_PATH . 'assets/css/pns-sticky-extension.css';
		$css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : PNS_ADDONS_FOR_ELEMENTOR_VERSION;

		$js_path  = PNS_ADDONS_FOR_ELEMENTOR_PATH . 'assets/js/pns-sticky-extension.js';
		$js_ver   = file_exists( $js_path ) ? filemtime( $js_path ) : PNS_ADDONS_FOR_ELEMENTOR_VERSION;

		// Register and Enqueue CSS
		wp_register_style(
			'pns-sticky-extension-style',
			plugins_url( 'assets/css/pns-sticky-extension.css', PNS_ADDONS_FOR_ELEMENTOR_FILE ),
			[],
			$css_ver
		);
		wp_enqueue_style( 'pns-sticky-extension-style' );

		// Register and Enqueue JS
		wp_register_script(
			'pns-sticky-extension-script',
			plugins_url( 'assets/js/pns-sticky-extension.js', PNS_ADDONS_FOR_ELEMENTOR_FILE ),
			[ 'jquery' ],
			$js_ver,
			true
		);
		wp_enqueue_script( 'pns-sticky-extension-script' );
	}

	/**
	 * Register PNS Sticky controls in Advanced tab
	 *
	 * @param \Elementor\Element_Base $element
	 * @param string                  $section_id
	 * @param array                   $args
	 */
	public function register_sticky_controls( $element, $section_id, $args ) {
		// Inject right after Motion Effects ('section_effects'), or fallback to '_section_responsive'
		if ( 'section_effects' !== $section_id && '_section_responsive' !== $section_id ) {
			return;
		}

		// Prevent duplicate registration on the same element
		if ( $element->get_controls( 'pns_sticky' ) ) {
			return;
		}

		$element->start_controls_section(
			'pns_section_sticky',
			[
				'label' => esc_html__( 'PNS Sticky', 'pns-addons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'pns_sticky',
			[
				'label'              => esc_html__( 'Sticky', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SELECT,
				'options'            => [
					''       => esc_html__( 'None', 'pns-addons-for-elementor' ),
					'top'    => esc_html__( 'Top', 'pns-addons-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'pns-addons-for-elementor' ),
				],
				'default'            => '',
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'pns_sticky_on',
			[
				'label'              => esc_html__( 'Sticky On', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SELECT2,
				'multiple'           => true,
				'label_block'        => true,
				'default'            => [ 'desktop', 'tablet', 'mobile' ],
				'options'            => [
					'desktop' => esc_html__( 'Desktop', 'pns-addons-for-elementor' ),
					'tablet'  => esc_html__( 'Tablet', 'pns-addons-for-elementor' ),
					'mobile'  => esc_html__( 'Mobile', 'pns-addons-for-elementor' ),
				],
				'condition'          => [
					'pns_sticky!' => '',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_responsive_control(
			'pns_sticky_offset',
			[
				'label'              => esc_html__( 'Offset (Top)', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'default'            => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'          => [
					'pns_sticky' => 'top',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_responsive_control(
			'pns_sticky_offset_bottom',
			[
				'label'              => esc_html__( 'Offset (Bottom)', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'default'            => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'          => [
					'pns_sticky' => 'bottom',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_responsive_control(
			'pns_sticky_effects_offset',
			[
				'label'              => esc_html__( 'Effects Offset (px)', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'default'            => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'          => [
					'pns_sticky!' => '',
				],
				'description'        => esc_html__( 'Distance scrolled before sticky styles (background, shadow, shrink) take effect.', 'pns-addons-for-elementor' ),
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'pns_sticky_scroll_up',
			[
				'label'              => esc_html__( 'Sticky On Scroll Up Only', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'          => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value'       => 'yes',
				'default'            => '',
				'condition'          => [
					'pns_sticky' => 'top',
				],
				'description'        => esc_html__( 'Hides section when scrolling down, reveals smoothly when scrolling up.', 'pns-addons-for-elementor' ),
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'pns_sticky_stay_in_parent',
			[
				'label'              => esc_html__( 'Stay In Column/Container', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'          => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value'       => 'yes',
				'default'            => '',
				'condition'          => [
					'pns_sticky!' => '',
				],
				'description'        => esc_html__( 'Element will not scroll past its parent column or section bottom.', 'pns-addons-for-elementor' ),
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'pns_sticky_z_index',
			[
				'label'              => esc_html__( 'Z-Index', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 999999,
				'step'               => 1,
				'default'            => 999,
				'condition'          => [
					'pns_sticky!' => '',
				],
				'selectors'          => [
					'{{WRAPPER}}.pns-sticky-fixed, {{WRAPPER}}.pns-sticky-active' => 'z-index: {{VALUE}} !important;',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'pns_sticky_in_editor',
			[
				'label'              => esc_html__( 'Preview In Editor', 'pns-addons-for-elementor' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off'          => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'condition'          => [
					'pns_sticky!' => '',
				],
				'description'        => esc_html__( 'Preview the sticky effect directly inside the Elementor editor.', 'pns-addons-for-elementor' ),
				'frontend_available' => true,
			]
		);

		// --- Heading for Sticky Active Styles ---
		$element->add_control(
			'pns_sticky_heading_styles',
			[
				'label'     => esc_html__( 'Sticky Active Styles', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pns_sticky!' => '',
				],
			]
		);

		$element->add_control(
			'pns_sticky_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'pns-addons-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'pns_sticky!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.pns-sticky-active' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'pns_sticky_box_shadow',
				'selector'  => '{{WRAPPER}}.pns-sticky-active',
				'condition' => [
					'pns_sticky!' => '',
				],
			]
		);

		$element->add_control(
			'pns_sticky_blur',
			[
				'label'      => esc_html__( 'Frosted Glass (Backdrop Blur)', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					],
				],
				'condition'  => [
					'pns_sticky!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}}.pns-sticky-active' => 'backdrop-filter: blur({{SIZE}}px) !important; -webkit-backdrop-filter: blur({{SIZE}}px) !important;',
				],
			]
		);

		$element->add_responsive_control(
			'pns_sticky_padding',
			[
				'label'      => esc_html__( 'Sticky Padding', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'condition'  => [
					'pns_sticky!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}}.pns-sticky-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$element->add_control(
			'pns_sticky_transition',
			[
				'label'      => esc_html__( 'Transition Duration (s)', 'pns-addons-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2.0,
						'step' => 0.1,
					],
				],
				'default'    => [
					'size' => 0.35,
				],
				'condition'  => [
					'pns_sticky!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}}.pns-sticky-element' => 'transition: background-color {{SIZE}}s ease, box-shadow {{SIZE}}s ease, padding {{SIZE}}s ease, transform {{SIZE}}s ease, top {{SIZE}}s ease, backdrop-filter {{SIZE}}s ease !important;',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Before Render hook to inject wrapper class & data attribute
	 *
	 * @param \Elementor\Element_Base $element
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();
		$sticky   = ! empty( $settings['pns_sticky'] ) ? $settings['pns_sticky'] : '';

		if ( empty( $sticky ) || 'none' === $sticky ) {
			return;
		}

		$sticky_on = ! empty( $settings['pns_sticky_on'] ) ? $settings['pns_sticky_on'] : [ 'desktop', 'tablet', 'mobile' ];
		if ( is_string( $sticky_on ) ) {
			$sticky_on = [ $sticky_on ];
		}

		$config = [
			'sticky'               => $sticky,
			'stickyOn'             => $sticky_on,
			'offsetTop'            => ( isset( $settings['pns_sticky_offset']['size'] ) && '' !== $settings['pns_sticky_offset']['size'] ) ? (float) $settings['pns_sticky_offset']['size'] : 0,
			'offsetTopTablet'      => ( isset( $settings['pns_sticky_offset_tablet']['size'] ) && '' !== $settings['pns_sticky_offset_tablet']['size'] ) ? (float) $settings['pns_sticky_offset_tablet']['size'] : null,
			'offsetTopMobile'      => ( isset( $settings['pns_sticky_offset_mobile']['size'] ) && '' !== $settings['pns_sticky_offset_mobile']['size'] ) ? (float) $settings['pns_sticky_offset_mobile']['size'] : null,
			'offsetBottom'         => ( isset( $settings['pns_sticky_offset_bottom']['size'] ) && '' !== $settings['pns_sticky_offset_bottom']['size'] ) ? (float) $settings['pns_sticky_offset_bottom']['size'] : 0,
			'offsetBottomTablet'   => ( isset( $settings['pns_sticky_offset_bottom_tablet']['size'] ) && '' !== $settings['pns_sticky_offset_bottom_tablet']['size'] ) ? (float) $settings['pns_sticky_offset_bottom_tablet']['size'] : null,
			'offsetBottomMobile'   => ( isset( $settings['pns_sticky_offset_bottom_mobile']['size'] ) && '' !== $settings['pns_sticky_offset_bottom_mobile']['size'] ) ? (float) $settings['pns_sticky_offset_bottom_mobile']['size'] : null,
			'effectsOffset'        => ( isset( $settings['pns_sticky_effects_offset']['size'] ) && '' !== $settings['pns_sticky_effects_offset']['size'] ) ? (float) $settings['pns_sticky_effects_offset']['size'] : 0,
			'scrollUp'             => ! empty( $settings['pns_sticky_scroll_up'] ) && 'yes' === $settings['pns_sticky_scroll_up'],
			'stayInParent'         => ! empty( $settings['pns_sticky_stay_in_parent'] ) && 'yes' === $settings['pns_sticky_stay_in_parent'],
			'zIndex'               => ( isset( $settings['pns_sticky_z_index'] ) && '' !== $settings['pns_sticky_z_index'] ) ? (int) $settings['pns_sticky_z_index'] : 999,
			'inEditor'             => ! empty( $settings['pns_sticky_in_editor'] ) && 'yes' === $settings['pns_sticky_in_editor'],
		];

		$element->add_render_attribute( '_wrapper', [
			'class'                  => 'pns-sticky-element',
			'data-pns-sticky-config' => wp_json_encode( $config ),
		] );
	}
}
