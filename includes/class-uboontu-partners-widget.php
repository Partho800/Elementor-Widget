<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Uboontu_Partners_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'uboontu_partners_gallery';
	}

	public function get_title() {
		return esc_html__( 'Brand Partners Gallery', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_style_depends() {
		return [ 'uboontu-blog-styles' ];
	}

	protected function register_controls() {

		// Section Header Controls
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'uboontu-blog-shortcodes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "Trusted by 200+ of the world's top brands", 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => esc_html__( 'Content Max Width', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 500,
						'max' => 1600,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1200,
				],
				'selectors' => [
					'{{WRAPPER}} .brands-marquee-wrapper, {{WRAPPER}} .brands-static-grid' => 'max-width: {{SIZE}}{{UNIT}} !important; margin: 0 auto;',
				],
			]
		);

		$this->end_controls_section();

		// Gallery Controls
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => esc_html__( 'Partner Logos', 'uboontu-blog-shortcodes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'brand_logos',
			[
				'label' => esc_html__( 'Add Brand Logos', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout Mode', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'marquee',
				'options' => [
					'marquee' => esc_html__( 'Infinite Scrolling Marquee', 'uboontu-blog-shortcodes' ),
					'grid' => esc_html__( 'Static Responsive Grid', 'uboontu-blog-shortcodes' ),
				],
			]
		);

		$this->add_control(
			'marquee_speed',
			[
				'label' => esc_html__( 'Marquee Scroll Speed (Seconds)', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 180,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 75,
				],
				'condition' => [
					'layout' => 'marquee',
				],
			]
		);

		$this->add_control(
			'enable_hover',
			[
				'label' => esc_html__( 'Enable Hover Effect', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'uboontu-blog-shortcodes' ),
				'label_off' => esc_html__( 'No', 'uboontu-blog-shortcodes' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'logo_opacity',
			[
				'label' => esc_html__( 'Logo Opacity (0-1)', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.55,
				],
				'selectors' => [
					'{{WRAPPER}} .brand-logo-img' => 'opacity: {{SIZE}} !important;',
				],
				'condition' => [
					'enable_hover' => 'yes',
				],
			]
		);

		$this->add_control(
			'logo_hover_opacity',
			[
				'label' => esc_html__( 'Logo Hover Opacity (0-1)', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1.0,
				],
				'selectors' => [
					'{{WRAPPER}} .brand-item:hover .brand-logo-img' => 'opacity: {{SIZE}} !important;',
				],
				'condition' => [
					'enable_hover' => 'yes',
				],
			]
		);

		$this->add_control(
			'logo_opacity_static',
			[
				'label' => esc_html__( 'Logo Opacity (0-1)', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1.0,
				],
				'selectors' => [
					'{{WRAPPER}} .brand-logo-img' => 'opacity: {{SIZE}} !important;',
				],
				'condition' => [
					'enable_hover!' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'logo_height',
			[
				'label' => esc_html__( 'Logo Height', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vh' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 64,
				],
				'selectors' => [
					'{{WRAPPER}} .brand-logo-img' => 'height: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .brand-item' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'logo_spacing_h',
			[
				'label' => esc_html__( 'Horizontal Spacing', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .brands-marquee-track' => 'gap: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .brands-static-grid' => 'column-gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'logo_spacing_v',
			[
				'label' => esc_html__( 'Vertical Row Spacing', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .brands-grid' => 'gap: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .brands-static-grid' => 'row-gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$logos = $settings['brand_logos'];

		if ( empty( $logos ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div style="text-align: center; padding: 40px; border: 2px dashed #ccc; color: #777; font-family: sans-serif; border-radius: 8px;">' . esc_html__( 'Please select brand logo images in the Elementor settings panel.', 'uboontu-blog-shortcodes' ) . '</div>';
			}
			return;
		}
		?>
		<div class="blogs-page">
		  <section class="trusted-brands-section" style="padding: 0; background: transparent;">
			<div class="trusted-brands-container">
			  <?php if ( ! empty( $settings['title_text'] ) ) : ?>
				<h2 class="trusted-brands-title">
				  <?php echo esc_html( $settings['title_text'] ); ?>
				</h2>
			  <?php endif; ?>
			  
			  <?php if ( 'grid' === $settings['layout'] ) : ?>
				<!-- Static Grid Layout -->
				<div class="brands-static-grid">
				  <?php foreach ( $logos as $logo ) : ?>
					<div class="brand-item">
					  <img src="<?php echo esc_url( $logo['url'] ); ?>" class="brand-logo-img" alt="<?php echo esc_attr__( 'Brand Logo', 'uboontu-blog-shortcodes' ); ?>" draggable="false" />
					</div>
				  <?php endforeach; ?>
				</div>
			  <?php else : ?>
				<!-- Infinite Marquee Layout -->
				<?php 
				// Split logos into 3 rows for marquee effect
				$chunks = array_chunk( $logos, max( 1, ceil( count( $logos ) / 3 ) ) );
				$speed = ! empty( $settings['marquee_speed']['size'] ) ? $settings['marquee_speed']['size'] : 75;
				?>
				<div class="brands-marquee-wrapper" style="--marquee-speed: <?php echo esc_attr( $speed ); ?>s;">
				  <div class="marquee-fade-left"></div>
				  <div class="marquee-fade-right"></div>

				  <div class="brands-grid">
					<?php foreach ( $chunks as $i => $chunk ) : 
						$direction_class = ($i % 2 === 0) ? 'row-left' : 'row-right';
					?>
					  <div class="brands-marquee-row <?php echo esc_attr( $direction_class ); ?>">
						<div class="brands-marquee-track">
						  <?php 
						  // Output twice to create seamless loop
						  foreach ( $chunk as $logo ) : ?>
							<div class="brand-item">
							  <img src="<?php echo esc_url( $logo['url'] ); ?>" class="brand-logo-img" alt="<?php echo esc_attr__( 'Brand Logo', 'uboontu-blog-shortcodes' ); ?>" draggable="false" />
							</div>
						  <?php endforeach; ?>
						  <?php foreach ( $chunk as $logo ) : ?>
							<div class="brand-item">
							  <img src="<?php echo esc_url( $logo['url'] ); ?>" class="brand-logo-img" alt="<?php echo esc_attr__( 'Brand Logo', 'uboontu-blog-shortcodes' ); ?>" draggable="false" />
							</div>
						  <?php endforeach; ?>
						</div>
					  </div>
					<?php endforeach; ?>
				  </div>
				</div>
			  <?php endif; ?>
			</div>
		  </section>
		</div>
		<?php
	}
}
