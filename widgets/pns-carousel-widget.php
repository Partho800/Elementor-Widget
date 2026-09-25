<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PNS_Premium_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'mss_premium_carousel'; }
    public function get_title() { return __( 'Member', 'pns-addons-for-elementor' ); }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return [ 'pns-addons-category' ]; }

    public function get_keywords() {
        return [ 'member', 'team member', 'team', 'carousel', 'cards', 'staff', 'person', 'profile' ];
    }

    public function get_script_depends() {
        return [ 'swiper', 'pns-member-carousel' ];
    }

    public function get_style_depends() {
        return [ 'pns-slider-style', 'swiper' ];
    }

    protected function register_controls() {

        // ===================== CONTENT TAB =====================
        $this->start_controls_section( 'section_carousel_items', [
            'label' => __( 'Carousel Items', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'item_image', [
            'label'   => __( 'Image', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'item_name', [
            'label'       => __( 'Name', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'John Doe',
            'label_block' => true,
        ] );

        $repeater->add_control( 'item_short_desc', [
            'label'       => __( 'Short Description', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Web Developer',
            'label_block' => true,
        ] );

        $repeater->add_control( 'item_detailed_desc', [
            'label'       => __( 'Detailed Description (Hover)', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => 'Professional developer with over 5 years of experience in creating modern web applications.',
            'rows'        => 5,
        ] );

        // Social Links
        $repeater->add_control( 'social_icon_1', [
            'label' => __( 'Social Icon 1', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-facebook-f',
                'library' => 'fa-brands',
            ],
        ] );
        $repeater->add_control( 'social_link_1', [
            'label' => __( 'Social Link 1', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://facebook.com',
        ] );

        $repeater->add_control( 'social_icon_2', [
            'label' => __( 'Social Icon 2', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-twitter',
                'library' => 'fa-brands',
            ],
        ] );
        $repeater->add_control( 'social_link_2', [
            'label' => __( 'Social Link 2', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://twitter.com',
        ] );

        $repeater->add_control( 'social_icon_3', [
            'label' => __( 'Social Icon 3', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-linkedin-in',
                'library' => 'fa-brands',
            ],
        ] );
        $repeater->add_control( 'social_link_3', [
            'label' => __( 'Social Link 3', 'pns-addons-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://linkedin.com',
        ] );

        $this->add_control( 'carousel_items', [
            'label'       => __( 'Carousel Items', 'pns-addons-for-elementor' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'item_name' => 'Yomi Denzel',
                    'item_short_desc' => 'E-Commerce 2.0',
                ],
                [
                    'item_name' => 'Timothée Moiroux',
                    'item_short_desc' => 'Investissement Immobilier',
                ],
                [
                    'item_name' => 'David Sequiera',
                    'item_short_desc' => 'Closing',
                ],
                [
                    'item_name' => 'Manuel Ravier',
                    'item_short_desc' => 'Investissement Immobilier',
                ],
            ],
            'title_field' => '{{{ item_name }}}',
        ] );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section( 'section_carousel_settings', [
            'label' => __( 'Carousel Settings', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_responsive_control( 'slides_per_view', [
            'label'   => __( 'Slides Per View', 'pns-addons-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
            'mobile_default' => '1',
            'tablet_default' => '2',
        ] );

        $this->add_control( 'autoplay', [
            'label'     => __( 'Autoplay', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __( 'Yes', 'pns-addons-for-elementor' ),
            'label_off' => __( 'No', 'pns-addons-for-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_arrows', [
            'label'     => __( 'Show Arrows', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __( 'Yes', 'pns-addons-for-elementor' ),
            'label_off' => __( 'No', 'pns-addons-for-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_pagination', [
            'label'     => __( 'Show Pagination', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __( 'Yes', 'pns-addons-for-elementor' ),
            'label_off' => __( 'No', 'pns-addons-for-elementor' ),
            'default'   => 'yes',
        ] );

        $this->end_controls_section();

        // ===================== STYLE TAB =====================
        // General Card Style
        $this->start_controls_section( 'section_style_card', [
            'label' => __( 'Card Styling', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg_color', [
            'label'     => __( 'Card Background Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0f172a',
            'selectors' => [ '{{WRAPPER}} .mss-pc-card' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .mss-pc-card',
        ] );

        $this->add_responsive_control( 'card_height', [
            'label'      => __( 'Card Height', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [
                'px' => [ 'min' => 200, 'max' => 1000 ],
                'vh' => [ 'min' => 10, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 450, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-card' => 'height: {{SIZE}}{{UNIT}} !important;' ],
        ] );

        $this->add_control( 'glow_color', [
            'label'     => __( 'Glow Color (Hover)', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(59, 130, 246, 0.5)',
            'selectors' => [ '{{WRAPPER}} .mss-pc-card:hover' => 'border-color: {{VALUE}}; box-shadow: 0 10px 30px {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        // Typography Styling
        $this->start_controls_section( 'section_style_typography', [
            'label' => __( 'Typography', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'name_color', [
            'label'     => __( 'Name Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .mss-pc-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'name_typography',
            'label'    => __( 'Name Typography', 'pns-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .mss-pc-name',
        ] );

        $this->add_control( 'short_desc_color', [
            'label'     => __( 'Short Description Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#94a3b8',
            'selectors' => [ '{{WRAPPER}} .mss-pc-short-desc' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'short_desc_typography',
            'label'    => __( 'Short Desc Typography', 'pns-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .mss-pc-short-desc',
        ] );

        $this->end_controls_section();

        // Info Box Style
        $this->start_controls_section( 'section_style_info', [
            'label' => __( 'Info Box Styling', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'info_bg_color', [
            'label'     => __( 'Background Fade Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(15, 23, 42, 0.9)',
            'selectors' => [ '{{WRAPPER}} .mss-pc-info' => 'background: linear-gradient(to top, {{VALUE}} 0%, {{VALUE}} 40%, transparent 100%);' ],
        ] );

        $this->add_responsive_control( 'info_padding', [
            'label'      => __( 'Padding', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => 40, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        // Overlay Style
        $this->start_controls_section( 'section_style_overlay', [
            'label' => __( 'Hover Overlay', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'overlay_bg_color', [
            'label'     => __( 'Overlay Background', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(30, 41, 59, 0.9)',
            'selectors' => [ '{{WRAPPER}} .mss-pc-overlay' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'detailed_desc_color', [
            'label'     => __( 'Detailed Description Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#e2e8f0',
            'selectors' => [ '{{WRAPPER}} .mss-pc-detailed-desc' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'detailed_desc_typography',
            'label'    => __( 'Detailed Desc Typography', 'pns-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .mss-pc-detailed-desc',
        ] );

        $this->end_controls_section();

        // Social Icons Style
        $this->start_controls_section( 'section_style_social', [
            'label' => __( 'Social Icons', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'social_icon_color', [
            'label'     => __( 'Icon Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ 
                '{{WRAPPER}} .mss-pc-social-link i' => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .mss-pc-social-link svg' => 'fill: {{VALUE}} !important; color: {{VALUE}} !important;',
                '{{WRAPPER}} .mss-pc-social-link svg path' => 'fill: {{VALUE}} !important;'
            ],
        ] );

        $this->add_control( 'social_icon_bg', [
            'label'     => __( 'Icon Background', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255, 255, 255, 0.1)',
            'selectors' => [ '{{WRAPPER}} .mss-pc-social-link' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'social_icon_hover_bg', [
            'label'     => __( 'Icon Hover Background', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#3b82f6',
            'selectors' => [ '{{WRAPPER}} .mss-pc-social-link:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'social_icon_size', [
            'label'      => __( 'Icon Size', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 5, 'max' => 60 ] ],
            'default'    => [ 'size' => 16 ],
            'selectors'  => [ 
                '{{WRAPPER}} .mss-pc-social-link i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .mss-pc-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ],
        ] );

        $this->add_responsive_control( 'social_box_size', [
            'label'      => __( 'Box Size', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 40 ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-social-link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'social_icon_gap', [
            'label'      => __( 'Gap Between Icons', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'default'    => [ 'size' => 12 ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-social-links' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'social_border_radius', [
            'label'      => __( 'Border Radius', 'pns-addons-for-elementor' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'size' => 50, 'unit' => '%' ],
            'selectors'  => [ '{{WRAPPER}} .mss-pc-social-link' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        // Navigation Style (Arrows)
        $this->start_controls_section( 'section_style_navigation', [
            'label' => __( 'Navigation Arrows', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_arrows' => 'yes' ],
        ] );

        $this->add_control( 'arrow_color', [
            'label'     => __( 'Arrow Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .mss-pc-next::after, {{WRAPPER}} .mss-pc-prev::after' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'arrow_bg_color', [
            'label'     => __( 'Background Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#1e293b',
            'selectors' => [ '{{WRAPPER}} .mss-pc-next, {{WRAPPER}} .mss-pc-prev' => 'background-color: {{VALUE}} !important;' ],
        ] );

        $this->add_control( 'arrow_hover_bg', [
            'label'     => __( 'Hover Background', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#3b82f6',
            'selectors' => [ '{{WRAPPER}} .mss-pc-next:hover, {{WRAPPER}} .mss-pc-prev:hover' => 'background-color: {{VALUE}} !important;' ],
        ] );

        $this->end_controls_section();

        // Pagination Style (Dots)
        $this->start_controls_section( 'section_style_pagination', [
            'label' => __( 'Pagination Dots', 'pns-addons-for-elementor' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_pagination' => 'yes' ],
        ] );

        $this->add_control( 'dot_color', [
            'label'     => __( 'Dot Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#475569',
            'selectors' => [ '{{WRAPPER}} .mss-pc-pagination .swiper-pagination-bullet' => 'background: {{VALUE}} !important;' ],
        ] );

        $this->add_control( 'dot_active_color', [
            'label'     => __( 'Active Dot Color', 'pns-addons-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#3b82f6',
            'selectors' => [ '{{WRAPPER}} .mss-pc-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}} !important;' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['carousel_items'] ) ) {
            return;
        }
        
        $slides_per_view = isset( $settings['slides_per_view'] ) ? (int) $settings['slides_per_view'] : 4;
        $slides_mobile   = isset( $settings['slides_per_view_mobile'] ) ? (int) $settings['slides_per_view_mobile'] : 1;
        $slides_tablet   = isset( $settings['slides_per_view_tablet'] ) ? (int) $settings['slides_per_view_tablet'] : 2;

        $swiper_options = [
            'slidesPerView' => $slides_per_view,
            'spaceBetween' => 20,
            'loop' => true,
            'autoplay' => ( $settings['autoplay'] === 'yes' ) ? [
                'delay' => 3000,
                'disableOnInteraction' => false,
            ] : false,
            'breakpoints' => [
                '0' => [ 
                    'slidesPerView' => $slides_mobile,
                    'spaceBetween' => 15
                ],
                '768' => [ 
                    'slidesPerView' => $slides_tablet,
                    'spaceBetween' => 20
                ],
                '1024' => [ 
                    'slidesPerView' => $slides_per_view,
                    'spaceBetween' => 20
                ],
            ],
        ];
        ?>

        <div class="mss-premium-carousel-wrapper" data-settings='<?php echo esc_attr( wp_json_encode( $swiper_options ) ); ?>'>
            <div class="swiper-container mss-pc-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $settings['carousel_items'] as $item ) : ?>
                        <div class="swiper-slide">
                            <div class="mss-pc-card">
                                <div class="mss-pc-image-wrap">
                                    <?php if ( ! empty( $item['item_image']['url'] ) ) : ?>
                                        <img src="<?php echo esc_url( $item['item_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['item_name'] ); ?>">
                                    <?php endif; ?>

                                    <!-- Default Info (Visible at bottom) -->
                                    <div class="mss-pc-info">
                                        <h3 class="mss-pc-name"><?php echo esc_html( $item['item_name'] ); ?></h3>
                                        <p class="mss-pc-short-desc"><?php echo esc_html( $item['item_short_desc'] ); ?></p>
                                    </div>
                                    
                                    <!-- Hover Overlay -->
                                    <div class="mss-pc-overlay">
                                        <!-- Top Content -->
                                        <div class="mss-pc-overlay-top">
                                            <h3 class="mss-pc-name"><?php echo esc_html( $item['item_name'] ); ?></h3>
                                            <p class="mss-pc-short-desc"><?php echo esc_html( $item['item_short_desc'] ); ?></p>
                                        </div>

                                        <!-- Bottom Content -->
                                        <div class="mss-pc-overlay-bottom">
                                            <p class="mss-pc-detailed-desc"><?php echo esc_html( $item['item_detailed_desc'] ); ?></p>
                                            
                                            <div class="mss-pc-social-links">
                                                <?php for ( $i = 1; $i <= 3; $i++ ) : 
                                                    $icon_key = 'social_icon_' . $i;
                                                    $link_key = 'social_link_' . $i;
                                                    if ( ! empty( $item[$link_key]['url'] ) ) : ?>
                                                        <a href="<?php echo esc_url( $item[$link_key]['url'] ); ?>" class="mss-pc-social-link" <?php echo !empty($item[$link_key]['is_external']) ? 'target="_blank"' : ''; ?>>
                                                            <?php \Elementor\Icons_Manager::render_icon( $item[$icon_key], [ 'aria-hidden' => 'true' ] ); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ( $settings['show_arrows'] === 'yes' ) : ?>
                    <div class="swiper-button-next mss-pc-next"></div>
                    <div class="swiper-button-prev mss-pc-prev"></div>
                <?php endif; ?>

                <?php if ( $settings['show_pagination'] === 'yes' ) : ?>
                    <div class="swiper-pagination mss-pc-pagination"></div>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}


