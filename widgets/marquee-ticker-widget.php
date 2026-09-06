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

class Custom_Marquee_Ticker_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_marquee_ticker_widget';
	}

	public function get_title() {
		return esc_html__( 'Infinite Marquee Ticker Bar', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-sync';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'marquee', 'ticker', 'scroll', 'banner', 'text', 'infinite', 'animation' ];
	}

	public function get_style_depends() {
		return [ 'custom-marquee-widget-style' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: MARQUEE ITEMS ---
		$this->start_controls_section(
			'section_marquee_items',
			[
				'label' => esc_html__( 'Ticker Items', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'       => esc_html__( 'Item Text', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Solar Panel Installation', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label'       => esc_html__( 'Item Link', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'custom-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'custom_icon',
			[
				'label'       => esc_html__( 'Custom Separator Icon (Optional)', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Overrides the global separator icon for this item.', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'ticker_items',
			[
				'label'       => esc_html__( 'Ticker Items List', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'item_text' => esc_html__( 'Efficiency Consulting', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Energy Storage', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Maintenance and Repair', 'custom-elementor-widgets' ) ],
					[ 'item_text' => esc_html__( 'Solar Panel Installation', 'custom-elementor-widgets' ) ],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: TICKER SETTINGS ---
		$this->start_controls_section(
			'section_ticker_settings',
			[
				'label' => esc_html__( 'Ticker Animation Settings', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => esc_html__( 'Scroll Direction', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'normal'  => esc_html__( 'Right to Left ⬅️', 'custom-elementor-widgets' ),
					'reverse' => esc_html__( 'Left to Right ➡️', 'custom-elementor-widgets' ),
				],
				'default' => 'normal',
			]
		);

		$this->add_responsive_control(
			'scroll_speed',
			[
				'label'       => esc_html__( 'Scroll Duration (Seconds)', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 's' ],
				'range'       => [
					's' => [ 'min' => 2, 'max' => 60 ],
				],
				'default'     => [ 'unit' => 's', 'size' => 20 ],
				'description' => esc_html__( 'Smaller value = Faster scroll speed.', 'custom-elementor-widgets' ),
				'selectors'   => [
					'{{WRAPPER}} .ce-marquee-wrapper' => 'animation-duration: {{SIZE}}s;',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause Animation on Hover', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label'        => esc_html__( 'Show Separator Icon', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'global_icon',
			[
				'label'     => esc_html__( 'Global Separator Icon', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-certificate',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_animation',
			[
				'label'     => esc_html__( 'Icon Animation Effect', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'  => esc_html__( 'None (Static)', 'custom-elementor-widgets' ),
					'spin'  => esc_html__( 'Spin / Rotation 🔄', 'custom-elementor-widgets' ),
					'pulse' => esc_html__( 'Pulse / Scale 💓', 'custom-elementor-widgets' ),
				],
				'default'   => 'spin',
				'condition' => [
					'show_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// --- STYLE: TICKER CONTAINER BAR ---
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Ticker Bar Container', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'bar_background',
				'label'    => esc_html__( 'Background', 'custom-elementor-widgets' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ce-marquee-container',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => '#ff4500',
					],
				],
			]
		);

		$this->add_responsive_control(
			'bar_padding',
			[
				'label'      => esc_html__( 'Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => '16', 'right' => '0', 'bottom' => '16', 'left' => '0', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-marquee-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'bar_tilt_angle',
			[
				'label'      => esc_html__( 'Tilt / Slant Angle (Degrees)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range'      => [
					'deg' => [ 'min' => -15, 'max' => 15 ],
				],
				'default'    => [ 'unit' => 'deg', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-marquee-container' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'bar_border',
				'selector' => '{{WRAPPER}} .ce-marquee-container',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bar_box_shadow',
				'selector' => '{{WRAPPER}} .ce-marquee-container',
			]
		);

		$this->end_controls_section();


		// --- STYLE: TEXT & ITEMS ---
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text & Item Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .ce-marquee-item',
			]
		);

		$this->start_controls_tabs( 'tabs_text_style' );

		$this->start_controls_tab(
			'tab_text_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-marquee-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_text_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'text_hover_color',
			[
				'label'     => esc_html__( 'Text Hover Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff066',
				'selectors' => [
					'{{WRAPPER}} .ce-marquee-item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_spacing',
			[
				'label'      => esc_html__( 'Item Side Padding / Space', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-marquee-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();


		// --- STYLE: SEPARATOR ICON ---
		$this->start_controls_section(
			'section_icon_style',
			[
				'label'     => esc_html__( 'Separator Icon Style', 'custom-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_icon' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-marquee-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-marquee-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff066',
				'selectors' => [
					'{{WRAPPER}} .ce-marquee-item:hover .ce-marquee-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-marquee-item:hover .ce-marquee-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-marquee-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ce-marquee-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_gap',
			[
				'label'      => esc_html__( 'Gap Between Text & Icon', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 5, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-marquee-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['ticker_items'] ) ) {
			return;
		}

		$pause_class = ( 'yes' === $settings['pause_on_hover'] ) ? ' ce-pause-on-hover' : '';
		$dir_class   = ( 'reverse' === $settings['direction'] ) ? ' ce-direction-reverse' : '';
		
		$anim_type = ! empty( $settings['icon_animation'] ) ? $settings['icon_animation'] : 'none';
		$anim_class = '';
		if ( 'spin' === $anim_type ) {
			$anim_class = ' ce-icon-spin';
		} elseif ( 'pulse' === $anim_type ) {
			$anim_class = ' ce-icon-pulse';
		}

		$show_icon = ( 'yes' === $settings['show_icon'] );
		?>

		<div class="ce-marquee-container<?php echo esc_attr( $pause_class . $dir_class . $anim_class ); ?>">
			<div class="ce-marquee-wrapper">
				
				<!-- Repeat 3 sets for 100% smooth, seamless infinite scrolling -->
				<?php for ( $loop = 0; $loop < 3; $loop++ ) : ?>
					<div class="ce-marquee-track">
						<?php foreach ( $settings['ticker_items'] as $index => $item ) :
							if ( empty( $item['item_text'] ) ) {
								continue;
							}

							$item_url = ! empty( $item['item_link']['url'] ) ? $item['item_link']['url'] : '';
							$target   = ! empty( $item['item_link']['is_external'] ) ? ' target="_blank"' : '';
							$nofollow = ! empty( $item['item_link']['nofollow'] ) ? ' rel="nofollow"' : '';
							$tag      = ! empty( $item_url ) ? 'a' : 'span';
							$href_attr = ! empty( $item_url ) ? ' href="' . esc_url( $item_url ) . '"' . $target . $nofollow : '';
						?>
							<<?php echo $tag; ?> class="ce-marquee-item"<?php echo $href_attr; ?>>
								<span class="ce-marquee-text"><?php echo esc_html( $item['item_text'] ); ?></span>

								<?php if ( $show_icon ) : ?>
									<span class="ce-marquee-icon">
										<?php 
										if ( ! empty( $item['custom_icon']['value'] ) ) {
											\Elementor\Icons_Manager::render_icon( $item['custom_icon'], [ 'aria-hidden' => 'true' ] );
										} elseif ( ! empty( $settings['global_icon']['value'] ) ) {
											\Elementor\Icons_Manager::render_icon( $settings['global_icon'], [ 'aria-hidden' => 'true' ] );
										} else {
											echo '<i class="fas fa-asterisk" aria-hidden="true"></i>';
										}
										?>
									</span>
								<?php endif; ?>
							</<?php echo $tag; ?>>
						<?php endforeach; ?>
					</div>
				<?php endfor; ?>

			</div>
		</div>

		<?php
	}
}
