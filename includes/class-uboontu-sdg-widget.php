<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Uboontu_SDG_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'uboontu_sdg_alignment';
	}

	public function get_title() {
		return esc_html__( 'SDG Alignment Grid', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-globe';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [ 'uboontu-blog-styles' ];
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
				'default' => '',
			]
		);

		$this->add_control(
			'show_bg_blobs',
			[
				'label' => esc_html__( 'Show Background Blobs', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'uboontu-blog-shortcodes' ),
				'label_off' => esc_html__( 'Hide', 'uboontu-blog-shortcodes' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'SDG Alignment', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Sustainable Development <span class="elegant-serif">Goals</span>', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'desc_text',
			[
				'label' => esc_html__( 'Description Text', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Achieving the Sustainable Development Goals requires urgent action to address climate change, biodiversity loss, and waste. Uboontu offers a unique opportunity to drive meaningful, cross-cutting impact across diverse sectors and communities.', 'uboontu-blog-shortcodes' ),
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
					'size' => 1252,
				],
				'selectors' => [
					'{{WRAPPER}} .sdg-container' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
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
					'{{WRAPPER}} .sdg-card-item' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sdg-card-item' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		// SDG Grid Items Controls
		$this->start_controls_section(
			'section_sdg_items',
			[
				'label' => esc_html__( 'SDG Items', 'uboontu-blog-shortcodes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'number',
			[
				'label' => esc_html__( 'Goal Number', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		$repeater->add_control(
			'theme',
			[
				'label' => esc_html__( 'Theme / Title', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'No Poverty', 'uboontu-blog-shortcodes' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => esc_html__( 'Brand / Goal Color', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e5243b',
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Background Image', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => plugins_url( 'assets/images/14 GOALS/img-goal-1.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ),
				],
			]
		);

		$repeater->add_control(
			'iconImage',
			[
				'label' => esc_html__( 'Icon Image', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-01.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ),
				],
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'End poverty in all its forms everywhere.', 'uboontu-blog-shortcodes' ),
			]
		);

		$repeater->add_control(
			'targets',
			[
				'label' => esc_html__( 'Targets count', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 7,
			]
		);

		$repeater->add_control(
			'events',
			[
				'label' => esc_html__( 'Events count', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 157,
			]
		);

		$repeater->add_control(
			'publications',
			[
				'label' => esc_html__( 'Publications count', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 51,
			]
		);

		$repeater->add_control(
			'actions',
			[
				'label' => esc_html__( 'Actions count', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1580,
			]
		);

		$this->add_control(
			'sdg_list',
			[
				'label' => esc_html__( 'SDG Cards List', 'uboontu-blog-shortcodes' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'number' => 1,
						'theme' => 'No Poverty',
						'color' => '#e5243b',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-1.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-01.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'End poverty in all its forms everywhere.',
						'targets' => 7,
						'events' => 157,
						'publications' => 51,
						'actions' => 1580,
					],
					[
						'number' => 3,
						'theme' => 'Good Health and Well-being',
						'color' => '#4c9f38',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-3.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-03.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Ensure healthy lives and promote well-being for all at all ages.',
						'targets' => 13,
						'events' => 79,
						'publications' => 50,
						'actions' => 1375,
					],
					[
						'number' => 5,
						'theme' => 'Gender Equality',
						'color' => '#ff3a21',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-5.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-05.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Achieve gender equality and empower all women and girls.',
						'targets' => 9,
						'events' => 117,
						'publications' => 49,
						'actions' => 1867,
					],
					[
						'number' => 6,
						'theme' => 'Clean Water and Sanitation',
						'color' => '#26b3c4',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-6.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-06.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Ensure availability and sustainable management of water and sanitation for all.',
						'targets' => 8,
						'events' => 321,
						'publications' => 38,
						'actions' => 1931,
					],
					[
						'number' => 7,
						'theme' => 'Affordable and Clean Energy',
						'color' => '#f2bc1c',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-7.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-07.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Ensure access to affordable, reliable, sustainable and modern energy for all.',
						'targets' => 5,
						'events' => 103,
						'publications' => 49,
						'actions' => 1103,
					],
					[
						'number' => 8,
						'theme' => 'Decent Work and Economic Growth',
						'color' => '#a21942',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-8.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-08.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all.',
						'targets' => 12,
						'events' => 142,
						'publications' => 51,
						'actions' => 2152,
					],
					[
						'number' => 9,
						'theme' => 'Industry, Innovation and Infrastructure',
						'color' => '#fd6925',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-9.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-09.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation.',
						'targets' => 8,
						'events' => 145,
						'publications' => 19,
						'actions' => 1183,
					],
					[
						'number' => 10,
						'theme' => 'Reduced Inequalities',
						'color' => '#dd1367',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-10.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-10.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Reduce inequality within and among countries.',
						'targets' => 10,
						'events' => 111,
						'publications' => 15,
						'actions' => 1092,
					],
					[
						'number' => 11,
						'theme' => 'Sustainable Cities and Communities',
						'color' => '#fd9d24',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-11.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-11.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Make cities and human settlements inclusive, safe, resilient and sustainable.',
						'targets' => 10,
						'events' => 156,
						'publications' => 25,
						'actions' => 1343,
					],
					[
						'number' => 12,
						'theme' => 'Responsible Consumption and Production',
						'color' => '#bf8d2c',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-12.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-12.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Ensure sustainable consumption and production patterns.',
						'targets' => 11,
						'events' => 68,
						'publications' => 19,
						'actions' => 1869,
					],
					[
						'number' => 13,
						'theme' => 'Climate Action',
						'color' => '#3f7e44',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-13.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-13.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Take urgent action to combat climate change and its impacts.',
						'targets' => 5,
						'events' => 93,
						'publications' => 40,
						'actions' => 2455,
					],
					[
						'number' => 14,
						'theme' => 'Life Below Water',
						'color' => '#0a97d9',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-14.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-14.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Conserve and sustainably use the oceans, seas and marine resources for sustainable development.',
						'targets' => 10,
						'events' => 150,
						'publications' => 44,
						'actions' => 3379,
					],
					[
						'number' => 15,
						'theme' => 'Life on Land',
						'color' => '#56c02b',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-15.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-15.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Protect, restore and promote sustainable use of terrestrial ecosystems, sustainably manage forests, combat desertification, and halt and reverse land degradation and halt biodiversity loss.',
						'targets' => 12,
						'events' => 62,
						'publications' => 35,
						'actions' => 1440,
					],
					[
						'number' => 17,
						'theme' => 'Partnerships for the Goals',
						'color' => '#19486a',
						'image' => [ 'url' => plugins_url( 'assets/images/14 GOALS/img-goal-17.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'iconImage' => [ 'url' => plugins_url( 'assets/images/14 GOALS/E_SDG_Icons-17.jpg', dirname( __DIR__ ) . '/elementor-addon.php' ) ],
						'desc' => 'Strengthen the means of implementation and revitalize the Global Partnership for Sustainable Development.',
						'targets' => 19,
						'events' => 392,
						'publications' => 85,
						'actions' => 2439,
					],
				],
				'title_field' => '{{{ theme }}} (Goal {{{ number }}})',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="blogs-page">
		  <section id="sdgs" class="section sdg-section" style="padding: 0; background: transparent;">
			<!-- Decorative background blobs -->
			<?php if ( 'yes' === $settings['show_bg_blobs'] ) : ?>
				<div class="sdg-bg-blob sdg-blob-tl"></div>
				<div class="sdg-bg-blob sdg-blob-br"></div>
			<?php endif; ?>

			<div class="sdg-container" style="padding: 0;">
			  <!-- Section Header -->
			  <?php if ( 'yes' === $settings['show_header'] ) : ?>
				  <div class="sdg-header-split">
					<div class="sdg-header-left">
					  <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<span class="badge badge-accent"><?php echo esc_html( $settings['badge_text'] ); ?></span>
					  <?php endif; ?>
					  
					  <?php if ( ! empty( $settings['title_text'] ) ) : ?>
						<h2><?php echo wp_kses( $settings['title_text'], array( 'span' => array( 'class' => array() ) ) ); ?></h2>
					  <?php endif; ?>

					  <?php if ( ! empty( $settings['desc_text'] ) ) : ?>
						<p class="sdg-header-desc">
						  <?php echo esc_html( $settings['desc_text'] ); ?>
						</p>
					  <?php endif; ?>
					</div>
				  </div>
			  <?php endif; ?>

			  <?php
			  $workspace_style = ( 'yes' !== $settings['show_header'] ) ? 'margin-top: 0;' : '';
			  ?>
			  <div class="sdg-workspace" style="<?php echo esc_attr( $workspace_style ); ?>">
				<!-- 6-Column SDG Cards Grid -->
				<div class="sdg-list">
				  <?php 
				  if ( ! empty( $settings['sdg_list'] ) ) :
					foreach ( $settings['sdg_list'] as $i => $group ) :
					  $real_num = ! empty( $group['number'] ) ? $group['number'] : ($i + 1);
					  $color = ! empty( $group['color'] ) ? $group['color'] : '#3BB852';
					  
					  // Handle media images from Elementor upload
					  $image_url = '';
					  if ( is_array( $group['image'] ) && ! empty( $group['image']['url'] ) ) {
						  $image_url = $group['image']['url'];
					  } elseif ( is_string( $group['image'] ) ) {
						  $image_url = $group['image'];
					  }

					  $icon_url = '';
					  if ( is_array( $group['iconImage'] ) && ! empty( $group['iconImage']['url'] ) ) {
						  $icon_url = $group['iconImage']['url'];
					  } elseif ( is_string( $group['iconImage'] ) ) {
						  $icon_url = $group['iconImage'];
					  }

					  // Auto-correct broken URLs saved in Elementor database from previous sessions
					  if ( strpos( $image_url, '/plugins/assets/images/' ) !== false ) {
						  $image_url = str_replace( '/plugins/assets/images/', '/plugins/uboontu-blog-shortcodes/assets/images/', $image_url );
					  }
					  if ( strpos( $icon_url, '/plugins/assets/images/' ) !== false ) {
						  $icon_url = str_replace( '/plugins/assets/images/', '/plugins/uboontu-blog-shortcodes/assets/images/', $icon_url );
					  }

					  // Match digit classes
					  $digit_class = ($real_num >= 10) ? 'double-digit' : 'single-digit';
					  $extra_cover = in_array( $real_num, array( 6, 8, 9 ) ) ? 'extra-cover' : '';
					  $shift_left = in_array( $real_num, array( 10, 12 ) ) ? 'shift-left' : '';
					  $shift_right = ($real_num === 5) ? 'shift-right' : '';
					  $shift_right_8 = ($real_num === 8) ? 'shift-right-8' : '';
					  
					  $mask_classes = implode( ' ', array_filter( array(
						  'sdg-card-icon-mask',
						  $digit_class,
						  $extra_cover,
						  $shift_left,
						  $shift_right,
						  $shift_right_8
					  ) ) );
				  ?>
					<div class="sdg-card-item" style="--group-color: <?php echo esc_attr( $color ); ?>;">
					  <div class="sdg-card-image-wrap">
						<div class="sdg-card-bg-image" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
						<div class="sdg-card-overlay"></div>
					  </div>
					  
					  <div class="sdg-card-icon-container">
						<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( $group['theme'] ); ?>" class="sdg-card-icon-img" />
						<div class="<?php echo esc_attr( $mask_classes ); ?>">
						  <?php echo esc_html( $real_num ); ?>
						</div>
					  </div>

					  <div class="sdg-card-hover-overlay">
						<div class="sdg-hover-number"><?php echo esc_html( $real_num ); ?></div>
						<div class="sdg-hover-content">
						  <h3 class="sdg-hover-title"><?php echo esc_html__( 'Goal', 'uboontu-blog-shortcodes' ) . ' ' . esc_html( $real_num ); ?></h3>
						  <p class="sdg-hover-desc"><?php echo esc_html( $group['desc'] ); ?></p>
						  <div class="sdg-hover-divider"></div>
						  <div class="sdg-hover-stats">
							<div class="sdg-stat-item">
							  <span class="sdg-stat-val"><?php echo esc_html( $group['targets'] ); ?></span>
							  <span class="sdg-stat-lbl"><?php esc_html_e( 'Targets', 'uboontu-blog-shortcodes' ); ?></span>
							</div>
							<div class="sdg-stat-item">
							  <span class="sdg-stat-val"><?php echo esc_html( $group['events'] ); ?></span>
							  <span class="sdg-stat-lbl"><?php esc_html_e( 'Events', 'uboontu-blog-shortcodes' ); ?></span>
							</div>
							<div class="sdg-stat-item">
							  <span class="sdg-stat-val"><?php echo esc_html( $group['publications'] ); ?></span>
							  <span class="sdg-stat-lbl"><?php esc_html_e( 'Publications', 'uboontu-blog-shortcodes' ); ?></span>
							</div>
							<div class="sdg-stat-item">
							  <span class="sdg-stat-val"><?php echo esc_html( $group['actions'] ); ?></span>
							  <span class="sdg-stat-lbl"><?php esc_html_e( 'Actions', 'uboontu-blog-shortcodes' ); ?></span>
							</div>
						  </div>
						  <div class="sdg-hover-btn"><?php esc_html_e( 'More info', 'uboontu-blog-shortcodes' ); ?></div>
						</div>
					  </div>
					</div>
				  <?php 
					endforeach;
				  endif; 
				  ?>
				</div>
			  </div>
			</div>
		  </section>
		</div>
		<?php
	}
}
