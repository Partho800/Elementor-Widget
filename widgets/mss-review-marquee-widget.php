<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class MSS_Review_Marquee_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mss_review_marquee';
	}

	public function get_title() {
		return esc_html__( 'Modern Review Marquee', 'mss' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Reviews Content', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'review_text',
			[
				'label' => esc_html__( 'Review Text', 'mss' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Absolutely fantastic work! Highly recommended for any WordPress project.',
			]
		);

		$repeater->add_control(
			'user_name',
			[
				'label' => esc_html__( 'User Name', 'mss' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'John Doe',
			]
		);

		$repeater->add_control(
			'user_title',
			[
				'label' => esc_html__( 'User Title', 'mss' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'CEO, TechStart Inc.',
			]
		);

		$repeater->add_control(
			'user_image',
			[
				'label' => esc_html__( 'User Image', 'mss' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label' => esc_html__( 'Rating', 'mss' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'1' => '1 Star',
					'2' => '2 Stars',
					'3' => '3 Stars',
					'4' => '4 Stars',
					'5' => '5 Stars',
				],
			]
		);

		$this->add_control(
			'reviews_row_1',
			[
				'label' => esc_html__( 'Row 1 Reviews (Left to Right)', 'mss' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'user_name' => 'Emma Thompson' ],
					[ 'user_name' => 'David Chen' ],
					[ 'user_name' => 'Sarah Williams' ],
				],
				'title_field' => '{{{ user_name }}}',
			]
		);

		$this->add_control(
			'reviews_row_2',
			[
				'label' => esc_html__( 'Row 2 Reviews (Right to Left)', 'mss' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'user_name' => 'Michael Johnson' ],
					[ 'user_name' => 'Nina Brooks' ],
					[ 'user_name' => 'Robert Kim' ],
				],
				'title_field' => '{{{ user_name }}}',
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Animation Style', 'mss' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Speed (Seconds)', 'mss' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 30,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background', 'mss' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f9f7f2',
				'selectors' => [
					'{{WRAPPER}} .mss-review-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => esc_html__( 'Card Border', 'mss' ),
				'selector' => '{{WRAPPER}} .mss-review-card',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'mss' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .mss-review-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'mss' ),
				'selector' => '{{WRAPPER}} .mss-review-card',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$render_row = function( $reviews, $direction ) use ($settings) {
			$speed = $settings['speed'];
			?>
			<div class="mss-marquee-container <?php echo esc_attr($direction); ?>">
				<div class="mss-marquee-content" style="animation-duration: <?php echo esc_attr($speed); ?>s;">
					<?php 
					// Repeat twice for infinite effect
					for ($i=0; $i<2; $i++) :
						foreach ( $reviews as $item ) : ?>
							<div class="mss-review-card">
								<div class="mss-card-top">
									<div class="mss-rating">
										<?php for($s=0; $s<$item['rating']; $s++) echo '★'; ?>
									</div>
									<div class="mss-quote-icon">
										<i class="dashicons dashicons-format-quote"></i>
									</div>
								</div>
								<div class="mss-review-text">
									<?php echo esc_html($item['review_text']); ?>
								</div>
								<div class="mss-card-bottom">
									<div class="mss-user-avatar">
										<?php if ( ! empty( $item['user_image']['url'] ) ) : ?>
											<img src="<?php echo esc_url( $item['user_image']['url'] ); ?>" alt="User">
										<?php else : ?>
											<span><?php echo esc_html( substr($item['user_name'], 0, 1) ); ?></span>
										<?php endif; ?>
									</div>
									<div class="mss-user-info">
										<h4><?php echo esc_html($item['user_name']); ?></h4>
										<p><?php echo esc_html($item['user_title']); ?></p>
									</div>
								</div>
							</div>
						<?php endforeach;
					endfor; ?>
				</div>
			</div>
			<?php
		};

		echo '<div class="mss-review-marquee-wrapper">';
		$render_row($settings['reviews_row_1'], 'left-to-right');
		$render_row($settings['reviews_row_2'], 'right-to-left');
		echo '</div>';
	}
}
