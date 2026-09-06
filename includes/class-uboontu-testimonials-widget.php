<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Uboontu_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'uboontu_testimonials';
	}

	public function get_title() {
		return esc_html__( 'Client Testimonials Grid', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_style_depends() {
		return [ 'uboontu-blog-styles' ];
	}

	public function get_script_depends() {
		return [ 'uboontu-blog-scripts' ];
	}

	protected function register_controls() {

		// Section Header Controls
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header & Layout', 'uboontu-blog-shortcodes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label' => esc_html__( 'Show Section Header', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'uboontu-blog-shortcodes' ),
				'label_off' => esc_html__( 'Hide', 'uboontu-blog-shortcodes' ),
				'return_value' => 'yes',
				'default' => '', // Hides by default
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Voices Of Impact', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( '<span class="elegant-serif">Testimonials</span>', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'desc_text',
			[
				'label' => esc_html__( 'Description Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Feedback from our valued partners and community members.', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'marquee',
				'options' => [
					'marquee' => esc_html__( 'Autoplay Marquee', 'uboontu-blog-shortcodes' ),
					'grid' => esc_html__( 'Static Grid', 'uboontu-blog-shortcodes' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => esc_html__( '1 Column', 'uboontu-blog-shortcodes' ),
					'2' => esc_html__( '2 Columns', 'uboontu-blog-shortcodes' ),
					'3' => esc_html__( '3 Columns', 'uboontu-blog-shortcodes' ),
					'4' => esc_html__( '4 Columns', 'uboontu-blog-shortcodes' ),
				],
				'selectors' => [
					'{{WRAPPER}} .uboontu-testimonials-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'marquee_rows',
			[
				'label' => esc_html__( 'Marquee Rows', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => esc_html__( '1 Row', 'uboontu-blog-shortcodes' ),
					'2' => esc_html__( '2 Rows', 'uboontu-blog-shortcodes' ),
					'3' => esc_html__( '3 Rows', 'uboontu-blog-shortcodes' ),
				],
				'condition' => [
					'layout' => 'marquee',
				],
			]
		);

		$this->add_control(
			'marquee_speed',
			[
				'label' => esc_html__( 'Marquee Speed (Seconds)', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 150,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 50,
				],
				'condition' => [
					'layout' => 'marquee',
				],
			]
		);

		$this->add_control(
			'randomize',
			[
				'label' => esc_html__( 'Randomize Order', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'uboontu-blog-shortcodes' ),
				'label_off' => esc_html__( 'No', 'uboontu-blog-shortcodes' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label' => esc_html__( 'Card Height', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uboontu-testimonial-card' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uboontu-testimonial-card' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label' => esc_html__( 'Card Border Color', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uboontu-testimonial-card' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_hover_border_color',
			[
				'label' => esc_html__( 'Card Hover Border Color', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uboontu-testimonial-card:hover' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .uboontu-testimonial-card:hover .uboontu-testimonial-name' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		// Testimonials Items Repeater Controls
		$this->start_controls_section(
			'testimonials_section',
			[
				'label' => esc_html__( 'Testimonials List', 'uboontu-blog-shortcodes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'testimonial_text',
			[
				'label' => esc_html__( 'Testimonial Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Working with Uboontu was a great experience.', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'user_image',
			[
				'label' => esc_html__( 'User Photo', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'user_name',
			[
				'label' => esc_html__( 'User Name', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Client Name', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'user_title',
			[
				'label' => esc_html__( 'User Designation', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'CEO @ Company', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'testimonials_list',
			[
				'label' => esc_html__( 'Testimonials', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'user_name' => 'Jahnobi',
						'user_title' => 'CEO @ TechFlow',
						'testimonial_text' => '"Working with Uboontu was a great experience. They were responsible, communicative, and delivered excellent design work. Their team really understood our vision and translated it into a product that exceeded our expectations in every way possible."',
					],
					[
						'user_name' => 'Sofia Gouveia',
						'user_title' => 'Marketing Manager @ Voc AI',
						'testimonial_text' => '"Uboontu is a professional, reliable partner for end-to-end product builds. From clean, modern UI designs to robust backend logic, they exceed expectations at every single step of the process. I highly recommend working with them!"',
					],
					[
						'user_name' => 'Austin',
						'user_title' => 'Founder @ LaunchPad',
						'testimonial_text' => '"We were amazed by the speed and quality of delivery. The team helped us redefine our branding and built an incredible dashboard that our users absolutely love. Their communication and attention to detail are top-notch."',
					],
					[
						'user_name' => 'Marcus Chen',
						'user_title' => 'CTO @ GreenTech',
						'testimonial_text' => '"A truly outstanding experience from start to finish. The widget library and design patterns they implemented saved us months of frontend development. Highly recommended for any modern development project."',
					],
					[
						'user_name' => 'Elena Rostova',
						'user_title' => 'Product Owner @ EcoSphere',
						'testimonial_text' => '"Excellent communication, outstanding design quality, and deep technical expertise. They delivered a high-performance system that is scalable, clean, and extremely easy to manage. Five stars all around!"',
					],
					[
						'user_name' => 'David K.',
						'user_title' => 'Director @ Nexus Group',
						'testimonial_text' => '"They brought our ideas to life with an exceptional level of precision. The integration with our existing systems was seamless, and the styling parity is exactly what we were looking for."',
					],
					[
						'user_name' => 'Sarah Jenkins',
						'user_title' => 'VP of Product @ Finflow',
						'testimonial_text' => '"The team was proactive, highly skilled, and extremely responsive. They didn\'t just write code; they provided valuable architectural feedback that improved our overall product performance."',
					],
					[
						'user_name' => 'Liam O\'Connor',
						'user_title' => 'Marketing Director @ Peak',
						'testimonial_text' => '"We\'ve worked with many teams, but the level of execution here is unmatched. The clean aesthetics and modern animations in the UI have significantly increased our customer conversion rates."',
					],
					[
						'user_name' => 'Aisha Rahman',
						'user_title' => 'UX Lead @ Spark Digital',
						'testimonial_text' => '"Incredible attention to detail, robust code, and beautiful responsive layouts. Our pages now load faster and look gorgeous on all screen sizes, from mobile to ultra-wide monitors."',
					],
					[
						'user_name' => 'Hiroshi Tanaka',
						'user_title' => 'Operations Head @ Zenitsu',
						'testimonial_text' => '"The best development partner we have ever worked with. They delivered the project on time, under budget, and exceeded our design specifications. We will definitely work with them again."',
					],
				],
				'title_field' => '{{{ user_name }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$testimonials = ! empty( $settings['testimonials_list'] ) ? $settings['testimonials_list'] : [];

		if ( empty( $testimonials ) ) {
			return;
		}

		if ( 'yes' === $settings['randomize'] ) {
			shuffle( $testimonials );
		}
		?>
		<div class="blogs-page">
		  <section class="uboontu-testimonials-section" style="padding: 0; background: transparent;">
			<div class="uboontu-testimonials-container" style="padding: 0; max-width: 100%;">
			  
			  <!-- Optional Section Header -->
			  <?php if ( 'yes' === $settings['show_header'] ) : ?>
				  <div class="sdg-header-split" style="text-align: center; justify-content: center; margin-bottom: 50px;">
					<div class="sdg-header-left" style="max-width: 700px; margin: 0 auto; text-align: center;">
					  <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<span class="badge badge-accent" style="margin: 0 auto 18px auto; display: inline-block;"><?php echo esc_html( $settings['badge_text'] ); ?></span>
					  <?php endif; ?>
					  
					  <?php if ( ! empty( $settings['title_text'] ) ) : ?>
						<h2 style="font-size: 44px; font-weight: 700; line-height: 54px; margin-bottom: 20px;"><?php echo wp_kses( $settings['title_text'], array( 'span' => array( 'class' => array() ) ) ); ?></h2>
					  <?php endif; ?>

					  <?php if ( ! empty( $settings['desc_text'] ) ) : ?>
						<p class="sdg-header-desc" style="margin: 0 auto; font-size: 16px; line-height: 1.6; color: var(--text-secondary);">
						  <?php echo esc_html( $settings['desc_text'] ); ?>
						</p>
					  <?php endif; ?>
					</div>
				  </div>
			  <?php endif; ?>

			  <?php if ( 'grid' === $settings['layout'] ) : ?>
				  <!-- Testimonials Grid Layout -->
				  <div class="uboontu-testimonials-grid" style="padding: 0 24px;">
					<?php 
					foreach ( $testimonials as $item ) :
						$photo_url = '';
						if ( is_array( $item['user_image'] ) && ! empty( $item['user_image']['url'] ) ) {
							$photo_url = $item['user_image']['url'];
						}

						// Calculate initials for fallback
						$initials = '';
						if ( ! empty( $item['user_name'] ) ) {
							$words = explode( ' ', $item['user_name'] );
							foreach ( $words as $w ) {
								$initials .= strtoupper( substr( $w, 0, 1 ) );
							}
							$initials = substr( $initials, 0, 2 );
						}
					?>
						<div class="uboontu-testimonial-card">
						  <div class="uboontu-testimonial-text">
							<?php echo esc_html( $item['testimonial_text'] ); ?>
						  </div>
						  
						  <div class="uboontu-testimonial-profile">
							<?php if ( ! empty( $photo_url ) ) : ?>
								<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $item['user_name'] ); ?>" class="uboontu-testimonial-avatar" />
							<?php else : ?>
								<div class="uboontu-testimonial-avatar">
									<?php echo esc_html( $initials ); ?>
								</div>
							<?php endif; ?>
							
							<div class="uboontu-testimonial-info">
							  <span class="uboontu-testimonial-name"><?php echo esc_html( $item['user_name'] ); ?></span>
							  <span class="uboontu-testimonial-title"><?php echo esc_html( $item['user_title'] ); ?></span>
							</div>
						  </div>
						</div>
					<?php 
					endforeach; 
					?>
				  </div>

			  <?php else : ?>
				  <!-- Testimonials Autoplay Marquee Layout -->
				  <?php 
				  $rows_count = intval( $settings['marquee_rows'] );
				  $chunks = array_chunk( $testimonials, max( 1, ceil( count( $testimonials ) / $rows_count ) ) );
				  $speed = ! empty( $settings['marquee_speed']['size'] ) ? $settings['marquee_speed']['size'] : 50;
				  ?>
				  <div class="uboontu-testimonials-marquee-wrapper" style="--marquee-speed: <?php echo esc_attr( $speed ); ?>s;">
					<div class="marquee-fade-left"></div>
					<div class="marquee-fade-right"></div>

					<div class="uboontu-testimonials-marquee-grid">
					  <?php foreach ( $chunks as $i => $chunk ) : 
						  $direction_class = ($i % 2 === 0) ? 'row-left' : 'row-right';
					  ?>
						<div class="uboontu-testimonials-marquee-row <?php echo esc_attr( $direction_class ); ?>">
						  <div class="uboontu-testimonials-marquee-track">
							<?php 
							// Output twice to create a seamless looping marquee
							for ( $cycle = 0; $cycle < 2; $cycle++ ) :
								foreach ( $chunk as $item ) :
									$photo_url = '';
									if ( is_array( $item['user_image'] ) && ! empty( $item['user_image']['url'] ) ) {
										$photo_url = $item['user_image']['url'];
									}
									$initials = '';
									if ( ! empty( $item['user_name'] ) ) {
										$words = explode( ' ', $item['user_name'] );
										foreach ( $words as $w ) {
											$initials .= strtoupper( substr( $w, 0, 1 ) );
										}
										$initials = substr( $initials, 0, 2 );
									}
							?>
								<div class="uboontu-testimonial-card marquee-card">
								  <div class="uboontu-testimonial-text">
									<?php echo esc_html( $item['testimonial_text'] ); ?>
								  </div>
								  
								  <div class="uboontu-testimonial-profile">
									<?php if ( ! empty( $photo_url ) ) : ?>
										<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $item['user_name'] ); ?>" class="uboontu-testimonial-avatar" />
									<?php else : ?>
										<div class="uboontu-testimonial-avatar">
											<?php echo esc_html( $initials ); ?>
										</div>
									<?php endif; ?>
									
									<div class="uboontu-testimonial-info">
									  <span class="uboontu-testimonial-name"><?php echo esc_html( $item['user_name'] ); ?></span>
									  <span class="uboontu-testimonial-title"><?php echo esc_html( $item['user_title'] ); ?></span>
									</div>
								  </div>
								</div>
							<?php 
								endforeach;
							endfor; 
							?>
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
