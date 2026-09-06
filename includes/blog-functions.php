<?php
/**
 * Plugin Name: Uboontu
 * Description: Integrates Next.js inspired Uboontu Blog listing and Single Blog templates. Use Shortcode: <code>[uboontu_blog]</code>.
 * Version: 1.0.0
 * Author: Raju
 * Author URI: https://pnscode.com/
 * License: GPL2
 * Text Domain: Uboontu
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register and enqueue assets.
 * We only register them here. They are enqueued conditionally inside the shortcode execution.
 */
function uboontu_blog_register_assets() {
    // 1. Google Fonts
    wp_register_style(
        'uboontu-blog-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Red+Hat+Display:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    // 2. CSS Stylesheet (Scoped to not break theme design)
    $css_file = dirname( __DIR__ ) . '/assets/css/blog-styles.css';
    $css_ver  = file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0';
    wp_register_style(
        'uboontu-blog-styles',
        plugins_url( 'assets/css/blog-styles.css', dirname( __DIR__ ) . '/elementor-addon.php' ),
        array( 'uboontu-blog-fonts' ),
        $css_ver
    );

    // 3. Javascript Bundle for Filters, Pagination, TOC and Share logic
    $js_file = dirname( __DIR__ ) . '/assets/js/blog-scripts.js';
    $js_ver  = file_exists( $js_file ) ? filemtime( $js_file ) : '1.0.0';
    wp_register_script(
        'uboontu-blog-scripts',
        plugins_url( 'assets/js/blog-scripts.js', dirname( __DIR__ ) . '/elementor-addon.php' ),
        array(),
        $js_ver,
        true // Enqueue in footer
    );
}
add_action( 'wp_enqueue_scripts', 'uboontu_blog_register_assets' );

/**
 * Seed data matching the Next.js database for testing and instant preview.
 */
function uboontu_get_default_seed_posts() {
    return array(
        array(
            'id'          => 1,
            'slug'        => 'transforming-urban-waste-manbhar-project',
            'title'       => "Transforming Urban Waste: The Journey of Uboontu's Manbhar Project",
            'excerpt'     => "Discover how the Manbhar Project is pioneering municipal solid waste management, cleaning up landfill sites, and creating clean communities through sustainable practices.",
            'content'     => "<h2>Municipal solid waste is one of the most pressing challenges facing urban areas today...</h2><p>Urban waste accumulation has reached unprecedented levels. The Manbhar Project was initiated to address this issue by introducing source segregation, composting, and community recycling systems.</p><h2>The Core Methodology</h2><p>We work closely with local municipal bodies and households to ensure that dry and wet waste are separated at the source. This is then processed at our state-of-the-art decentralized Material Recovery Facilities (MRFs).</p><h2>Social Impacts and Worker Dignity</h2><p>Beyond cleanliness, the project integrates local informal waste workers (Safai Sathis), offering them structured livelihoods, protective gear, and health benefits, transitioning them from hazardous informal sorting to formal, dignified roles.</p><h2>A Scalable Circular Model</h2><p>Manbhar is not just a cleaning drive; it's a scalable circular economy blueprint. Wet waste is dynamically converted to organic compost, and dry plastics are sorted into 40+ categories for direct industrial upcycling, reducing landfill dependence to under 10%.</p>",
            'category'    => 'Waste Management',
            'tags'        => array('Waste Management', 'Recycling', 'Composting', 'Community'),
            'date'        => 'July 10, 2026',
            'readTime'    => '6 min read',
            'image'       => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=800&q=80',
            'isFeatured'  => true,
            'author'      => 'Super Admin User'
        ),
        array(
            'id'          => 2,
            'slug'        => 'understanding-3rs-reduce-reuse-recycle',
            'title'       => 'Understanding the 3Rs: Reduce, Reuse, Recycle in Modern Communities',
            'excerpt'     => 'A practical guide to implementing the 3R principles in daily households to reduce municipal load and support circular economy practices.',
            'content'     => "<h2>Understanding the 3Rs</h2><p>In a world dominated by single-use products, the concept of a circular economy is more vital than ever.</p><h2>Reduce</h2><p>The first step is always to reduce the amount of waste generated. This means choosing products with minimal packaging and opting for durable goods over single-use items.</p><h2>Reuse</h2><p>Reusing containers, donating old clothes, and finding new purposes for household items helps extend their lifecycle.</p><h2>Recycle</h2><p>Finally, recycling ensures that materials are reprocessed into new raw resources rather than ending up in landfills. At our facilities, sorted materials are bundled and shipped to eco-conscious recyclers.</p><h2>Source Segregation is Key</h2><p>Recycling is only effective when waste is free from contamination. Mixing kitchen wastes with plastic makes the plastic unrecyclable. That's why separating your household waste into separate wet, dry, and sanitary bins is the single most powerful action you can take.</p>",
            'category'    => 'Circular Economy',
            'tags'        => array('3Rs', 'Recycling', 'Circular Economy', 'Sustainability'),
            'date'        => 'July 02, 2026',
            'readTime'    => '4 min read',
            'image'       => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=800&q=80',
            'isFeatured'  => false,
            'author'      => 'Editor User'
        ),
        array(
            'id'          => 3,
            'slug'        => 'empowering-youth-environmental-education',
            'title'       => 'Empowering Youth: The Role of Environmental Education in Schools',
            'excerpt'     => 'How Uboontu Foundation is setting up active eco-clubs, school awareness campaigns, and composting training.',
            'content'     => "<h2>Empowering Youth</h2><p>Sustainable habits are best formed early in life.</p><h2>Setting Up School Eco-Clubs</h2><p>Our environmental education programs focus on hands-on learning. We establish eco-clubs where students lead green audits and waste management workshops in their schools.</p><h2>Composting Training</h2><p>We train students and teachers in composting organic school canteen waste, creating high-quality fertilizer for school gardens.</p><h2>Building Green Leadership</h2><p>Students participate in interactive field trips to our MRFs. Seeing thousands of tons of waste being sorted on-site leaves a lasting impression, turning students into active environment advocates at home and in their neighborhoods.</p>",
            'category'    => 'Community Development',
            'tags'        => array('Education', 'Youth', 'Composting', 'Eco-clubs'),
            'date'        => 'June 25, 2026',
            'readTime'    => '5 min read',
            'image'       => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=800&q=80',
            'isFeatured'  => false,
            'author'      => 'Admin User'
        )
    );
}

/**
 * Fetch posts and format them to match the Next.js database schema.
 */
function uboontu_get_blog_posts( $category_slug = '' ) {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ( ! empty( $category_slug ) ) {
        $args['category_name'] = $category_slug;
    }

    $wp_posts = get_posts( $args );

    // If no WordPress posts exist, fall back to our premium seed posts
    if ( empty( $wp_posts ) ) {
        $seed_posts = uboontu_get_default_seed_posts();
        if ( ! empty( $category_slug ) ) {
            $seed_posts = array_filter( $seed_posts, function( $p ) use ( $category_slug ) {
                return strtolower( $p['category'] ) === strtolower( $category_slug );
            });
        }
        return array_values( $seed_posts );
    }

    $posts_data = array();
    foreach ( $wp_posts as $p ) {
        $categories = get_the_category( $p->ID );
        $category_name = ! empty( $categories ) ? $categories[0]->name : 'General';

        $tags = wp_get_post_tags( $p->ID );
        $tags_array = array();
        foreach ( $tags as $t ) {
            $tags_array[] = $t->name;
        }

        $featured_image_url = get_the_post_thumbnail_url( $p->ID, 'large' );
        if ( ! $featured_image_url ) {
            $featured_image_url = plugins_url('assets/images/image (1).webp', dirname(__DIR__) . '/elementor-addon.php');
        }

        // Check if there is a custom read time, otherwise auto calculate
        $read_time = get_post_meta( $p->ID, 'read_time', true );
        if ( ! $read_time ) {
            $word_count = str_word_count( strip_tags( $p->post_content ) );
            $minutes = ceil( $word_count / 200 );
            $read_time = $minutes . ' min read';
        }

        $author_name = get_the_author_meta( 'display_name', $p->post_author );

        $excerpt = $p->post_excerpt;
        if ( empty( $excerpt ) ) {
            $excerpt = wp_strip_all_tags( $p->post_content );
            if ( mb_strlen( $excerpt ) > 150 ) {
                $excerpt = mb_substr( $excerpt, 0, 150 ) . '...';
            }
        }

        $posts_data[] = array(
            'id'          => $p->ID,
            'slug'        => $p->post_name,
            'title'       => get_the_title( $p->ID ),
            'excerpt'     => $excerpt,
            'content'     => apply_filters( 'the_content', $p->post_content ),
            'category'    => $category_name,
            'tags'        => $tags_array,
            'date'        => get_the_date( 'F d, Y', $p->ID ),
            'readTime'    => $read_time,
            'image'       => $featured_image_url,
            'isFeatured'  => has_category( 'featured', $p->ID ),
            'author'      => $author_name
        );
    }

    return $posts_data;
}

/**
 * Fetch related posts (excluding the current one).
 */
function uboontu_get_related_posts( $current_post_id, $count = 3 ) {
    $all_posts = uboontu_get_blog_posts();

    $filtered = array_filter( $all_posts, function( $p ) use ( $current_post_id ) {
        return (int) $p['id'] !== (int) $current_post_id;
    });

    return array_slice( array_values( $filtered ), 0, $count );
}

/**
 * Single blog post template generator.
 */
function uboontu_render_single_blog( $slug ) {
    // 1. Check for native WordPress post
    $args = array(
        'name'        => $slug,
        'post_type'   => 'post',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $posts = get_posts( $args );

    $post_data = null;
    if ( ! empty( $posts ) ) {
        $p = $posts[0];
        $post_id = $p->ID;

        $categories = get_the_category( $p->ID );
        $category_name = ! empty( $categories ) ? $categories[0]->name : 'General';

        $featured_image_url = get_the_post_thumbnail_url( $p->ID, 'large' );
        if ( ! $featured_image_url ) {
            $featured_image_url = plugins_url('assets/images/image (1).webp', dirname(__DIR__) . '/elementor-addon.php');
        }

        $read_time = get_post_meta( $p->ID, 'read_time', true );
        if ( ! $read_time ) {
            $word_count = str_word_count( strip_tags( $p->post_content ) );
            $minutes = ceil( $word_count / 200 );
            $read_time = $minutes . ' min read';
        }

        $author_name = get_the_author_meta( 'display_name', $p->post_author );

        $excerpt = $p->post_excerpt;
        if ( empty( $excerpt ) ) {
            $excerpt = wp_strip_all_tags( $p->post_content );
            if ( mb_strlen( $excerpt ) > 150 ) {
                $excerpt = mb_substr( $excerpt, 0, 150 ) . '...';
            }
        }

        $post_data = array(
            'id'          => $p->ID,
            'slug'        => $p->post_name,
            'title'       => get_the_title( $p->ID ),
            'excerpt'     => $excerpt,
            'content'     => apply_filters( 'the_content', $p->post_content ),
            'category'    => $category_name,
            'date'        => get_the_date( 'F d, Y', $p->ID ),
            'readTime'    => $read_time,
            'image'       => $featured_image_url,
            'author'      => $author_name
        );
    } else {
        // 2. Check for seed data matching the slug
        $seed_posts = uboontu_get_default_seed_posts();
        foreach ( $seed_posts as $sp ) {
            if ( $sp['slug'] === $slug ) {
                $post_data = $sp;
                break;
            }
        }
    }

    // If blog slug is invalid or not found
    if ( ! $post_data ) {
        return sprintf(
            '<div class="blogs-page blogs-page-layout"><section class="blogs-listing" style="text-align: center; padding: 100px 0;"><h2 style="color: var(--text-primary); margin-bottom: 20px;">%s</h2><p><a href="%s" class="single-blog-view-more-btn" style="display:inline-flex;">%s</a></p></section></div>',
            esc_html__( 'Blog post not found.', 'uboontu-blog-shortcodes' ),
            esc_url( remove_query_arg( 'blog_slug' ) ),
            esc_html__( 'Back to Blogs', 'uboontu-blog-shortcodes' )
        );
    }

    $post_id       = $post_data['id'];
    $title         = $post_data['title'];
    $excerpt       = $post_data['excerpt'];
    $content       = $post_data['content'];
    $category_name = $post_data['category'];
    $date_label    = $post_data['date'];
    $image_url     = $post_data['image'];
    $author_name   = $post_data['author'];

    ob_start();
    ?>
    <div class="blogs-page blogs-page-layout">
      <!-- HERO HEADER SECTION -->
      <section class="single-blog-hero" style="background-image: url('<?php echo esc_url( plugins_url('assets/images/blog-hero-bg.webp', dirname(__DIR__) . '/elementor-addon.php') ); ?>')">
        <div class="single-blog-hero-overlay"></div>
        <div class="single-blog-hero-inner">
          <div class="blogs-brand-link">
            <h1 class="blogs-brand"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
          </div>
          <div class="single-blog-breadcrumb">
            <a href="<?php echo esc_url( remove_query_arg( 'blog_slug' ) ); ?>"><?php esc_html_e( 'Blogs', 'uboontu-blog-shortcodes' ); ?></a>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-current"><?php esc_html_e( 'Blog details', 'uboontu-blog-shortcodes' ); ?></span>
          </div>

          <h1 class="single-blog-title">
            <?php
            $words = explode( ' ', trim( $title ) );
            if ( count( $words ) > 1 ) {
                $last_word = array_pop( $words );
                echo esc_html( implode( ' ', $words ) ) . ' <span class="elegant-serif">' . esc_html( $last_word ) . '</span>';
            } else {
                echo esc_html( $title );
            }
            ?>
          </h1>

          <div class="single-blog-meta-container">
            <div class="single-blog-meta-item">
              <span class="single-blog-meta-label"><?php esc_html_e( 'Author', 'uboontu-blog-shortcodes' ); ?></span>
              <span class="single-blog-meta-value"><?php echo esc_html( $author_name ); ?></span>
            </div>
            <div class="single-blog-meta-item">
              <span class="single-blog-meta-label"><?php esc_html_e( 'Publish Date', 'uboontu-blog-shortcodes' ); ?></span>
              <span class="single-blog-meta-value"><?php echo esc_html( $date_label ); ?></span>
            </div>
            <div class="single-blog-meta-item">
              <span class="single-blog-meta-label"><?php esc_html_e( 'Category', 'uboontu-blog-shortcodes' ); ?></span>
              <span class="single-blog-meta-value"><?php echo esc_html( $category_name ); ?></span>
            </div>
          </div>
        </div>
      </section>

      <!-- FEATURED IMAGE OVERLAP -->
      <?php if ( ! empty( $image_url ) ) : ?>
        <div class="single-blog-featured-wrap">
          <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="single-blog-featured-img" />
        </div>
      <?php endif; ?>

      <!-- BLOG CONTENT GRID SECTION -->
      <article class="single-blog-content-body">
        <div class="single-blog-grid-layout">
          <!-- Left Sidebar (Sticky Table of Contents) -->
          <aside class="single-blog-left-sidebar">
            <div class="single-blog-toc-card">
              <h3 class="single-blog-toc-heading"><?php echo esc_html( $post_data['readTime'] ); ?></h3>
              <div class="single-blog-toc-progress-wrapper">
                <div id="uboontu-toc-progress" class="single-blog-toc-progress-bar" style="width: 0%;"></div>
              </div>
              <ul id="uboontu-toc-list" class="single-blog-toc-list">
                <!-- Populated dynamically by JS -->
              </ul>
            </div>
          </aside>

          <!-- Middle Content (Scrolling Body) -->
          <main class="single-blog-main-content">
            <!-- Key Takeaways Box -->
            <div class="single-blog-takeaways-box">
              <h3 class="single-blog-takeaways-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="takeaways-sparkle-icon">
                  <path d="M12 2L15 9L22 12L15 15L12 22L9 15L2 12L9 9L12 2Z" fill="var(--accent)"/>
                </svg>
                <?php esc_html_e( 'Key Takeaways', 'uboontu-blog-shortcodes' ); ?>
              </h3>
              <ul class="single-blog-takeaways-list">
                <li><?php esc_html_e( 'Collaboration makes community waste programs sustainable.', 'uboontu-blog-shortcodes' ); ?></li>
                <li><?php esc_html_e( 'Strategic planning ensures maximum recycling efficiency.', 'uboontu-blog-shortcodes' ); ?></li>
                <li><?php esc_html_e( 'Educating youth is key to creating a greener future.', 'uboontu-blog-shortcodes' ); ?></li>
                <li><?php esc_html_e( 'Local partnerships amplify circular economy benefits.', 'uboontu-blog-shortcodes' ); ?></li>
                <li><?php esc_html_e( 'Clear accountability ensures long-term impact metrics.', 'uboontu-blog-shortcodes' ); ?></li>
              </ul>
            </div>

            <p id="introduction" class="single-blog-lead-text">
              <?php echo esc_html( $excerpt ); ?>
            </p>

            <div class="markdown-content">
              <?php echo $content; ?>
            </div>

            <div id="conclusion" style="height: 1px;"></div>
          </main>

          <!-- Right Sidebar (Sticky CTA Card) -->
          <aside class="single-blog-right-sidebar">
            <div class="single-blog-cta-card">
              <div class="single-blog-cta-banner">
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="single-blog-cta-img" />
              </div>
              <div class="single-blog-cta-content">
                <span class="single-blog-cta-badge"><?php esc_html_e( 'Uboontu Impact', 'uboontu-blog-shortcodes' ); ?></span>
                <h4 class="single-blog-cta-title"><?php echo wp_kses( __( 'Support a cleaner, <br /> greener <em>Community</em>', 'uboontu-blog-shortcodes' ), array( 'br' => array(), 'em' => array() ) ); ?></h4>
                <ul class="single-blog-cta-bullets">
                  <li>
                    <svg class="single-blog-cta-check" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="12" cy="12" r="10" stroke="var(--primary)" stroke-width="2.5" fill="none" />
                      <path d="M8.5 12.5L11 15L16 9" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php esc_html_e( 'Community-led recycling', 'uboontu-blog-shortcodes' ); ?>
                  </li>
                  <li>
                    <svg class="single-blog-cta-check" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="12" cy="12" r="10" stroke="var(--primary)" stroke-width="2.5" fill="none" />
                      <path d="M8.5 12.5L11 15L16 9" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php esc_html_e( 'Empowering local waste workers', 'uboontu-blog-shortcodes' ); ?>
                  </li>
                </ul>
                <div style="display: flex; flex-direction: column; gap: 10px; width: 100%; margin-top: 20px;">
                  <button id="uboontu-donate-btn" class="single-blog-cta-button" style="width: 100%; border: none; cursor: pointer;">
                    <?php esc_html_e( 'Donate to Cause', 'uboontu-blog-shortcodes' ); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                  <button id="uboontu-share-btn" class="single-blog-cta-button" style="width: 100%; border: 1px solid var(--primary); background: transparent; color: var(--primary); cursor: pointer;">
                    <span id="uboontu-share-text"><?php esc_html_e( 'Share Article', 'uboontu-blog-shortcodes' ); ?></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M16 6l-4-4-4 4M12 2v13" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </aside>
        </div>
      </article>

      <!-- RELATED POSTS SECTION -->
      <section class="single-blog-related-section">
        <div class="single-blog-related-container">
          <div class="single-blog-related-header">
            <span class="single-blog-related-badge"><?php esc_html_e( 'More Blogs', 'uboontu-blog-shortcodes' ); ?></span>
            <h2 class="single-blog-related-title"><?php echo wp_kses( __( 'See other <em>Blogs</em>', 'uboontu-blog-shortcodes' ), array( 'em' => array() ) ); ?></h2>
          </div>

          <div class="single-blog-related-grid">
            <?php
            $related_posts = uboontu_get_related_posts( $post_id, 3 );
            foreach ( $related_posts as $rp ) :
                $rp_link = add_query_arg( 'blog_slug', $rp['slug'], remove_query_arg( 'blog_slug' ) );
            ?>
              <div class="single-blog-related-card">
                <a href="<?php echo esc_url( $rp_link ); ?>" class="single-blog-related-card-link">
                  <div class="single-blog-related-img-wrap">
                    <img src="<?php echo esc_url( $rp['image'] ); ?>" alt="<?php echo esc_attr( $rp['title'] ); ?>" />
                  </div>
                  <h3 class="single-blog-related-card-title"><?php echo esc_html( $rp['title'] ); ?></h3>
                </a>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="single-blog-related-footer">
            <a href="<?php echo esc_url( remove_query_arg( 'blog_slug' ) ); ?>" class="single-blog-view-more-btn">
              <?php esc_html_e( 'View More Blogs', 'uboontu-blog-shortcodes' ); ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        </div>
      </section>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode for rendering Blog Listing.
 * Shortcode: [uboontu_blog]
 */
function uboontu_blog_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category'        => '',
        'detail_page_url' => '',
    ), $atts, 'uboontu_blog' );

    // If we have blog_slug in URL, automatically render the single blog post instead!
    $blog_slug = isset( $_GET['blog_slug'] ) ? sanitize_key( $_GET['blog_slug'] ) : '';
    if ( ! empty( $blog_slug ) ) {
        // Enqueue registered assets for single blog
        wp_enqueue_style( 'uboontu-blog-styles' );
        wp_enqueue_script( 'uboontu-blog-scripts' );
        return uboontu_render_single_blog( $blog_slug );
    }

    // Enqueue registered assets
    wp_enqueue_style( 'uboontu-blog-styles' );
    wp_enqueue_script( 'uboontu-blog-scripts' );

    // Localize/Inject dynamic data to Javascript
    $posts = uboontu_get_blog_posts( $atts['category'] );
    wp_localize_script( 'uboontu-blog-scripts', 'uboontu_blog_data', array(
        'posts'           => $posts,
        'detail_page_url' => esc_url( $atts['detail_page_url'] ),
        'fallback_image'  => esc_url( plugins_url('assets/images/image (1).webp', dirname(__DIR__) . '/elementor-addon.php') ),
    ) );

    ob_start();
    ?>
    <div class="blogs-page blogs-page-layout">
      <!-- HERO HEADER SECTION -->
      <section class="blogs-hero">
        <div class="blogs-hero-bg" style="background-image: url('<?php echo esc_url( plugins_url('assets/images/blog-hero-bg.webp', dirname(__DIR__) . '/elementor-addon.php') ); ?>')"></div>
        <div class="blogs-hero-inner">
          <div class="blogs-brand-link">
            <span class="blogs-brand"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
          </div>
          <nav class="blogs-breadcrumb" aria-label="breadcrumb">
            <a href="/" class="blogs-bc-link"><?php esc_html_e( 'Home', 'uboontu-blog-shortcodes' ); ?></a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
            <span class="blogs-bc-current"><?php esc_html_e( 'Blogs', 'uboontu-blog-shortcodes' ); ?></span>
          </nav>
          <h1 class="blogs-hero-title">
            <?php echo wp_kses( __( 'Your Go-To Source:<br />Blog Highlights &amp; <span class="elegant-serif">More</span>', 'uboontu-blog-shortcodes' ), array( 'br' => array(), 'span' => array( 'class' => array() ) ) ); ?>
          </h1>
          <div class="blogs-search-wrap">
            <svg class="blogs-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input
              id="uboontu-search-input"
              class="blogs-search-input"
              type="text"
              placeholder="<?php esc_attr_e( 'Search any blog', 'uboontu-blog-shortcodes' ); ?>"
              value=""
            />
          </div>
        </div>
      </section>

      <!-- HERO HEADER END -->

      <!-- BLOG LISTING SECTION -->
      <section class="blogs-listing">
        <!-- Category tabs -->
        <div class="blogs-cats-wrap">
          <div id="uboontu-cats-container" class="blogs-cats">
            <!-- Populated dynamically by JS -->
          </div>
        </div>

        <!-- Blogs Grid -->
        <div id="uboontu-blogs-grid" class="blogs-grid">
          <!-- Populated dynamically by JS -->
        </div>

        <!-- Empty State -->
        <div id="uboontu-blogs-empty" class="blogs-empty" style="display: none;">
          <span>🔍</span>
          <p><?php echo wp_kses( __( 'No blogs matched search: <strong></strong>', 'uboontu-blog-shortcodes' ), array( 'strong' => array() ) ); ?></p>
        </div>

        <!-- Pagination -->
        <div id="uboontu-pagination" class="blogs-pagination">
          <!-- Populated dynamically by JS -->
        </div>
      </section>

      <!-- NEWSLETTER SUBSCRIBE SECTION -->
      <section class="blogs-newsletter-section" style="padding-bottom: 120px; padding-top: 30px;">
        <div class="blogs-newsletter-container">
          <div class="blogs-newsletter-banner" style="background-image: url('<?php echo esc_url( plugins_url('assets/images/image (2).webp', dirname(__DIR__) . '/elementor-addon.php') ); ?>')">
            <span class="blogs-newsletter-badge"><?php esc_html_e( 'Newsletter', 'uboontu-blog-shortcodes' ); ?></span>
            <h2 class="blogs-newsletter-title">
              <?php echo wp_kses( __( 'Stay In The Loop And Keep Up <br class="desktop-only-br" />With Our <span class="elegant-serif">Green Initiatives</span>', 'uboontu-blog-shortcodes' ), array( 'br' => array( 'class' => array() ), 'span' => array( 'class' => array() ) ) ); ?>
            </h2>
            <p class="blogs-newsletter-subtitle">
              <?php esc_html_e( 'Be the first to hear about our latest waste management projects, community drives, and sustainability impact reports.', 'uboontu-blog-shortcodes' ); ?>
            </p>
            


            <div id="uboontu-newsletter-success" style="display: none; color: #D8FF84; font-size: 18px; font-weight: bold; margin-top: 20px;">
              <?php esc_html_e( 'Thank you! You have subscribed successfully.', 'uboontu-blog-shortcodes' ); ?>
            </div>

            <form id="uboontu-newsletter-form" class="blogs-newsletter-form">
              <div class="blogs-newsletter-input-wrapper">
                <span class="blogs-newsletter-mail-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                  </svg>
                </span>
                <input
                  id="uboontu-newsletter-email"
                  type="email"
                  placeholder="<?php esc_attr_e( 'Your email here', 'uboontu-blog-shortcodes' ); ?>"
                  class="blogs-newsletter-input"
                  required
                />
              </div>
              <button type="submit" class="subscribe-submit-btn blogs-newsletter-btn">
                <?php esc_html_e( 'Subscribe', 'uboontu-blog-shortcodes' ); ?>
                <span class="arrow-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                  </svg>
                </span>
              </button>
            </form>
          </div>
        </div>
      </section>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'uboontu_blog', 'uboontu_blog_shortcode' );

/**
 * Shortcode for rendering Single Blog Post directly.
 * Shortcode: [uboontu_single_blog slug="post-slug-here"]
 */
function uboontu_single_blog_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'slug' => '',
    ), $atts, 'uboontu_single_blog' );

    // Enqueue registered assets
    wp_enqueue_style( 'uboontu-blog-styles' );
    wp_enqueue_script( 'uboontu-blog-scripts' );

    $slug = $atts['slug'];
    if ( empty( $slug ) ) {
        // Fallback to URL query parameter
        $slug = isset( $_GET['blog_slug'] ) ? sanitize_key( $_GET['blog_slug'] ) : '';
    }
    
    if ( empty( $slug ) && is_single() ) {
        // Fallback to current WordPress single post slug if placed inside a post template
        global $post;
        if ( isset( $post->post_name ) ) {
            $slug = $post->post_name;
        }
    }

    if ( empty( $slug ) ) {
        return sprintf(
            '<p style="text-align: center; color: var(--text-secondary); padding: 40px 0;">%s</p>',
            esc_html__( 'No blog slug specified or detected.', 'uboontu-blog-shortcodes' )
        );
    }

    return uboontu_render_single_blog( $slug );
}
add_shortcode( 'uboontu_single_blog', 'uboontu_single_blog_shortcode' );

/**
 * Shortcode for rendering SDG Alignment section.
 * Shortcode: [uboontu_sdg_alignment]
 */
function uboontu_sdg_alignment_shortcode() {
    // Enqueue registered assets
    wp_enqueue_style( 'uboontu-blog-styles' );
    wp_enqueue_script( 'uboontu-blog-scripts' );

    $sdg_groups = array(
        array(
            'number' => 1,
            'theme' => 'No Poverty',
            'color' => '#e5243b',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-1.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-01.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'End poverty in all its forms everywhere.',
            'targets' => 7,
            'events' => 157,
            'publications' => 51,
            'actions' => 1580,
        ),
        array(
            'number' => 3,
            'theme' => 'Good Health and Well-being',
            'color' => '#4c9f38',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-3.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-03.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Ensure healthy lives and promote well-being for all at all ages.',
            'targets' => 13,
            'events' => 79,
            'publications' => 50,
            'actions' => 1375,
        ),
        array(
            'number' => 5,
            'theme' => 'Gender Equality',
            'color' => '#ff3a21',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-5.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-05.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Achieve gender equality and empower all women and girls.',
            'targets' => 9,
            'events' => 117,
            'publications' => 49,
            'actions' => 1867,
        ),
        array(
            'number' => 6,
            'theme' => 'Clean Water and Sanitation',
            'color' => '#26b3c4',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-6.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-06.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Ensure availability and sustainable management of water and sanitation for all.',
            'targets' => 8,
            'events' => 321,
            'publications' => 38,
            'actions' => 1931,
        ),
        array(
            'number' => 7,
            'theme' => 'Affordable and Clean Energy',
            'color' => '#f2bc1c',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-7.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-07.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Ensure access to affordable, reliable, sustainable and modern energy for all.',
            'targets' => 5,
            'events' => 103,
            'publications' => 49,
            'actions' => 1103,
        ),
        array(
            'number' => 8,
            'theme' => 'Decent Work and Economic Growth',
            'color' => '#a21942',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-8.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-08.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all.',
            'targets' => 12,
            'events' => 142,
            'publications' => 51,
            'actions' => 2152,
        ),
        array(
            'number' => 9,
            'theme' => 'Industry, Innovation and Infrastructure',
            'color' => '#fd6925',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-9.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-09.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation.',
            'targets' => 8,
            'events' => 145,
            'publications' => 19,
            'actions' => 1183,
        ),
        array(
            'number' => 10,
            'theme' => 'Reduced Inequalities',
            'color' => '#dd1367',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-10.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-10.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Reduce inequality within and among countries.',
            'targets' => 10,
            'events' => 111,
            'publications' => 15,
            'actions' => 1092,
        ),
        array(
            'number' => 11,
            'theme' => 'Sustainable Cities and Communities',
            'color' => '#fd9d24',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-11.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-11.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Make cities and human settlements inclusive, safe, resilient and sustainable.',
            'targets' => 10,
            'events' => 156,
            'publications' => 25,
            'actions' => 1343,
        ),
        array(
            'number' => 12,
            'theme' => 'Responsible Consumption and Production',
            'color' => '#bf8d2c',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-12.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-12.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Ensure sustainable consumption and production patterns.',
            'targets' => 11,
            'events' => 68,
            'publications' => 19,
            'actions' => 1869,
        ),
        array(
            'number' => 13,
            'theme' => 'Climate Action',
            'color' => '#3f7e44',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-13.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-13.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Take urgent action to combat climate change and its impacts.',
            'targets' => 5,
            'events' => 93,
            'publications' => 40,
            'actions' => 2455,
        ),
        array(
            'number' => 14,
            'theme' => 'Life Below Water',
            'color' => '#0a97d9',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-14.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-14.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Conserve and sustainably use the oceans, seas and marine resources for sustainable development.',
            'targets' => 10,
            'events' => 150,
            'publications' => 44,
            'actions' => 3379,
        ),
        array(
            'number' => 15,
            'theme' => 'Life on Land',
            'color' => '#56c02b',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-15.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-15.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Protect, restore and promote sustainable use of terrestrial ecosystems, sustainably manage forests, combat desertification, and halt and reverse land degradation and halt biodiversity loss.',
            'targets' => 12,
            'events' => 62,
            'publications' => 35,
            'actions' => 1440,
        ),
        array(
            'number' => 17,
            'theme' => 'Partnerships for the Goals',
            'color' => '#19486a',
            'image' => plugins_url('assets/images/14 GOALS/img-goal-17.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'iconImage' => plugins_url('assets/images/14 GOALS/E_SDG_Icons-17.jpg', dirname(__DIR__) . '/elementor-addon.php'),
            'desc' => 'Strengthen the means of implementation and revitalize the Global Partnership for Sustainable Development.',
            'targets' => 19,
            'events' => 392,
            'publications' => 85,
            'actions' => 2439,
        )
    );

    ob_start();
    ?>
    <div class="blogs-page">
      <section id="sdgs" class="section sdg-section">
        <!-- Decorative background blobs -->
        <div class="sdg-bg-blob sdg-blob-tl"></div>
        <div class="sdg-bg-blob sdg-blob-br"></div>

        <div class="sdg-container">
          <!-- Section Header -->
          <div class="sdg-header-split">
            <div class="sdg-header-left">
              <span class="badge badge-accent"><?php esc_html_e( 'SDG Alignment', 'uboontu-blog-shortcodes' ); ?></span>
              <h2><?php echo wp_kses( __( 'Sustainable Development <span class="elegant-serif">Goals</span>', 'uboontu-blog-shortcodes' ), array( 'span' => array( 'class' => array() ) ) ); ?></h2>
              <p class="sdg-header-desc">
                <?php esc_html_e( 'Achieving the Sustainable Development Goals requires urgent action to address climate change, biodiversity loss, and waste. Uboontu offers a unique opportunity to drive meaningful, cross-cutting impact across diverse sectors and communities.', 'uboontu-blog-shortcodes' ); ?>
              </p>
            </div>
          </div>

          <div class="sdg-workspace">
            <!-- 6-Column SDG Cards Grid -->
            <div class="sdg-list">
              <?php foreach ( $sdg_groups as $i => $group ) :
                  $real_num = $group['number'];
                  
                  // Match digit classes
                  $digit_class = ($real_num >= 10) ? 'double-digit' : 'single-digit';
                  $extra_cover = in_array($real_num, array(6, 8, 9)) ? 'extra-cover' : '';
                  $shift_left = in_array($real_num, array(10, 12)) ? 'shift-left' : '';
                  $shift_right = ($real_num === 5) ? 'shift-right' : '';
                  $shift_right_8 = ($real_num === 8) ? 'shift-right-8' : '';
                  
                  $mask_classes = implode(' ', array_filter(array(
                      'sdg-card-icon-mask',
                      $digit_class,
                      $extra_cover,
                      $shift_left,
                      $shift_right,
                      $shift_right_8
                  )));
              ?>
                <div class="sdg-card-item" style="--group-color: <?php echo esc_attr( $group['color'] ); ?>;">
                  <div class="sdg-card-image-wrap">
                    <div class="sdg-card-bg-image" style="background-image: url('<?php echo esc_url( $group['image'] ); ?>');"></div>
                    <div class="sdg-card-overlay"></div>
                  </div>
                  
                  <div class="sdg-card-icon-container">
                    <img src="<?php echo esc_url( $group['iconImage'] ); ?>" alt="<?php echo esc_attr( $group['theme'] ); ?>" class="sdg-card-icon-img" />
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
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'uboontu_sdg_alignment', 'uboontu_sdg_alignment_shortcode' );

