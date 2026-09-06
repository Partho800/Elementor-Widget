<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

class Custom_Uboontu_Footer_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_uboontu_footer_widget';
	}

	public function get_title() {
		return esc_html__( 'Floating Card Premium Footer', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_style_depends() {
		return [ 'custom-uboontu-footer-style' ];
	}

	protected function register_controls() {

		// ==========================================
		// SECTION: GENERAL SETTINGS
		// ==========================================
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General Settings', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'footer_theme',
			[
				'label'   => esc_html__( 'Theme Mode', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => esc_html__( 'Clean Light (Graphy Style)', 'custom-elementor-widgets' ),
					'dark'  => esc_html__( 'Sleek Minimal Dark', 'custom-elementor-widgets' ),
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 600, 'max' => 1600, 'step' => 10 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1200,
				],
				'selectors'  => [
					'{{WRAPPER}} .card-footer-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_watermark',
			[
				'label'        => esc_html__( 'Show Background Watermark', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'watermark_text',
			[
				'label'     => esc_html__( 'Watermark Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Graphy', 'custom-elementor-widgets' ),
				'condition' => [ 'show_watermark' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// SECTION: BRAND DETAILS
		// ==========================================
		$this->start_controls_section(
			'section_brand',
			[
				'label' => esc_html__( 'Brand Column', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'show_logo',
			[
				'label'        => esc_html__( 'Show Logo', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label'     => esc_html__( 'Logo Image', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [ 'show_logo' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'logo_height',
			[
				'label'      => esc_html__( 'Logo Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'range'      => [
					'px' => [ 'min' => 15, 'max' => 120, 'step' => 1 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors'  => [
					'{{WRAPPER}} .card-footer-logo-img' => 'height: {{SIZE}}{{UNIT}}; width: auto;',
				],
				'condition'  => [ 'show_logo' => 'yes' ],
			]
		);

		$this->add_control(
			'logo_text',
			[
				'label'     => esc_html__( 'Logo Text', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Graphy', 'custom-elementor-widgets' ),
				'condition' => [ 'show_logo' => 'yes' ],
			]
		);

		$this->add_control(
			'brand_desc',
			[
				'label'   => esc_html__( 'Brand Description', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Graphy empowers teams to transform raw data into clear, compelling visuals — making insights easier to share, understand, and act on.', 'custom-elementor-widgets' ),
				'rows'    => 4,
			]
		);

		$this->end_controls_section();

		// ==========================================
		// SECTION: LINK COLUMNS
		// ==========================================
		$this->start_controls_section(
			'section_columns',
			[
				'label' => esc_html__( 'Link Columns', 'custom-elementor-widgets' ),
			]
		);

		// Column 1
		$this->add_control(
			'col1_title',
			[
				'label'   => esc_html__( 'Column 1 Title', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Product', 'custom-elementor-widgets' ),
			]
		);

		$col1_repeater = new \Elementor\Repeater();
		$col1_repeater->add_control(
			'link_title',
			[
				'label'   => esc_html__( 'Link Title', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Link Item', 'custom-elementor-widgets' ),
			]
		);
		$col1_repeater->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'Link URL', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
				],
			]
		);

		$this->add_control(
			'col1_links',
			[
				'label'       => esc_html__( 'Column 1 Links', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $col1_repeater->get_controls(),
				'default'     => [
					[ 'link_title' => esc_html__( 'Features', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Pricing', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Integrations', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Changelog', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
				],
				'title_field' => '{{{ link_title }}}',
			]
		);

		// Column 2
		$this->add_control(
			'col2_title',
			[
				'label'     => esc_html__( 'Column 2 Title', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Resources', 'custom-elementor-widgets' ),
				'separator' => 'before',
			]
		);

		$col2_repeater = new \Elementor\Repeater();
		$col2_repeater->add_control(
			'link_title',
			[
				'label'   => esc_html__( 'Link Title', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Link Item', 'custom-elementor-widgets' ),
			]
		);
		$col2_repeater->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'Link URL', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
				],
			]
		);

		$this->add_control(
			'col2_links',
			[
				'label'       => esc_html__( 'Column 2 Links', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $col2_repeater->get_controls(),
				'default'     => [
					[ 'link_title' => esc_html__( 'Documentation', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Tutorials', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Blog', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Support', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
				],
				'title_field' => '{{{ link_title }}}',
			]
		);

		// Column 3
		$this->add_control(
			'col3_title',
			[
				'label'     => esc_html__( 'Column 3 Title', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Company', 'custom-elementor-widgets' ),
				'separator' => 'before',
			]
		);

		$col3_repeater = new \Elementor\Repeater();
		$col3_repeater->add_control(
			'link_title',
			[
				'label'   => esc_html__( 'Link Title', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Link Item', 'custom-elementor-widgets' ),
			]
		);
		$col3_repeater->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'Link URL', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
				],
			]
		);

		$this->add_control(
			'col3_links',
			[
				'label'       => esc_html__( 'Column 3 Links', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $col3_repeater->get_controls(),
				'default'     => [
					[ 'link_title' => esc_html__( 'About', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Careers', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Contact', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
					[ 'link_title' => esc_html__( 'Partners', 'custom-elementor-widgets' ), 'link_url' => [ 'url' => '#' ] ],
				],
				'title_field' => '{{{ link_title }}}',
			]
		);

		$this->end_controls_section();

		// ==========================================
		// SECTION: SOCIAL & LEGAL LINKS
		// ==========================================
		$this->start_controls_section(
			'section_bottom',
			[
				'label' => esc_html__( 'Social & Legal Settings', 'custom-elementor-widgets' ),
			]
		);

		$this->add_control(
			'show_social',
			[
				'label'        => esc_html__( 'Show Social Icons', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$social_repeater = new \Elementor\Repeater();
		$social_repeater->add_control(
			'social_icon',
			[
				'label'   => esc_html__( 'Choose Network', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'twitter',
				'options' => [
					'twitter'   => esc_html__( 'Twitter/X', 'custom-elementor-widgets' ),
					'instagram' => esc_html__( 'Instagram', 'custom-elementor-widgets' ),
					'linkedin'  => esc_html__( 'LinkedIn', 'custom-elementor-widgets' ),
					'github'    => esc_html__( 'GitHub', 'custom-elementor-widgets' ),
					'facebook'  => esc_html__( 'Facebook', 'custom-elementor-widgets' ),
				],
			]
		);

		$social_repeater->add_control(
			'social_url',
			[
				'label'   => esc_html__( 'Profile URL', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => true,
				],
			]
		);

		$this->add_control(
			'social_links',
			[
				'label'       => esc_html__( 'Social Profiles', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social_repeater->get_controls(),
				'default'     => [
					[ 'social_icon' => 'twitter' ],
					[ 'social_icon' => 'instagram' ],
					[ 'social_icon' => 'linkedin' ],
					[ 'social_icon' => 'github' ],
				],
				'title_field' => '{{{ social_icon }}}',
				'condition'   => [ 'show_social' => 'yes' ],
			]
		);

		$this->add_control(
			'copyright_text',
			[
				'label'   => esc_html__( 'Copyright Statement', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => sprintf( esc_html__( '© %s Graphy. All rights reserved.', 'custom-elementor-widgets' ), date( 'Y' ) ),
				'separator' => 'before',
			]
		);

		$legal_repeater = new \Elementor\Repeater();
		$legal_repeater->add_control(
			'legal_title',
			[
				'label'   => esc_html__( 'Link Title', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Legal Disclosure', 'custom-elementor-widgets' ),
			]
		);
		$legal_repeater->add_control(
			'legal_url',
			[
				'label'   => esc_html__( 'Link URL', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
				],
			]
		);

		$this->add_control(
			'legal_links',
			[
				'label'       => esc_html__( 'Legal Disclosures', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $legal_repeater->get_controls(),
				'default'     => [
					[ 'legal_title' => esc_html__( 'Privacy Policy', 'custom-elementor-widgets' ), 'legal_url' => [ 'url' => '#' ] ],
					[ 'legal_title' => esc_html__( 'Terms of Service', 'custom-elementor-widgets' ), 'legal_url' => [ 'url' => '#' ] ],
					[ 'legal_title' => esc_html__( 'Cookie Settings', 'custom-elementor-widgets' ), 'legal_url' => [ 'url' => '#' ] ],
				],
				'title_field' => '{{{ legal_title }}}',
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// STYLE TAB: COLORS & SCHEME
		// =========================================================================
		$this->start_controls_section(
			'section_style_colors',
			[
				'label' => esc_html__( 'Color Customization', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_outer_bg',
			[
				'label'     => esc_html__( 'Section Outer Background', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-outer-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_footer_bg',
			[
				'label'     => esc_html__( 'Floating Panel Background', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-footer-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_accent',
			[
				'label'     => esc_html__( 'Accent Color (Hover/Links/Active)', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-accent: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border',
			[
				'label'     => esc_html__( 'Card border & Dividers', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-border: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_text_heading',
			[
				'label'     => esc_html__( 'Headings Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-text-heading: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_text_body',
			[
				'label'     => esc_html__( 'Body & Link Text Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-text-body: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_watermark_color',
			[
				'label'     => esc_html__( 'Watermark Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-footer-wrapper' => '--card-watermark-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: TYPOGRAPHY
		// ==========================================
		$this->start_controls_section(
			'section_style_typography',
			[
				'label' => esc_html__( 'Typography Settings', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'logo_typography',
				'label'    => esc_html__( 'Logo Text Typography', 'custom-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .card-footer-logo-text',
				'condition' => [ 'show_logo' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'col_title_typography',
				'label'    => esc_html__( 'Column Title Typography', 'custom-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .card-footer-col-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'links_typography',
				'label'    => esc_html__( 'Footer Links Typography', 'custom-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .card-footer-links a, {{WRAPPER}} .card-footer-brand-desc',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'copyright_typography',
				'label'    => esc_html__( 'Copyright Statement Typography', 'custom-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .card-footer-copyright p, {{WRAPPER}} .card-footer-legal-links a',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		
		$wrapper_classes = [ 'card-footer-wrapper' ];
		if ( isset( $settings['footer_theme'] ) && 'dark' === $settings['footer_theme'] ) {
			$wrapper_classes[] = 'card-theme-dark';
		} else {
			$wrapper_classes[] = 'card-theme-light';
		}
		?>

		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			
			<!-- Huge Brand Background Watermark -->
			<?php if ( 'yes' === $settings['show_watermark'] && ! empty( $settings['watermark_text'] ) ) : ?>
				<div class="card-footer-watermark">
					<?php echo esc_html( $settings['watermark_text'] ); ?>
				</div>
			<?php endif; ?>

			<div class="card-footer-container">
				
				<!-- Floating Rounded Card Panel -->
				<div class="card-footer-panel">
					
					<!-- Main Grid -->
					<div class="card-footer-grid">
						
						<!-- Column 1: Branding details & Socials -->
						<div class="card-footer-col">
							<?php if ( 'yes' === $settings['show_logo'] ) : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="card-footer-logo">
									<?php if ( ! empty( $settings['logo_image']['url'] ) ) : ?>
										<img src="<?php echo esc_url( $settings['logo_image']['url'] ); ?>" alt="Logo" class="card-footer-logo-img" />
									<?php endif; ?>
									<span class="card-footer-logo-text"><?php echo esc_html( $settings['logo_text'] ); ?></span>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $settings['brand_desc'] ) ) : ?>
								<p class="card-footer-brand-desc"><?php echo esc_html( $settings['brand_desc'] ); ?></p>
							<?php endif; ?>

							<!-- Social profiles -->
							<?php if ( 'yes' === $settings['show_social'] && ! empty( $settings['social_links'] ) ) : ?>
								<div class="card-footer-social-row">
									<?php foreach ( $settings['social_links'] as $item ) : ?>
										<?php 
										$soc_url = ! empty( $item['social_url']['url'] ) ? $item['social_url']['url'] : '#';
										$soc_external = ! empty( $item['social_url']['is_external'] ) ? ' target="_blank"' : '';
										?>
										<a href="<?php echo esc_url( $soc_url ); ?>" class="card-social-btn" aria-label="<?php echo esc_attr( $item['social_icon'] ); ?>"<?php echo $soc_external; ?>>
											<?php if ( 'twitter' === $item['social_icon'] ) : ?>
												<svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
											<?php elseif ( 'instagram' === $item['social_icon'] ) : ?>
												<svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" /></svg>
											<?php elseif ( 'linkedin' === $item['social_icon'] ) : ?>
												<svg viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
											<?php elseif ( 'github' === $item['social_icon'] ) : ?>
												<svg viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
											<?php elseif ( 'facebook' === $item['social_icon'] ) : ?>
												<svg viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" /></svg>
											<?php endif; ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>

						<!-- Column 2: Navigation Column 1 -->
						<div class="card-footer-col">
							<h4 class="card-footer-col-title"><?php echo esc_html( $settings['col1_title'] ); ?></h4>
							<?php if ( ! empty( $settings['col1_links'] ) ) : ?>
								<ul class="card-footer-links">
									<?php foreach ( $settings['col1_links'] as $item ) : ?>
										<?php 
										$item_url = ! empty( $item['link_url']['url'] ) ? $item['link_url']['url'] : '#';
										$item_external = ! empty( $item['link_url']['is_external'] ) ? ' target="_blank"' : '';
										?>
										<li>
											<a href="<?php echo esc_url( $item_url ); ?>"<?php echo $item_external; ?>>
												<?php echo esc_html( $item['link_title'] ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>

						<!-- Column 3: Navigation Column 2 -->
						<div class="card-footer-col">
							<h4 class="card-footer-col-title"><?php echo esc_html( $settings['col2_title'] ); ?></h4>
							<?php if ( ! empty( $settings['col2_links'] ) ) : ?>
								<ul class="card-footer-links">
									<?php foreach ( $settings['col2_links'] as $item ) : ?>
										<?php 
										$item_url = ! empty( $item['link_url']['url'] ) ? $item['link_url']['url'] : '#';
										$item_external = ! empty( $item['link_url']['is_external'] ) ? ' target="_blank"' : '';
										?>
										<li>
											<a href="<?php echo esc_url( $item_url ); ?>"<?php echo $item_external; ?>>
												<?php echo esc_html( $item['link_title'] ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>

						<!-- Column 4: Navigation Column 3 -->
						<div class="card-footer-col">
							<h4 class="card-footer-col-title"><?php echo esc_html( $settings['col3_title'] ); ?></h4>
							<?php if ( ! empty( $settings['col3_links'] ) ) : ?>
								<ul class="card-footer-links">
									<?php foreach ( $settings['col3_links'] as $item ) : ?>
										<?php 
										$item_url = ! empty( $item['link_url']['url'] ) ? $item['link_url']['url'] : '#';
										$item_external = ! empty( $item['link_url']['is_external'] ) ? ' target="_blank"' : '';
										?>
										<li>
											<a href="<?php echo esc_url( $item_url ); ?>"<?php echo $item_external; ?>>
												<?php echo esc_html( $item['link_title'] ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>

					</div>

					<!-- Divider Line -->
					<div class="card-footer-divider"></div>

					<!-- Bottom Copyright & Legal Links -->
					<div class="card-footer-bottom">
						<div class="card-footer-copyright">
							<p><?php echo esc_html( $settings['copyright_text'] ); ?></p>
						</div>

						<?php if ( ! empty( $settings['legal_links'] ) ) : ?>
							<ul class="card-footer-legal-links">
								<?php foreach ( $settings['legal_links'] as $item ) : ?>
									<?php 
									$legal_url = ! empty( $item['legal_url']['url'] ) ? $item['legal_url']['url'] : '#';
									$legal_external = ! empty( $item['legal_url']['is_external'] ) ? ' target="_blank"' : '';
									?>
									<li>
										<a href="<?php echo esc_url( $legal_url ); ?>"<?php echo $legal_external; ?>>
											<?php echo esc_html( $item['legal_title'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>

				</div>

			</div>
		</div>

		<?php
	}
}
