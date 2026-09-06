<?php
/**
 * Plugin Name: Elementor Addon
 * Plugin URI: https://pnscode.com/
 * Description: Custom high-performance & fully customizable Elementor widgets and interactive sliders.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: Raju
 * Author URI: https://pnscode.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-addon
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Load plugin textdomain for internationalization
 */
function elementor_addon_load_textdomain() {
    load_plugin_textdomain( 'elementor-addon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'elementor_addon_load_textdomain' );

/**
 * -----------------------------------------------------------------------------
 * 1. ASSETS REGISTRATION & ENQUEUEING
 * -----------------------------------------------------------------------------
 */

/**
 * Enqueue Modern Slider & Swiper Assets
 */
function elementor_addon_enqueue_slider_assets() {
    wp_enqueue_style( 'mss-style', plugins_url( 'assets/css/slider.css', __FILE__ ), array(), '1.2.0' );
    wp_enqueue_script( 'mss-script', plugins_url( 'assets/js/slider.js', __FILE__ ), array( 'jquery' ), '1.2.0', true );
    
    // Enqueue Swiper assets
    wp_enqueue_style( 'swiper', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), '8.0.0' );
    wp_enqueue_script( 'swiper', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), '8.0.0', true );
    
    // Dashicons for frontend navigation
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'elementor_addon_enqueue_slider_assets' );
add_action( 'elementor/frontend/after_enqueue_scripts', 'elementor_addon_enqueue_slider_assets' );

/**
 * Register & Enqueue Custom Elementor Widgets Styles
 */
function elementor_addon_enqueue_custom_widget_styles() {
    wp_register_style( 'custom-elementor-widgets-style', plugins_url( 'assets/css/widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-elementor-sticky-widgets-style', plugins_url( 'assets/css/sticky-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-marquee-widget-style', plugins_url( 'assets/css/marquee-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-process-widget-style', plugins_url( 'assets/css/process-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-promo-banner-style', plugins_url( 'assets/css/promo-banner-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-uboontu-footer-style', plugins_url( 'assets/css/uboontu-footer-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-table-widget-style', plugins_url( 'assets/css/custom-table-style.css', __FILE__ ), [], '1.0.0' );

    wp_enqueue_style( 'custom-elementor-widgets-style' );
    wp_enqueue_style( 'custom-elementor-sticky-widgets-style' );
    wp_enqueue_style( 'custom-marquee-widget-style' );
    wp_enqueue_style( 'custom-process-widget-style' );
    wp_enqueue_style( 'custom-promo-banner-style' );
    wp_enqueue_style( 'custom-uboontu-footer-style' );
    wp_enqueue_style( 'custom-table-widget-style' );
}
add_action( 'elementor/frontend/after_register_styles', 'elementor_addon_enqueue_custom_widget_styles' );
add_action( 'wp_enqueue_scripts', 'elementor_addon_enqueue_custom_widget_styles' );

/**
 * Register Blog Fonts, Styles, and Scripts
 */
function elementor_addon_register_blog_assets() {
    wp_register_style(
        'uboontu-blog-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Red+Hat+Display:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    $css_path = plugin_dir_path( __FILE__ ) . 'assets/css/blog-styles.css';
    $css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0';
    wp_register_style(
        'uboontu-blog-styles',
        plugins_url( 'assets/css/blog-styles.css', __FILE__ ),
        array( 'uboontu-blog-fonts' ),
        $css_ver
    );

    $js_path = plugin_dir_path( __FILE__ ) . 'assets/js/blog-scripts.js';
    $js_ver  = file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0';
    wp_register_script(
        'uboontu-blog-scripts',
        plugins_url( 'assets/js/blog-scripts.js', __FILE__ ),
        array(),
        $js_ver,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'elementor_addon_register_blog_assets' );


/**
 * -----------------------------------------------------------------------------
 * 2. ELEMENTOR CATEGORIES REGISTRATION (Moved to Top)
 * -----------------------------------------------------------------------------
 */
function elementor_addon_add_elementor_categories( $elements_manager ) {
    $elements_manager->add_category(
        'custom-elementor-category',
        [
            'title' => esc_html__( 'Custom Widgets', 'elementor-addon' ),
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
add_action( 'elementor/elements/categories_registered', 'elementor_addon_add_elementor_categories', 999 );

/**
 * Reorder Elementor Editor categories so Custom Widgets is always at the very top
 */
function elementor_addon_reorder_editor_categories( $settings ) {
    if ( isset( $settings['elementor_site_categories'] ) && is_array( $settings['elementor_site_categories'] ) ) {
        if ( isset( $settings['elementor_site_categories']['custom-elementor-category'] ) ) {
            $custom = [ 'custom-elementor-category' => $settings['elementor_site_categories']['custom-elementor-category'] ];
            unset( $settings['elementor_site_categories']['custom-elementor-category'] );
            $settings['elementor_site_categories'] = array_merge( $custom, $settings['elementor_site_categories'] );
        }
    }
    return $settings;
}
add_filter( 'elementor/editor/localize_settings', 'elementor_addon_reorder_editor_categories', 999 );





/**
 * -----------------------------------------------------------------------------
 * 4. SHORTCODES & BLOG LOGIC
 * -----------------------------------------------------------------------------
 */

// Modern Slider shortcode fallback notice
function elementor_addon_slider_shortcode( $atts ) {
    return '<div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px; color: #856404;">Please use the <strong>Elementor Widget</strong> "Modern Slider" to display the interactive slider.</div>';
}
add_shortcode( 'modern_slider', 'elementor_addon_slider_shortcode' );

// Include blog helper & seed functions
require_once plugin_dir_path( __FILE__ ) . 'includes/blog-functions.php';


/**
 * -----------------------------------------------------------------------------
 * 5. ALL ELEMENTOR WIDGETS REGISTRATION (20 WIDGETS)
 * -----------------------------------------------------------------------------
 */
function elementor_addon_register_elementor_widgets( $widgets_manager ) {
    // A. Elementor-Addon Widgets (8 Widgets)
    $mss_widgets = [
        'mss-slider-widget.php'           => 'MSS_Slider_Widget',
        'mss-button-widget.php'           => 'MSS_Animated_Button_Widget',
        'mss-timeline-widget.php'         => 'MSS_Timeline_Widget',
        'mss-video-card-widget.php'       => 'MSS_Video_Card_Widget',
        'mss-review-marquee-widget.php'   => 'MSS_Review_Marquee_Widget',
        'mss-accordion-slider-widget.php' => 'MSS_Accordion_Slider_Widget',
        'mss-image-hover-card-widget.php' => 'MSS_Image_Hover_Card_Widget',
        'mss-carousel-widget.php'         => 'MSS_Premium_Carousel_Widget',
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

    // B. Custom Elementor Widgets (7 Widgets)
    $custom_widgets = [
        'what-we-do-widget.php'      => 'Custom_What_We_Do_Widget',
        'sticky-projects-widget.php' => 'Custom_Sticky_Projects_Widget',
        'marquee-ticker-widget.php'  => 'Custom_Marquee_Ticker_Widget',
        'process-steps-widget.php'   => 'Custom_Process_Steps_Widget',
        'promo-banner-widget.php'    => 'Custom_Promo_Banner_Widget',
        'uboontu-footer-widget.php'  => 'Custom_Uboontu_Footer_Widget',
        'custom-table-widget.php'    => 'Custom_Table_Widget',
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

    // C. Additional Widgets (5 Widgets)
    $additional_widgets = [
        'class-uboontu-sdg-widget.php'          => 'Uboontu_SDG_Widget',
        'class-uboontu-services-widget.php'     => 'Uboontu_Services_Widget',
        'class-uboontu-partners-widget.php'     => 'Uboontu_Partners_Widget',
        'class-uboontu-title-widget.php'        => 'Uboontu_Title_Widget',
        'class-uboontu-testimonials-widget.php' => 'Uboontu_Testimonials_Widget',
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
}
add_action( 'elementor/widgets/register', 'elementor_addon_register_elementor_widgets' );
