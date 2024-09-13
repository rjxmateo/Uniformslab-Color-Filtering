<?php
/**
 * WordPress Bootstrap Starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress_Bootstrap_Starter_Theme
 */
global $wpdb;

if ( ! function_exists( 'wordpress_bootstrap_starter_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wordpress_bootstrap_starter_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WordPress Bootstrap Starter Theme, use a find and replace
		 * to change 'wordpress-bootstrap-starter-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wordpress-bootstrap-starter-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wordpress-bootstrap-starter-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wordpress_bootstrap_starter_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wordpress_bootstrap_starter_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wordpress_bootstrap_starter_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'wordpress_bootstrap_starter_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'wordpress_bootstrap_starter_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wordpress_bootstrap_starter_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wordpress-bootstrap-starter-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wordpress-bootstrap-starter-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wordpress_bootstrap_starter_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wordpress_bootstrap_starter_theme_scripts() {
	wp_enqueue_style( 'wordpress-bootstrap-starter-theme-style', get_stylesheet_uri() );

	// https://getbootstrap.com/docs/4.3/getting-started/download/#bootstrapcdn
	wp_enqueue_script( 'wordpress-bootstrap-starter-theme-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), '20151215', true );
	
	wp_enqueue_script( 'wordpress-bootstrap-starter-theme-vendor-scripts', get_template_directory_uri() . '/assets/js/vendor.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'wordpress-bootstrap-starter-theme-custom-scripts', get_template_directory_uri() . '/assets/js/custom.min.js', array('customize-preview'), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wordpress_bootstrap_starter_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load wooocomerce compatibility file.
 */

function wordpress_bootstrap_starter_theme_woocommerce_setup() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'wordpress_bootstrap_starter_theme_woocommerce_setup');



//Custom

function your_theme_enqueue_woocommerce_styles() {
    // Check if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        // Enqueue WooCommerce general styles
        wp_enqueue_style( 'woocommerce-general', plugins_url( '/woocommerce/assets/css/woocommerce.css' ) );

        // Enqueue WooCommerce layout styles
        wp_enqueue_style( 'woocommerce-layout', plugins_url( '/woocommerce/assets/css/woocommerce-layout.css' ) );

        // Enqueue WooCommerce smalldevices styles
        wp_enqueue_style( 'woocommerce-smallscreen', plugins_url( '/woocommerce/assets/css/woocommerce-smallscreen.css' ), array(), '', 'only screen and (max-width: 768px)' );
    }
}
add_action( 'wp_enqueue_scripts', 'your_theme_enqueue_woocommerce_styles' );

// Ensure WooCommerce styles are loaded before your custom styles
function your_theme_dequeue_woocommerce_styles() {
    if ( class_exists( 'WooCommerce' ) ) {
        // Dequeue WooCommerce general styles
        wp_dequeue_style( 'woocommerce-general' );

        // Dequeue WooCommerce layout styles
        wp_dequeue_style( 'woocommerce-layout' );

        // Dequeue WooCommerce smalldevices styles
        wp_dequeue_style( 'woocommerce-smallscreen' );

        // Re-enqueue WooCommerce styles
        wp_enqueue_style( 'woocommerce-general', plugins_url( '/woocommerce/assets/css/woocommerce.css' ) );
        wp_enqueue_style( 'woocommerce-layout', plugins_url( '/woocommerce/assets/css/woocommerce-layout.css' ) );
        wp_enqueue_style( 'woocommerce-smallscreen', plugins_url( '/woocommerce/assets/css/woocommerce-smallscreen.css' ), array(), '', 'only screen and (max-width: 768px)' );
    }
}
add_action( 'wp_enqueue_scripts', 'your_theme_dequeue_woocommerce_styles', 20 );



function track_post_views() {
    if (is_single()) {
        $post_id = get_queried_object_id();
        $views = get_post_meta($post_id, 'post_views', true);
        $views = $views ? $views + 1 : 1;
        update_post_meta($post_id, 'post_views', $views);
    }
}
add_action('wp_head', 'track_post_views');

function enqueue_nouislider_scripts() {
    wp_enqueue_style('nouislider-css', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css');
    wp_enqueue_script('nouislider-js', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_nouislider_scripts');



add_filter( 'woocommerce_product_get_rating_html', 'always_show_star_rating', 10, 2 );

function always_show_star_rating( $rating_html, $rating ) {
    if ( $rating_html === '' || $rating == 0 ) {
        $rating_html = '<div class="star-rating" role="img" aria-label="' . esc_attr__( 'Rated 0 out of 5', 'woocommerce' ) . '">';
        $rating_html .= wc_get_star_rating_html( 0, 1 );
        $rating_html .= '</div>';
    }
    return $rating_html;
}


add_action( 'woocommerce_single_product_summary', 'show_hide_product_variable_price', 8 );
function show_hide_product_variable_price() {
    global $product;

    if( $product->is_type('variable') ) {
        ?>
<script type="text/javascript">
jQuery(function($) {
  // Store the original price HTML in a data attribute on the price element
  var $origPriceElement = $('.woocommerce .orig-price');
  var originalPriceHtml = $origPriceElement.html();
  $origPriceElement.data('original-html', originalPriceHtml);

  // On selected variation event
  $('form.variations_form').on('show_variation', function(event, variation) {
    // Get the variation price HTML and extract the specific HTML structure
    var variationPriceHtml = variation.price_html;
    var $variationPriceElement = $(variationPriceHtml).find('.woocommerce-Price-amount').parent();
    $('.woocommerce .orig-price').html($variationPriceElement.html());
    $('.woocommerce .orig-price').removeClass('orig-price').addClass(
      'woocommerce-variation-price  fw-semibold');
    console.log('Variation is selected | Replaced original price with variation price', $variationPriceElement
      .html());
  });

  // On unselected (or not selected) variation event
  $('form.variations_form').on('hide_variation', function() {
    // Restore the original price
    var $priceElement = $('.woocommerce .woocommerce-variation-price');
    if ($priceElement.length) {
      $priceElement.html($origPriceElement.data('original-html'));
      $priceElement.removeClass('woocommerce-variation-price  fw-semibold').addClass('orig-price');
    }
    console.log('No variation is selected | Reverted back to original price');
  });
});
</script>
<?php
    }
}


function set_custom_default_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $custom_default_avatar = 'https://www.uniformslab.com/wp-content/uploads/2024/08/4935173.webp';
    
    if (is_email($id_or_email)) {
        $user = get_user_by('email', $id_or_email);
        $user_id = $user ? $user->ID : 0;
    } else {
        $user_id = is_numeric($id_or_email) ? (int) $id_or_email : 0;
    }
    
    $user_avatar = get_user_meta($user_id, 'permanent_avatar', true);
    
    if (!$user_avatar) {
        return "<img alt='" . esc_attr($alt) . "' src='" . esc_url($custom_default_avatar) . "' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    }
    
    return "<img alt='" . esc_attr($alt) . "' src='" . esc_url($user_avatar) . "' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
}
add_filter('get_avatar', 'set_custom_default_avatar', 10, 5);


function set_random_avatar_for_new_user($user_id) {
    // Array of default avatar URLs
    $default_avatars = [
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935173.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935174.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935177.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935187.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935191.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935192.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935193.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935194.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935196.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935205.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935206.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935207.webp',
	'https://www.uniformslab.com/wp-content/uploads/2024/08/4935210.webp',

    ];
    
    // Select a random avatar URL from the array
    $random_avatar_url = $default_avatars[array_rand($default_avatars)];
    
    // Update user meta with the random avatar URL
    update_user_meta($user_id, 'permanent_avatar', $random_avatar_url);
}
add_action('user_register', 'set_random_avatar_for_new_user');


function assign_random_avatars_to_all_users() {
    // Array of default avatar URLs
    $default_avatars = [
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935173.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935174.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935177.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935187.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935191.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935192.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935193.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935194.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935196.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935205.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935206.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935207.webp',
        'https://www.uniformslab.com/wp-content/uploads/2024/08/4935210.webp',
    ];
    
    // Get all users
    $users = get_users();
    
    foreach ($users as $user) {
        // Select a random avatar URL from the array
        $random_avatar_url = $default_avatars[array_rand($default_avatars)];
        // Update user meta with the random avatar URL
        update_user_meta($user->ID, 'permanent_avatar', $random_avatar_url);
    }
}

// Run this function to update all users
// assign_random_avatars_to_all_users();

function display_author_avatar() {
    $author_id = get_the_author_meta('ID');
    $author_avatar_url = get_avatar_url($author_id, array('size' => 50)); 

    return '<img src="' . esc_url($author_avatar_url) . '" alt="' . esc_attr(get_the_author_meta('display_name')) . '" class="img-fluid rounded-circle" width="50" height="50">';
}
add_shortcode('author_avatar', 'display_author_avatar');



add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( in_array( $params['facet_name'], [ 'colors' ] ) ) { // Replace 'my_color_facet' with your color facet name
        // Replace these IDs with your actual parent term IDs
        $parent_ids = [849, 852, 855, 856, 861]; // Example IDs for Black, Blue, Red, Green, Yellow

        // Check if the term's ID is one of the specified parent term IDs
        if ( ! in_array( $params['term_id'], $parent_ids ) ) { 
            $params['facet_value'] = ''; // Skip indexing if not a parent color
        }
    }
    return $params;
}, 10, 2 );



// add_action('pre_get_posts', 'custom_filter_by_brand_color');
// function custom_filter_by_brand_color($query) {
//     if (!is_admin() && $query->is_main_query() && is_shop()) {
//         if (isset($_GET['filter_colors']) && !empty($_GET['filter_colors'])) {
//             $color = sanitize_text_field($_GET['filter_colors']);
//             $tax_query = array(
//                 array(
//                     'taxonomy' => 'pa_brand-color', // Adjust this if your attribute slug is different
//                     'field'    => 'slug',
//                     'terms'    => $color,
//                     'operator' => 'IN',
//                 ),
//             );
//             $query->set('tax_query', $tax_query);
//         }
//     }
// }

add_action('wp_ajax_nopriv_filter_by_brand_color', 'filter_by_brand_color');
add_action('wp_ajax_filter_by_brand_color', 'filter_by_brand_color');
add_action('wp_ajax_filter_by_category', 'filter_by_category');
add_action('wp_ajax_nopriv_filter_by_category', 'filter_by_category');

function filter_by_brand_color() {
    $colors = isset($_POST['colors']) ? array_map('sanitize_text_field', $_POST['colors']) : array();

    if (!is_array($colors)) {
        $colors = array();
    }

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1; 

    $posts_per_page = 10; 

    $existing_args = array(
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'paged'          => $paged,
    );

    $tax_query = array(
        'taxonomy' => 'pa_brand-color',
        'field'    => 'slug',
        'terms'    => $colors,
        'operator' => 'IN',
    );

    $args = array_merge($existing_args, array(
        'tax_query' => array($tax_query),
    ));

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product'); 
        }

        // Pagination
        echo paginate_links(array(
            'total'   => $query->max_num_pages,
            'current' => $paged,
        ));
    } else {
        echo '<p>No products found</p>';
    }

    wp_die();
}


function filter_by_category() {
    $category_slug = $_POST['category_slug']; // Get the category slug from AJAX request

    // Same query as before
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category_slug,
                'operator' => 'IN',
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p>No products found</p>';
    }

    wp_reset_postdata();
    wp_die(); // End AJAX request
}


function enqueue_ajax_filter_scripts() {
    // Debugging info
    error_log('Enqueueing scripts');

    // Enqueue the color filter script with versioning
    wp_enqueue_script(
        'ajax-colorfilter', 
        get_template_directory_uri() . '/js/ajax-colorfilter.js', 
        array('jquery'), 
        filemtime(get_template_directory() . '/js/ajax-colorfilter.js'), // Versioning based on file modification time
        true
    );
    wp_localize_script('ajax-colorfilter', 'ajax_filter_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    // Enqueue the category filter script with versioning
    wp_enqueue_script(
        'ajax-categoryfilter', 
        get_template_directory_uri() . '/js/ajax-categoryfilter.js', 
        array('jquery'), 
        filemtime(get_template_directory() . '/js/ajax-categoryfilter.js'), // Versioning based on file modification time
        true
    );
    wp_localize_script('ajax-categoryfilter', 'ajax_category_filter_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    error_log('Enqueueing swatches-singleProduct.js');
    wp_enqueue_script(
        'swatches-singleProduct', 
        get_template_directory_uri() . '/js/swatches-singleProduct.js', 
        array('jquery'), 
        filemtime(get_template_directory() . '/js/swatches-singleProduct.js'), // Versioning based on file modification time
        true
    );

    // Pass the color data to the swatch script
    $json_file_path = get_template_directory() . '/woocommerce/ulab_lookup_colors.json';
    error_log('JSON file path: ' . $json_file_path);
    if (file_exists($json_file_path)) {
        $json_data = file_get_contents($json_file_path);
        wp_localize_script('swatches-singleProduct', 'colorData', array(
            'colors' => $json_data
        ));
    } else {
        error_log('JSON file not found: ' . $json_file_path);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_filter_scripts');





function generate_ulab_lookup_colors_json() {
    $host = getenv('DB_HOST');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $database = getenv('DB_NAME');
    $port = 3306;
 
    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM ulab_lookup_colors";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $colors = [];

        while ($row = $result->fetch_assoc()) {
            $colors[] = $row;
        }

        $json_data = json_encode($colors);

        $json_file_path = get_template_directory() . '/woocommerce/ulab_lookup_colors.json';

        file_put_contents($json_file_path, $json_data);

        $conn->close();
    } else {
        $conn->close();
    }
}


function schedule_ulab_colors_update() {
    if (!wp_next_scheduled('update_ulab_lookup_colors_json')) {
        wp_schedule_event(time(), 'hourly', 'update_ulab_lookup_colors_json');
    }
}
add_action('wp', 'schedule_ulab_colors_update');
add_action('update_ulab_lookup_colors_json', 'generate_ulab_lookup_colors_json');

// add_action('init', 'generate_ulab_lookup_colors_json');

function replace_s3_with_cloudfront( $url ) {
    // Replace the S3 bucket URL with the CloudFront URL
    return str_replace( 'uniformslab.s3.amazonaws.com', 'd2czqbhdcyarjs.cloudfront.net', $url );
}
add_filter( 'wp_get_attachment_url', 'replace_s3_with_cloudfront' );
