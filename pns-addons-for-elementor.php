<?php
/**
 * Plugin Name: PNS Addons for Elementor
 * Description: Custom high-performance & fully customizable Elementor widgets and interactive sliders.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Requires Plugins: elementor
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
    wp_register_style( 'pns-slider-style', plugins_url( 'assets/css/pns-slider.css', __FILE__ ), array(), '1.2.0' );
    wp_register_script( 'pns-slider-script', plugins_url( 'assets/js/slider.js', __FILE__ ), array( 'jquery' ), '1.2.0', true );
    wp_enqueue_style( 'pns-slider-style' );
    wp_enqueue_script( 'pns-slider-script' );

    // Aliases for backward compatibility
    wp_register_style( 'mss-style', plugins_url( 'assets/css/pns-slider.css', __FILE__ ), array(), '1.2.0' );
    wp_register_script( 'mss-script', plugins_url( 'assets/js/slider.js', __FILE__ ), array( 'jquery' ), '1.2.0', true );

    // Swiper v11.2.8 bundled locally (no CDN, compliant with WordPress.org guidelines)
    wp_enqueue_style( 'swiper', plugins_url( 'assets/css/swiper-bundle.min.css', __FILE__ ), array(), '11.2.8' );
    wp_enqueue_script( 'swiper', plugins_url( 'assets/js/swiper-bundle.min.js', __FILE__ ), array(), '11.2.8', true );

    // Dashicons for frontend navigation
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'pns_addons_for_elementor_enqueue_slider_assets' );
add_action( 'elementor/frontend/after_enqueue_scripts', 'pns_addons_for_elementor_enqueue_slider_assets' );

/**
 * Register & Enqueue Custom Elementor Widgets Styles
 */
function pns_addons_for_elementor_enqueue_custom_widget_styles() {
    // Register styles with unique plugin prefix
    wp_register_style( 'pns-widget-style', plugins_url( 'assets/css/pns-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-sticky-widget-style', plugins_url( 'assets/css/pns-sticky-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-marquee-widget-style', plugins_url( 'assets/css/pns-marquee-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-process-widget-style', plugins_url( 'assets/css/pns-process-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-promo-banner-style', plugins_url( 'assets/css/pns-promo-banner-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-footer-style', plugins_url( 'assets/css/pns-footer-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-custom-table-style', plugins_url( 'assets/css/pns-custom-table-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'pns-faq-style', plugins_url( 'assets/css/pns-faq-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_script( 'pns-faq-script', plugins_url( 'assets/js/pns-faq-script.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

    // Aliases for backward compatibility
    wp_register_style( 'custom-elementor-widgets-style', plugins_url( 'assets/css/pns-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-elementor-sticky-widgets-style', plugins_url( 'assets/css/pns-sticky-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-marquee-widget-style', plugins_url( 'assets/css/pns-marquee-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-process-widget-style', plugins_url( 'assets/css/pns-process-widget-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-promo-banner-style', plugins_url( 'assets/css/pns-promo-banner-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-pns-footer-style', plugins_url( 'assets/css/pns-footer-style.css', __FILE__ ), [], '1.0.0' );
    wp_register_style( 'custom-table-widget-style', plugins_url( 'assets/css/pns-custom-table-style.css', __FILE__ ), [], '1.0.0' );

    // Register Video Lightbox Script (used by Process Steps & What We Do widgets)
    $vl_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-video-lightbox.js';
    $vl_ver  = file_exists( $vl_path ) ? filemtime( $vl_path ) : '1.0.0';
    wp_register_script( 'pns-video-lightbox', plugins_url( 'assets/js/pns-video-lightbox.js', __FILE__ ), array( 'jquery' ), $vl_ver, true );

    // Register Video Card Script
    $vc_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-video-card.js';
    $vc_ver  = file_exists( $vc_path ) ? filemtime( $vc_path ) : '1.0.0';
    wp_register_script( 'pns-video-card', plugins_url( 'assets/js/pns-video-card.js', __FILE__ ), array( 'jquery' ), $vc_ver, true );

    // Register Accordion Slider Style & Script
    $as_css_path = plugin_dir_path( __FILE__ ) . 'assets/css/pns-accordion-slider-style.css';
    $as_css_ver  = file_exists( $as_css_path ) ? filemtime( $as_css_path ) : '1.0.0';
    wp_register_style( 'pns-accordion-slider-style', plugins_url( 'assets/css/pns-accordion-slider-style.css', __FILE__ ), [], $as_css_ver );

    $as_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-accordion-slider.js';
    $as_js_ver  = file_exists( $as_js_path ) ? filemtime( $as_js_path ) : '1.0.0';
    wp_register_script( 'pns-accordion-slider', plugins_url( 'assets/js/pns-accordion-slider.js', __FILE__ ), array( 'jquery', 'swiper' ), $as_js_ver, true );

    // Register Member Carousel Script
    $mc_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-member-carousel.js';
    $mc_js_ver  = file_exists( $mc_js_path ) ? filemtime( $mc_js_path ) : '1.0.0';
    wp_register_script( 'pns-member-carousel', plugins_url( 'assets/js/pns-member-carousel.js', __FILE__ ), array( 'jquery', 'swiper' ), $mc_js_ver, true );

    // Register Pricing Table Style & Script
    $pt_css_path = plugin_dir_path( __FILE__ ) . 'assets/css/pns-pricing-table.css';
    $pt_css_ver  = file_exists( $pt_css_path ) ? filemtime( $pt_css_path ) : '1.0.0';
    wp_register_style( 'pns-pricing-table-style', plugins_url( 'assets/css/pns-pricing-table.css', __FILE__ ), [], $pt_css_ver );

    $pt_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-pricing-table.js';
    $pt_js_ver  = file_exists( $pt_js_path ) ? filemtime( $pt_js_path ) : '1.0.0';
    wp_register_script( 'pns-pricing-table-script', plugins_url( 'assets/js/pns-pricing-table.js', __FILE__ ), array( 'jquery' ), $pt_js_ver, true );

    // Register Progress Bar & Circle Style & Script
    $pb_css_path = plugin_dir_path( __FILE__ ) . 'assets/css/pns-progress-bar.css';
    $pb_css_ver  = file_exists( $pb_css_path ) ? filemtime( $pb_css_path ) : '1.0.0';
    wp_register_style( 'pns-progress-bar-style', plugins_url( 'assets/css/pns-progress-bar.css', __FILE__ ), [], $pb_css_ver );

    $pb_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-progress-bar.js';
    $pb_js_ver  = file_exists( $pb_js_path ) ? filemtime( $pb_js_path ) : '1.0.0';
    wp_register_script( 'pns-progress-bar-script', plugins_url( 'assets/js/pns-progress-bar.js', __FILE__ ), array( 'jquery' ), $pb_js_ver, true );

    // Register 3D Flip Box Style & Script
    $fb_css_path = plugin_dir_path( __FILE__ ) . 'assets/css/pns-flip-box.css';
    $fb_css_ver  = file_exists( $fb_css_path ) ? filemtime( $fb_css_path ) : '1.0.0';
    wp_register_style( 'pns-flip-box-style', plugins_url( 'assets/css/pns-flip-box.css', __FILE__ ), [], $fb_css_ver );

    $fb_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-flip-box.js';
    $fb_js_ver  = file_exists( $fb_js_path ) ? filemtime( $fb_js_path ) : '1.0.0';
    wp_register_script( 'pns-flip-box-script', plugins_url( 'assets/js/pns-flip-box.js', __FILE__ ), array( 'jquery' ), $fb_js_ver, true );

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

    wp_enqueue_style( 'pns-widget-style' );
    wp_enqueue_style( 'pns-faq-style' );
    wp_enqueue_script( 'pns-faq-script' );
    wp_enqueue_style( 'pns-sticky-widget-style' );
    wp_enqueue_style( 'pns-marquee-widget-style' );
    wp_enqueue_style( 'pns-process-widget-style' );
    wp_enqueue_style( 'pns-promo-banner-style' );
    wp_enqueue_style( 'pns-footer-style' );
    wp_enqueue_style( 'pns-custom-table-style' );
    wp_enqueue_style( 'pns-blog-styles' );
    wp_enqueue_script( 'pns-blog-scripts' );
    wp_enqueue_style( 'pns-pricing-table-style' );
    wp_enqueue_script( 'pns-pricing-table-script' );
    wp_enqueue_style( 'pns-progress-bar-style' );
    wp_enqueue_script( 'pns-progress-bar-script' );
    wp_enqueue_style( 'pns-flip-box-style' );
    wp_enqueue_script( 'pns-flip-box-script' );

    // Register & Enqueue PNS Sticky Extension (for sections, containers, columns & widgets)
    $sticky_ext_css = plugin_dir_path( __FILE__ ) . 'assets/css/pns-sticky-extension.css';
    $sticky_ext_css_ver = file_exists( $sticky_ext_css ) ? filemtime( $sticky_ext_css ) : '1.0.0';
    wp_register_style( 'pns-sticky-extension-style', plugins_url( 'assets/css/pns-sticky-extension.css', __FILE__ ), [], $sticky_ext_css_ver );
    wp_enqueue_style( 'pns-sticky-extension-style' );

    $sticky_ext_js = plugin_dir_path( __FILE__ ) . 'assets/js/pns-sticky-extension.js';
    $sticky_ext_js_ver = file_exists( $sticky_ext_js ) ? filemtime( $sticky_ext_js ) : '1.0.0';
    wp_register_script( 'pns-sticky-extension-script', plugins_url( 'assets/js/pns-sticky-extension.js', __FILE__ ), [ 'jquery' ], $sticky_ext_js_ver, true );
    wp_enqueue_script( 'pns-sticky-extension-script' );
}
add_action( 'elementor/frontend/after_register_styles', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'wp_enqueue_scripts', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'elementor/editor/after_enqueue_styles', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );
add_action( 'elementor/editor/after_enqueue_scripts', 'pns_addons_for_elementor_enqueue_custom_widget_styles' );

/**
 * Enqueue Editor-Specific Helper Script
 */
function pns_addons_for_elementor_enqueue_editor_scripts() {
    $editor_js_path = plugin_dir_path( __FILE__ ) . 'assets/js/pns-editor.js';
    $editor_js_ver  = file_exists( $editor_js_path ) ? filemtime( $editor_js_path ) : PNS_ADDONS_FOR_ELEMENTOR_VERSION;
    wp_enqueue_script(
        'pns-editor-script',
        plugins_url( 'assets/js/pns-editor.js', __FILE__ ),
        array( 'jquery' ),
        $editor_js_ver,
        true
    );
}
add_action( 'elementor/editor/after_enqueue_scripts', 'pns_addons_for_elementor_enqueue_editor_scripts' );

/**
 * -----------------------------------------------------------------------------
 * 2. ELEMENTOR CATEGORIES REGISTRATION
 * -----------------------------------------------------------------------------
 */
function pns_addons_for_elementor_add_categories( $elements_manager ) {
    $elements_manager->add_category(
        'pns-addons-category',
        [
            'title' => esc_html__( 'PNS Addons', 'pns-addons-for-elementor' ),
            'icon'  => 'fa fa-plug',
        ],
        0
    );
}
add_action( 'elementor/elements/categories_registered', 'pns_addons_for_elementor_add_categories', 1 );

/**
 * -----------------------------------------------------------------------------
 * 3. SHORTCODES & BLOG LOGIC
 * -----------------------------------------------------------------------------
 */

// Modern Slider shortcode fallback notice (prefixed >= 4 characters to avoid naming collisions)
function pns_addons_for_elementor_slider_shortcode( $atts ) {
    return '<div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px; color: #856404;">Please use the <strong>Elementor Widget</strong> "Modern Slider" to display the interactive slider.</div>';
}
add_shortcode( 'pns_addons_modern_slider', 'pns_addons_for_elementor_slider_shortcode' );
add_shortcode( 'pns_modern_slider', 'pns_addons_for_elementor_slider_shortcode' );

/**
 * -----------------------------------------------------------------------------
 * 4. ALL ELEMENTOR WIDGETS REGISTRATION (22 WIDGETS)
 * -----------------------------------------------------------------------------
 */
function pns_addons_for_elementor_register_widgets( $widgets_manager ) {
    // Primary / Featured Widget (Sticky Project at the very top)
    $all_widgets = [
        'pns-sticky-projects-widget.php'  => 'PNS_Sticky_Projects_Widget',
        'pns-accordion-slider-widget.php' => 'PNS_Accordion_Slider_Widget',
        'pns-slider-widget.php'           => 'PNS_Slider_Widget',
        'pns-button-widget.php'           => 'PNS_Animated_Button_Widget',
        'pns-timeline-widget.php'         => 'PNS_Timeline_Widget',
        'pns-video-card-widget.php'       => 'PNS_Video_Card_Widget',
        'pns-image-hover-card-widget.php' => 'PNS_Image_Hover_Card_Widget',
        'pns-carousel-widget.php'         => 'PNS_Premium_Carousel_Widget',
        'pns-what-we-do-widget.php'       => 'PNS_What_We_Do_Widget',
        'pns-marquee-ticker-widget.php'   => 'PNS_Marquee_Ticker_Widget',
        'pns-process-steps-widget.php'    => 'PNS_Process_Steps_Widget',
        'pns-promo-banner-widget.php'     => 'PNS_Promo_Banner_Widget',
        'pns-footer-widget.php'           => 'PNS_Footer_Widget',
        'pns-custom-table-widget.php'     => 'PNS_Table_Widget',
        'pns-faq-widget.php'              => 'PNS_FAQ_Widget',
        'pns-pricing-table-widget.php'    => 'PNS_Pricing_Table_Widget',
        'pns-progress-bar-widget.php'     => 'PNS_Progress_Bar_Widget',
        'pns-flip-box-widget.php'         => 'PNS_Flip_Box_Widget',
    ];

    foreach ( $all_widgets as $file => $class ) {
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

/**
 * -----------------------------------------------------------------------------
 * 5. PNS STICKY EXTENSION (SECTIONS, CONTAINERS, COLUMNS & WIDGETS)
 * -----------------------------------------------------------------------------
 */
require_once PNS_ADDONS_FOR_ELEMENTOR_PATH . 'includes/class-pns-sticky-extension.php';
\PNS_Sticky_Extension::instance();