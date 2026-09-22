<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PNS_Image_Hover_Card_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'mss_image_hover_card'; }
    public function get_title() { return __( 'Image Hover Card', 'pns-addons-for-elementor' ); }
    public function get_icon() { return 'eicon-image-rollover'; }
    public function get_categories() { return [ 'custom-elementor-category' ]; }

    protected function register_controls() {

        // ===================== CONTENT TAB =====================
        $this->start_controls_section( 'section_content', [
            'label' => __( 'Image & Content', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'image', [
            'label'   => __( 'Image', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $this->add_control( 'left_text', [
            'label'       => __( 'Left Text', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'PixelPulse Media',
            'placeholder' => __( 'Left side text', 'pns-addons-for-elementor' ),
        ] );

        $this->add_control( 'right_text', [
            'label'       => __( 'Right Text', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Email Marketing',
            'placeholder' => __( 'Right side text', 'pns-addons-for-elementor' ),
        ] );

        $this->add_control( 'bar_icon', [
            'label'   => __( 'Center Icon', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-arrow-up-right-from-square',
                'library' => 'fa-solid',
            ],
        ] );

        $this->add_control( 'link', [
            'label'       => __( 'Link (optional)', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ] );

        $this->end_controls_section();

        // ===================== STYLE TAB - Image =====================
        $this->start_controls_section( 'section_style_image', [
            'label' => __( 'Image', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Image Height', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 100, 'max' => 800 ], 'vh' => [ 'min' => 10, 'max' => 100 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 400 ],
            'selectors'  => [ '{{WRAPPER}} .mss-ihc-image-wrap' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'image_border_radius', [
            'label'      => __( 'Border Radius', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .mss-ihc-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;' ],
        ] );

        $this->add_control( 'image_scale_hover', [
            'label'     => __( 'Zoom on Hover', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __( 'Yes', 'pns-addons-for-elementor' ),
            'label_off' => __( 'No', 'pns-addons-for-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'hover_duration', [
            'label'      => __( 'Hover Transition (ms)', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 100, 'max' => 1000, 'step' => 50 ] ],
            'default'    => [ 'size' => 400 ],
            'selectors'  => [
                '{{WRAPPER}} .mss-ihc-image' => 'transition: transform {{SIZE}}ms ease;',
                '{{WRAPPER}} .mss-ihc-bar'   => 'transition: transform {{SIZE}}ms ease, opacity {{SIZE}}ms ease;',
            ],
        ] );

        $this->end_controls_section();

        // ===================== STYLE TAB - Bar =====================
        $this->start_controls_section( 'section_style_bar', [
            'label' => __( 'Hover Bar', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'bar_bg_color', [
            'label'     => __( 'Bar Background Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .mss-ihc-bar' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'bar_bg_opacity', [
            'label'     => __( 'Bar Background Opacity', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default'   => [ 'size' => 0.95 ],
            'selectors' => [ '{{WRAPPER}} .mss-ihc-bar' => 'background-color: rgba(255,255,255, {{SIZE}});' ],
        ] );

        $this->add_responsive_control( 'bar_padding', [
            'label'      => __( 'Bar Padding', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => 14, 'right' => 20, 'bottom' => 14, 'left' => 20, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .mss-ihc-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_control( 'bar_position', [
            'label'   => __( 'Bar Position', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'bottom',
            'options' => [
                'bottom' => __( 'Bottom', 'pns-addons-for-elementor' ),
                'top'    => __( 'Top', 'pns-addons-for-elementor' ),
            ],
        ] );

        $this->end_controls_section();

        // ===================== STYLE TAB - Text =====================
        $this->start_controls_section( 'section_style_text', [
            'label' => __( 'Bar Text', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'left_text_color', [
            'label'     => __( 'Left Text Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => [ '{{WRAPPER}} .mss-ihc-left-text' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'left_text_typography',
            'label'    => __( 'Left Text Typography', 'pns-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .mss-ihc-left-text',
        ] );

        $this->add_control( 'right_text_color', [
            'label'     => __( 'Right Text Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#555555',
            'selectors' => [ '{{WRAPPER}} .mss-ihc-right-text' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'right_text_typography',
            'label'    => __( 'Right Text Typography', 'pns-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .mss-ihc-right-text',
        ] );

        $this->end_controls_section();

        // ===================== STYLE TAB - Icon =====================
        $this->start_controls_section( 'section_style_icon', [
            'label' => __( 'Center Icon', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .mss-ihc-icon-wrap i, {{WRAPPER}} .mss-ihc-icon-wrap svg' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important;' ],
        ] );

        $this->add_control( 'icon_bg_color', [
            'label'     => __( 'Icon Background Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#a8d000',
            'selectors' => [ '{{WRAPPER}} .mss-ihc-icon-wrap' => 'background-color: {{VALUE}} !important;' ],
        ] );

        $this->add_responsive_control( 'icon_size', [
            'label'      => __( 'Icon Size', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
            'default'    => [ 'size' => 20 ],
            'selectors'  => [
                '{{WRAPPER}} .mss-ihc-icon-wrap i'   => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .mss-ihc-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'icon_box_size', [
            'label'      => __( 'Icon Box Size', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 30, 'max' => 120 ] ],
            'default'    => [ 'size' => 52 ],
            'selectors'  => [
                '{{WRAPPER}} .mss-ihc-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'icon_border_radius', [
            'label'      => __( 'Icon Border Radius', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'size' => 50, 'unit' => '%' ],
            'selectors'  => [ '{{WRAPPER}} .mss-ihc-icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'icon_rotate', [
            'label'      => __( 'Icon Rotation', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'deg' ],
            'range'      => [ 'deg' => [ 'min' => 0, 'max' => 360, 'step' => 1 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'deg' ],
            'selectors'  => [
                '{{WRAPPER}} .mss-ihc-icon-wrap i'   => 'transform: rotate({{SIZE}}{{UNIT}});',
                '{{WRAPPER}} .mss-ihc-icon-wrap svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_control( 'icon_position', [
            'label'   => __( 'Icon Position', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'center',
            'options' => [
                'left'   => __( 'Left', 'pns-addons-for-elementor' ),
                'center' => __( 'Center', 'pns-addons-for-elementor' ),
                'right'  => __( 'Right', 'pns-addons-for-elementor' ),
            ],
        ] );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $image_url    = ! empty( $settings['image']['url'] ) ? esc_url( $settings['image']['url'] ) : '';
        $left_text    = ! empty( $settings['left_text'] ) ? esc_html( $settings['left_text'] ) : '';
        $right_text   = ! empty( $settings['right_text'] ) ? esc_html( $settings['right_text'] ) : '';
        $bar_position = ! empty( $settings['bar_position'] ) ? $settings['bar_position'] : 'bottom';
        $icon_pos     = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'center';
        $zoom         = isset( $settings['image_scale_hover'] ) ? $settings['image_scale_hover'] : 'yes';

        $wrapper_class = 'mss-ihc-wrapper mss-ihc-bar-' . esc_attr( $bar_position );
        if ( $zoom === 'yes' ) {
            $wrapper_class .= ' mss-ihc-zoom';
        }

        $has_link = ! empty( $settings['link']['url'] );
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <?php if ( $has_link ) : ?>
                <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="mss-ihc-link"<?php if ( ! empty( $settings['link']['is_external'] ) ) : ?> target="_blank"<?php endif; ?><?php if ( ! empty( $settings['link']['nofollow'] ) ) : ?> rel="nofollow"<?php endif; ?>>
            <?php endif; ?>
            <div class="mss-ihc-image-wrap">
                
                <div class="mss-ihc-image"<?php if ( $image_url ) : ?> style="background-image: url('<?php echo esc_url( $image_url ); ?>');"<?php endif; ?>></div>

                <!-- Icon centered in the image -->
                <div class="mss-ihc-center-icon">
                    <span class="mss-ihc-icon-wrap">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['bar_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                </div>

                <!-- Bar at bottom/top -->
                <div class="mss-ihc-bar">
                    <span class="mss-ihc-left-text"><?php echo esc_html( $left_text ); ?></span>
                    <span class="mss-ihc-right-text"><?php echo esc_html( $right_text ); ?></span>
                </div>

            </div>
            <?php if ( $has_link ) : ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }
}

