<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class PNS_Services_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'pns_core_services';
	}

	public function get_title() {
		return esc_html__( 'Card Grid', 'pns-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-apps';
	}

	public function get_categories() {
		return [ 'pns-addons-category' ];
	}

	public function get_style_depends() {
		return [ 'pns-blog-styles' ];
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
				'default' => '',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'WHAT WE DO', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Our Core <span class="elegant-serif">Services</span>', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'desc_text',
			[
				'label' => esc_html__( 'Description Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Comprehensive systems and methodologies that build sustainable, zero-waste ecosystems for a greener tomorrow.', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => esc_html__( 'Content Max Width', 'pns-addons-for-elementor' ),
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
					'size' => 1252,
				],
				'selectors' => [
					'{{WRAPPER}} .wwd-container' => 'max-width: {{SIZE}}{{UNIT}} !important; margin: 0 auto;',
				],
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
					'{{WRAPPER}} .wwd-card' => 'height: {{SIZE}}{{UNIT}} !important; min-height: 0 !important;',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wwd-card' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		// Services Items Controls
		$this->start_controls_section(
			'section_services_items',
			[
				'label' => esc_html__( 'Service Cards', 'pns-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'number',
			[
				'label' => esc_html__( 'Step/Card Number', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '01',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Card Title', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Service Title', 'pns-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => esc_html__( 'Accent Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#3BB852',
			]
		);

		$repeater->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Icon Background Color', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(59, 184, 82, 0.12)',
			]
		);

		$repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon Source', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__( 'Icon Library', 'pns-addons-for-elementor' ),
					'image' => esc_html__( 'Custom Image', 'pns-addons-for-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'elementor_icon',
			[
				'label' => esc_html__( 'Icon', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bullhorn',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label' => esc_html__( 'Custom Icon Image', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Empowering citizens with environmental knowledge and waste separation advocacy.', 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'pns-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'link_url',
			[
				'label' => esc_html__( 'Link URL', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'pns-addons-for-elementor' ),
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'services_list',
			[
				'label' => esc_html__( 'Service Cards List', 'pns-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'number' => '01',
						'title' => 'Awareness and Advocacy',
						'color' => '#3BB852',
						'bg_color' => 'rgba(59, 184, 82, 0.12)',
						'icon_type' => 'icon',
						'elementor_icon' => [
							'value' => 'fas fa-bullhorn',
							'library' => 'fa-solid',
						],
						'desc' => 'Empowering citizens with environmental knowledge and waste separation advocacy.',
						'link_text' => 'Learn More',
					],
					[
						'number' => '02',
						'title' => 'Capacity Building of ULBs & PRIs',
						'color' => '#0d9488',
						'bg_color' => 'rgba(13, 148, 136, 0.12)',
						'icon_type' => 'icon',
						'elementor_icon' => [
							'value' => 'fas fa-building',
							'library' => 'fa-solid',
						],
						'desc' => 'Training municipalities and rural bodies for sustainable policy implementations.',
						'link_text' => 'Learn More',
					],
					[
						'number' => '03',
						'title' => 'Setting Up End to End SWM',
						'color' => '#d97706',
						'bg_color' => 'rgba(217, 119, 6, 0.12)',
						'icon_type' => 'icon',
						'elementor_icon' => [
							'value' => 'fas fa-project-diagram',
							'library' => 'fa-solid',
						],
						'desc' => 'Deploying complete, sustainable waste collection and processing systems.',
						'link_text' => 'Learn More',
					],
				],
				'title_field' => '{{{ title }}} (Step {{{ number }}})',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="blogs-page">
		  <section class="section what-we-do-section" style="padding: 0; background: transparent;">
			<div class="wwd-container">
			  <!-- Section Header -->
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

			  <!-- Cards Grid -->
			  <div class="wwd-grid">
				  <?php 
				  if ( ! empty( $settings['services_list'] ) ) :
					foreach ( $settings['services_list'] as $i => $item ) :
					  $display_index = ! empty( $item['number'] ) ? $item['number'] : sprintf( '%02d', $i + 1 );
					  $color = ! empty( $item['color'] ) ? $item['color'] : '#3BB852';
					  $bg_color = ! empty( $item['bg_color'] ) ? $item['bg_color'] : 'rgba(59, 184, 82, 0.12)';
					  
					  $icon_image_url = '';
					  if ( 'image' === $item['icon_type'] ) {
						  if ( is_array( $item['icon_image'] ) && ! empty( $item['icon_image']['url'] ) ) {
							  $icon_image_url = $item['icon_image']['url'];
						  } elseif ( is_string( $item['icon_image'] ) ) {
							  $icon_image_url = $item['icon_image'];
						  }
					  }
				  ?>
					<div class="wwd-card card glass-panel" style="--ac: <?php echo esc_attr( $color ); ?>;">
					  <div class="wwd-card-glow"></div>
					  <div class="wwd-icon-row">
						<div class="wwd-icon" style="background: <?php echo esc_attr( $bg_color ); ?>; color: <?php echo esc_attr( $color ); ?>;">
						  <?php if ( 'image' === $item['icon_type'] && ! empty( $icon_image_url ) ) : ?>
							<img src="<?php echo esc_url( $icon_image_url ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" style="max-width: 32px; max-height: 32px; object-fit: contain;" />
						  <?php elseif ( ! empty( $item['elementor_icon']['value'] ) ) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $item['elementor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						  <?php endif; ?>
						</div>
						<span class="wwd-number"><?php echo esc_html( $display_index ); ?></span>
					  </div>
					  <div class="wwd-card-content">
						<h3 class="wwd-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="wwd-desc"><?php echo esc_html( $item['desc'] ); ?></p>
					  </div>
					  <?php if ( ! empty( $item['link_text'] ) ) : ?>
						<?php 
						$url = ! empty( $item['link_url']['url'] ) ? $item['link_url']['url'] : '#';
						?>
						<div class="wwd-card-footer">
						  <a href="<?php echo esc_url( $url ); ?>" class="wwd-explore"<?php if ( ! empty( $item['link_url']['is_external'] ) ) : ?> target="_blank"<?php endif; ?><?php if ( ! empty( $item['link_url']['nofollow'] ) ) : ?> rel="nofollow"<?php endif; ?>>
							<?php echo esc_html( $item['link_text'] ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
						  </a>
						</div>
					  <?php endif; ?>
					</div>
				  <?php 
					endforeach;
				  endif; 
				  ?>
			  </div>
			</div>
		  </section>
		</div>
		<?php
	}
}


