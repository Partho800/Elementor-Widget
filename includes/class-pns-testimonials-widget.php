<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class PNS_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'pns_testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonial', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'testimonials', 'review', 'reviews', 'client', 'feedback', 'grid' ];
	}

	public function get_style_depends() {
		return [ 'pns-blog-styles' ];
	}

	public function get_script_depends() {
		return [ 'pns-blog-scripts' ];
	}

	protected function register_controls() {

		// Section Header Controls
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header & Layout', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label' => esc_html__( 'Show Section Header', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'pns-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '', // Hides by default
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Voices Of Impact', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '<span class="elegant-serif">' . esc_html__( 'Testimonials', 'pns-addons-for-elementor' ) . '</span>',
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'desc_text',
			[
				'label' => esc_html__( 'Description Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Real feedback and reviews from happy clients and partners working with Raju.', 'pns-addons-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'marquee',
				'options' => [
					'marquee' => esc_html__( 'Autoplay Marquee', 'pns-addons-for-elementor' ),
					'grid' => esc_html__( 'Static Grid', 'pns-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => esc_html__( '1 Column', 'pns-addons-for-elementor' ),
					'2' => esc_html__( '2 Columns', 'pns-addons-for-elementor' ),
					'3' => esc_html__( '3 Columns', 'pns-addons-for-elementor' ),
					'4' => esc_html__( '4 Columns', 'pns-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .pns-testimonials-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'marquee_rows',
			[
				'label' => esc_html__( 'Marquee Rows', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => esc_html__( '1 Row', 'pns-addons-for-elementor' ),
					'2' => esc_html__( '2 Rows', 'pns-addons-for-elementor' ),
					'3' => esc_html__( '3 Rows', 'pns-addons-for-elementor' ),
				],
				'condition' => [
					'layout' => 'marquee',
				],
			]
		);

		$this->add_control(
			'marquee_speed',
			[
				'label' => esc_html__( 'Marquee Speed (Seconds)', 'pns-addons-for-elementor' ),
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
				'label' => esc_html__( 'Randomize Order', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'pns-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'pns-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label' => esc_html__( 'Card Height', 'pns-addons-for-elementor' ),
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
					'{{WRAPPER}} .pns-testimonial-card' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-testimonial-card' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label' => esc_html__( 'Card Border Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-testimonial-card' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_hover_border_color',
			[
				'label' => esc_html__( 'Card Hover Border Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pns-testimonial-card:hover' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .pns-testimonial-card:hover .pns-testimonial-name' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		// Testimonials Items Repeater Controls
		$this->start_controls_section(
			'testimonials_section',
			[
				'label' => esc_html__( 'Testimonials List', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'testimonial_text',
			[
				'label' => esc_html__( 'Testimonial Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Working with PNS was a great experience.', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'user_image',
			[
				'label' => esc_html__( 'User Photo', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'user_name',
			[
				'label' => esc_html__( 'User Name', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Client Name', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'user_title',
			[
				'label' => esc_html__( 'User Designation', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'CEO @ Company', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'testimonials_list',
			[
				'label' => esc_html__( 'Testimonials', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'user_name' => 'Jahnobi',
						'user_title' => 'CEO @ TechFlow',
						'testimonial_text' => '"Working with Raju was an absolute pleasure! He is exceptionally skilled, highly communicative, and delivered top-tier Elementor and web development work on time. Raju completely transformed our web presence beyond our expectations."',
					],
					[
						'user_name' => 'Sofia Gouveia',
						'user_title' => 'Marketing Manager @ Voc AI',
						'testimonial_text' => '"Raju is a truly professional and dependable developer. From sleek, modern UI designs to rock-solid custom functionality, Raju exceeded our expectations at every phase of the project. I highly recommend his services!"',
					],
					[
						'user_name' => 'Austin Miller',
						'user_title' => 'Founder @ LaunchPad',
						'testimonial_text' => '"We were blown away by Raju\'s lightning-fast delivery and attention to detail. Raju solved complex issues effortlessly and built a stunning, high-converting layout that our customers love."',
					],
					[
						'user_name' => 'Marcus Chen',
						'user_title' => 'CTO @ GreenTech',
						'testimonial_text' => '"A truly outstanding experience collaborating with Raju. His code quality, clean architecture, and responsive design expertise saved our team weeks of work. A 10/10 developer!"',
					],
					[
						'user_name' => 'Elena Rostova',
						'user_title' => 'Product Owner @ EcoSphere',
						'testimonial_text' => '"Raju is one of the most dedicated and talented developers I have ever hired. His prompt communication, creative problem solving, and technical precision are world-class."',
					],
					[
						'user_name' => 'David Kingsley',
						'user_title' => 'Director @ Nexus Group',
						'testimonial_text' => '"Raju brought our vision to life with flawless precision. His understanding of WordPress, Elementor, and modern aesthetics is exceptional. We look forward to working with him on our next big project!"',
					],
					[
						'user_name' => 'Sarah Jenkins',
						'user_title' => 'VP of Product @ Finflow',
						'testimonial_text' => '"Raju was proactive, attentive, and very quick to implement our requirements. He suggested great UX improvements that directly boosted our client engagement."',
					],
					[
						'user_name' => 'Liam O\'Connor',
						'user_title' => 'Marketing Director @ Peak Media',
						'testimonial_text' => '"Raju is a master of his craft. The custom animations and responsive layouts he built for us look gorgeous across all devices. We saw an immediate uptick in leads."',
					],
					[
						'user_name' => 'Aisha Rahman',
						'user_title' => 'UX Lead @ Spark Digital',
						'testimonial_text' => '"Incredible attention to detail, robust coding standards, and super fast page load speeds. Raju is our go-to expert for anything related to modern web development."',
					],
					[
						'user_name' => 'Hiroshi Tanaka',
						'user_title' => 'Operations Head @ Zenitsu',
						'testimonial_text' => '"Raju is hands down the best developer we have partnered with. Always reliable, deeply skilled, and delivered everything right on schedule. Highly recommended!"',
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
		  <section class="pns-testimonials-section" style="padding: 0; background: transparent;">
			<div class="pns-testimonials-container" style="padding: 0; max-width: 100%;">
			  
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
				  <div class="pns-testimonials-grid" style="padding: 0 24px;">
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
						<div class="pns-testimonial-card">
						  <div class="pns-testimonial-text">
							<?php echo esc_html( $item['testimonial_text'] ); ?>
						  </div>
						  
						  <div class="pns-testimonial-profile">
							<?php if ( ! empty( $photo_url ) ) : ?>
								<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $item['user_name'] ); ?>" class="pns-testimonial-avatar" />
							<?php else : ?>
								<div class="pns-testimonial-avatar">
									<?php echo esc_html( $initials ); ?>
								</div>
							<?php endif; ?>
							
							<div class="pns-testimonial-info">
							  <span class="pns-testimonial-name"><?php echo esc_html( $item['user_name'] ); ?></span>
							  <span class="pns-testimonial-title"><?php echo esc_html( $item['user_title'] ); ?></span>
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
				  <div class="pns-testimonials-marquee-wrapper" style="--marquee-speed: <?php echo esc_attr( $speed ); ?>s;">
					<div class="marquee-fade-left"></div>
					<div class="marquee-fade-right"></div>

					<div class="pns-testimonials-marquee-grid">
					  <?php foreach ( $chunks as $i => $chunk ) : 
						  $direction_class = ($i % 2 === 0) ? 'row-left' : 'row-right';
					  ?>
						<div class="pns-testimonials-marquee-row <?php echo esc_attr( $direction_class ); ?>">
						  <div class="pns-testimonials-marquee-track">
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
								<div class="pns-testimonial-card marquee-card">
								  <div class="pns-testimonial-text">
									<?php echo esc_html( $item['testimonial_text'] ); ?>
								  </div>
								  
								  <div class="pns-testimonial-profile">
									<?php if ( ! empty( $photo_url ) ) : ?>
										<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $item['user_name'] ); ?>" class="pns-testimonial-avatar" />
									<?php else : ?>
										<div class="pns-testimonial-avatar">
											<?php echo esc_html( $initials ); ?>
										</div>
									<?php endif; ?>
									
									<div class="pns-testimonial-info">
									  <span class="pns-testimonial-name"><?php echo esc_html( $item['user_name'] ); ?></span>
									  <span class="pns-testimonial-title"><?php echo esc_html( $item['user_title'] ); ?></span>
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


