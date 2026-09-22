<?php
/**
 * Plugin Name: PNS Addons for Elementor
 * Description: Custom high-performance & fully customizable Elementor widgets and interactive sliders.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Tested up to: 7.1
 * Author: partho018
 * Author URI: https://pnscode.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pns-addons-for-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define Constants
if ( ! defined( 'PNS_ADDONS_FOR_ELEMENTOR_VERSION' ) ) {
    define( 'PNS_ADDONS_FOR_ELEMENTOR_VERSION', '1.0.0' );
}
if ( ! defined( 'PNS_ADDONS_FOR_ELEMENTOR_FILE' ) ) {
    define( 'PNS_ADDONS_FOR_ELEMENTOR_FILE', __FILE__ );
}
if ( ! defined( 'PNS_ADDONS_FOR_ELEMENTOR_URL' ) ) {
    define( 'PNS_ADDONS_FOR_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'PNS_ADDONS_FOR_ELEMENTOR_PATH' ) ) {
    define( 'PNS_ADDONS_FOR_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * -----------------------------------------------------------------------------
 * 1. ASSETS REGISTRATION & ENQUEUEING
 * -----------------------------------------------------------------------------
 */

/**
 * Enqueue Modern Slider & Swiper Assets
 */
function pns_addons_for_elementor_enqueue_slider_assets() {
    wp_enqueue_style( 'mss-style', plugins_url( 'assets/css/pns-slider.css', __FILE__ ), array(), '1.2.0' );
    wp_enqueue_script( 'mss-script', plugins_url( 'assets/js/slider.js', __FILE__ ), array( 'jquery' ), '1.2.0', true );
    
    // Enqueue Swiper assets (bundled locally to prevent CDN offloading)
    wp_enqueue_style( 'swiper', plugins_url( 'assets/css/swiper-bundle.min.css', __FILE__ ), array(), '8.4.7' );
    wp_enqueue_script( 'swiper', plugins_url( 'assets/js/swiper-bundle.min.js', __FILE__ ), array(), '8.4.7', true );
    
    // Dashicons for frontend navigation
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'pns_addons_for_elementor_enqueue_slider_assets' );
add_action( 'elementor/frontend/after_enqueue_scripts', 'pns_addons_for_elementor_enqueue_slider_assets' );

/**
 * Register & Enqueue Custom Elementor Widgets Styles
 */
function pns_addons_for_elementor_enqueue_custom_widget_styles() {
    wp_register_style( 'custom-elementor-widgets-style', plugins_url( 'assets/css/pns-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-elementor-sticky-widgets-style', plugins_url( 'assets/css/pns-sticky-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-marquee-widget-style', plugins_url( 'assets/css/pns-marquee-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-process-widget-style', plugins_url( 'assets/css/pns-process-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-promo-banner-style', plugins_url( 'assets/css/pns-promo-banner-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-pns-footer-style', plugins_url( 'assets/css/pns-footer-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-table-widget-style', plugins_url( 'assets/css/pns-custom-table-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-pricing-table-style', plugins_url( 'assets/css/pns-pricing-table-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_script( 'pns-pricing-table-script', plugins_url( 'assets/js/pns-pricing-table.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
    wp_register_style( 'pns-faq-style', plugins_url( 'assets/css/pns-faq-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_script( 'pns-faq-script', plugins_url( 'assets/js/pns-faq-script.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

    // Register Showcase / Blog Styles & Scripts
    wp_register_style(
        'pns-blog-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Red+Hat+Display:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap',
        array(),
        PNS_ADDONS_FOR_ELEMENTOR_VERSION
    );

    $css_path = plugin_dir_path( __FILE__ ) . 'assets/css/pns-blog-styles.css';
    $css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0';
    wp_register_style(
        'pns-blog-styles',
        plugins_url( 'assets/css/pns-blog-styles.css', __FILE__ ),
        array( 'pns-blog-fonts' ),
        $css_ver
    );

    $js_path = plugin_dir_path( __FILE__ ) . 'assets/js/blog-scripts.js';
    $js_ver  = file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0';
    wp_register_script(
        'pns-blog-scripts',
        plugins_url( 'assets/js/blog-scripts.js', __FILE__ ),
        array( 'jquery' ),
        $js_ver,
        true
    );

    wp_enqueue_style( 'custom-elementor-widgets-style' );
    wp_enqueue_style( 'pns-faq-style' );
    wp_enqueue_script( 'pns-faq-script' );
    wp_enqueue_style( 'custom-elementor-sticky-widgets-style' );
    wp_enqueue_style( 'custom-marquee-widget-style' );
    wp_enqueue_style( 'custom-process-widget-style' );
    wp_enqueue_style( 'custom-promo-banner-style' );
    wp_enqueue_style( 'custom-pns-footer-style' );
    wp_enqueue_style( 'custom-table-widget-style' );
    wp_enqueue_style( 'pns-pricing-table-style' );
    wp_enqueue_script( 'pns-pricing-table-script' );
    wp_enqueue_style( 'pns-blog-styles' );
    wp_enqueue_script( 'pns-blog-scripts' );
}
add_action( 'elementor/frontend/after_register_styles', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'wp_enqueue_scripts', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'elementor/editor/after_enqueue_styles', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'elementor/editor/after_enqueue_scripts', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );

/**
 * -----------------------------------------------------------------------------
 * 2. ELEMENTOR CATEGORIES REGISTRATION
 * -----------------------------------------------------------------------------
 */
function pns_addons_for_elementor_add_categories( $elements_manager ) {
    $elements_manager->add_category(
        'custom-elementor-category',
        [
            'title' => esc_html__( 'PNS Addons', 'pns-addons-for-elementor' ),
            'icon'  => 'fa fa-plug',
        ]
    );

    try {
        $reflection = new \ReflectionClass( $elements_manager );
        $categories_prop = null;
        if ( $reflection->hasProperty( 'categories' ) ) {
            $categories_prop = $reflection->getProperty( 'categories' );
        } elseif ( $reflection->hasProperty( '_categories' ) ) {
            $categories_prop = $reflection->getProperty( '_categories' );
        }

        if ( $categories_prop ) {
            $categories_prop->setAccessible( true );
            $categories = $categories_prop->getValue( $elements_manager );
            if ( is_array( $categories ) && isset( $categories['custom-elementor-category'] ) ) {
                $custom = [ 'custom-elementor-category' => $categories['custom-elementor-category'] ];
                unset( $categories['custom-elementor-category'] );
                $categories_prop->setValue( $elements_manager, array_merge( $custom, $categories ) );
            }
        }
    } catch ( \Exception $e ) {
        // Fallback gracefully
    }
}
add_action( 'elementor/elements/categories_registered', 'pns_addons_for_elementor_add_categories', 999 );

/**
 * Reorder Elementor Editor categories so PNS Addons is always at the very top
 */
function pns_addons_for_elementor_reorder_categories( $settings ) {
    if ( isset( $settings['elementor_site_categories'] ) && is_array( $settings['elementor_site_categories'] ) ) {
        if ( isset( $settings['elementor_site_categories']['custom-elementor-category'] ) ) {
            $custom = [ 'custom-elementor-category' => $settings['elementor_site_categories']['custom-elementor-category'] ];
            unset( $settings['elementor_site_categories']['custom-elementor-category'] );
            $settings['elementor_site_categories'] = array_merge( $custom, $settings['elementor_site_categories'] );
        }
    }
    return $settings;
}
add_filter( 'elementor/editor/localize_settings', 'pns_addons_for_elementor_reorder_categories', 999 );

/**
 * -----------------------------------------------------------------------------
 * 3. SHORTCODES & BLOG LOGIC
 * -----------------------------------------------------------------------------
 */

// Modern Slider shortcode fallback notice
function pns_addons_for_elementor_slider_shortcode( $atts ) {
    return '<div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px; color: #856404;">Please use the <strong>Elementor Widget</strong> "Modern Slider" to display the interactive slider.</div>';
}
add_shortcode( 'modern_slider', 'pns_addons_for_elementor_slider_shortcode' );

/**
 * -----------------------------------------------------------------------------
 * 4. ALL ELEMENTOR WIDGETS REGISTRATION (20 WIDGETS)
 * -----------------------------------------------------------------------------
 */
function pns_addons_for_elementor_register_widgets( $widgets_manager ) {
    // A. Elementor-Addon Widgets (7 Widgets)
    $mss_widgets = [
        'pns-slider-widget.php'           => 'PNS_Slider_Widget',
        'pns-button-widget.php'           => 'PNS_Animated_Button_Widget',
        'pns-timeline-widget.php'         => 'PNS_Timeline_Widget',
        'pns-video-card-widget.php'       => 'PNS_Video_Card_Widget',
        'pns-accordion-slider-widget.php' => 'PNS_Accordion_Slider_Widget',
        'pns-image-hover-card-widget.php' => 'PNS_Image_Hover_Card_Widget',
        'pns-carousel-widget.php'         => 'PNS_Premium_Carousel_Widget',
    ];

    foreach ( $mss_widgets as $file => $class ) {
        $path = __DIR__ . '/widgets/' . $file;
        if ( file_exists( $path ) ) {
            require_once( $path );
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }

    // B. Custom Elementor Widgets (9 Widgets)
    $custom_widgets = [
        'pns-what-we-do-widget.php'      => 'PNS_What_We_Do_Widget',
        'pns-sticky-projects-widget.php' => 'PNS_Sticky_Projects_Widget',
        'pns-marquee-ticker-widget.php'  => 'PNS_Marquee_Ticker_Widget',
        'pns-process-steps-widget.php'   => 'PNS_Process_Steps_Widget',
        'pns-promo-banner-widget.php'    => 'PNS_Promo_Banner_Widget',
        'pns-footer-widget.php'          => 'PNS_Footer_Widget',
        'pns-custom-table-widget.php'    => 'PNS_Table_Widget',
        'pns-pricing-table-widget.php'   => 'PNS_Pricing_Table_Widget',
        'pns-faq-widget.php'             => 'PNS_FAQ_Widget',
    ];

    foreach ( $custom_widgets as $file => $class ) {
        $path = __DIR__ . '/widgets/' . $file;
        if ( file_exists( $path ) ) {
            require_once( $path );
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }

    // C. Additional Widgets (4 Widgets)
    $additional_widgets = [
        'class-pns-services-widget.php'     => 'PNS_Services_Widget',
        'class-pns-partners-widget.php'     => 'PNS_Partners_Widget',
        'class-pns-title-widget.php'        => 'PNS_Title_Widget',
        'class-pns-testimonials-widget.php' => 'PNS_Testimonials_Widget',
    ];

    foreach ( $additional_widgets as $file => $class ) {
        $path = __DIR__ . '/includes/' . $file;
        if ( file_exists( $path ) ) {
            require_once( $path );
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }

    // Register Backward-Compatibility Aliases (ensures previously saved Elementor pages continue to render)
    if ( class_exists( 'PNS_Testimonials_Widget' ) ) {
        if ( ! class_exists( 'PNS_Legacy_Testimonials_Uboontu' ) ) {
            class PNS_Legacy_Testimonials_Uboontu extends PNS_Testimonials_Widget {
                public function get_name() { return 'uboontu_testimonials'; }
                public function show_in_panel() { return false; }
            }
        }
        $widgets_manager->register( new PNS_Legacy_Testimonials_Uboontu() );
    }

    if ( class_exists( 'PNS_Partners_Widget' ) ) {
        if ( ! class_exists( 'PNS_Legacy_Partners_Uboontu' ) ) {
            class PNS_Legacy_Partners_Uboontu extends PNS_Partners_Widget {
                public function get_name() { return 'uboontu_partners_gallery'; }
                public function show_in_panel() { return false; }
            }
        }
        $widgets_manager->register( new PNS_Legacy_Partners_Uboontu() );
    }

    if ( class_exists( 'PNS_Title_Widget' ) ) {
        if ( ! class_exists( 'PNS_Legacy_Title_Uboontu' ) ) {
            class PNS_Legacy_Title_Uboontu extends PNS_Title_Widget {
                public function get_name() { return 'uboontu_custom_title'; }
                public function show_in_panel() { return false; }
            }
        }
        $widgets_manager->register( new PNS_Legacy_Title_Uboontu() );
    }

    if ( class_exists( 'PNS_Services_Widget' ) ) {
        if ( ! class_exists( 'PNS_Legacy_Services_Uboontu' ) ) {
            class PNS_Legacy_Services_Uboontu extends PNS_Services_Widget {
                public function get_name() { return 'uboontu_core_services'; }
                public function show_in_panel() { return false; }
            }
        }
        $widgets_manager->register( new PNS_Legacy_Services_Uboontu() );
    }

    if ( class_exists( 'PNS_Footer_Widget' ) ) {
        if ( ! class_exists( 'PNS_Legacy_Footer_Uboontu' ) ) {
            class PNS_Legacy_Footer_Uboontu extends PNS_Footer_Widget {
                public function get_name() { return 'custom_uboontu_footer_widget'; }
                public function show_in_panel() { return false; }
            }
        }
        $widgets_manager->register( new PNS_Legacy_Footer_Uboontu() );
    }
}
add_action( 'elementor/widgets/register', 'pns_addons_for_elementor_register_widgets' );