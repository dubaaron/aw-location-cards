<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Aaron Wallentine\'s Location Cards' );
define( 'CHILD_THEME_URL', 'https://github.com/dubaaron' );
define( 'CHILD_THEME_VERSION', '2.2.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'genesis-responsive-menu', get_bloginfo('stylesheet_directory').'/js/responsive-menu.js', array('jquery'), '1.0.0');
    wp_enqueue_script( 'genesis-smooth-scrolling', get_bloginfo('stylesheet_directory').'/js/smooth-scrolling.js', array('jquery'), '1.0.0');
    wp_enqueue_script( 'genesis-sticky-header', get_bloginfo('stylesheet_directory').'/js/sticky-header.js', array('jquery'), '1.0.0');
    wp_enqueue_script( 'genesis-modernizr', get_bloginfo('stylesheet_directory').'/js/modernizr.js', array(), '1.0.0');
	wp_enqueue_style( 'dashicons' );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* unregister superfish since it interferes with our mobile responsive menu
function unregister_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}
add_action( 'wp_enqueue_scripts', 'unregister_superfish' );

//* register the before footer widget
genesis_register_sidebar(array(
    'id' => 'before-footer-widget',
    'name' => __('Before Footer', 'genesis'),
    'description' => __('Area right before the footer', 'Starter Theme'),
));

//* use the before footer widget
add_action('genesis_before_footer', 'add_before_footer_widget_area', 9);
function add_before_footer_widget_area()
{
    genesis_widget_area('before-footer-widget', array(
        'before' => '<div class="before-footer-widget widget-area"><div class="wrap">',
        'after' => '</div></div>',
  ));
}

//* register homepage 5 widgets
genesis_register_sidebar(array(
    'id' => 'home-widget-1',
    'name' => __('Home Widget 1', 'genesis'),
    'description' => __('First widget on the home page', 'Starter Theme'),
));
genesis_register_sidebar(array(
    'id' => 'home-widget-2',
    'name' => __('Home Widget 2', 'genesis'),
    'description' => __('Second widget on the home page', 'Starter Theme'),
));
genesis_register_sidebar(array(
    'id' => 'home-widget-3',
    'name' => __('Home Widget 3', 'genesis'),
    'description' => __('Third widget on the home page', 'Starter Theme'),
));
genesis_register_sidebar(array(
    'id' => 'home-widget-4',
    'name' => __('Home Widget 4', 'genesis'),
    'description' => __('Fourth widget on the home page', 'Starter Theme'),
));
genesis_register_sidebar(array(
    'id' => 'home-widget-5',
    'name' => __('Home Widget 5', 'genesis'),
    'description' => __('Fifth widget on the home page', 'Starter Theme'),
));

//* allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* Modify the Genesis content limit read more link
add_filter('get_the_content_more_link', 'sp_read_more_link');
function sp_read_more_link()
{
    return '... <a class="more-link" href="'.get_permalink().'">Read More</a>';
}

//* Modify the excerpt more [...] content
function eleven_online_excerpt_more( $more ) {
    return '<a class="read-more" href="' . get_permalink( get_the_ID() ) . '"> ... Read More</a>';
}
add_filter( 'excerpt_more', 'eleven_online_excerpt_more' );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter($creds)
{
    $creds = 'Copyright '.date('Y').' -  By 11 Online';

    return $creds;
}

//* Add Our Customizer Options
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Section Image CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Include Custom Post Types
include_once( get_stylesheet_directory() . '/custom-post-types/index.php' );

//* Include Custom Taxonomies
include_once( get_stylesheet_directory() . '/custom-taxonomies/index.php' );

//* Add support for custom header
add_theme_support('custom-header', array(
    'width' => 160,
    'height' => 58,
    'header-selector' => '.site-title a',
    'header-text' => false,
    )
);

//*add a custom stylesheet to the TinyMCE editor
function my_theme_add_editor_styles()
{
    add_editor_style();
}
add_action('admin_init', 'my_theme_add_editor_styles');

//*remove worthless dashboard panels
function remove_dashboard_meta() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
}

add_action( 'admin_init', 'remove_dashboard_meta' );


//*remove welcome dashboard panel
function remove_welcome_panel() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	$user_id = get_current_user_id();
	if ( 0 !== get_user_meta( $user_id, 'show_welcome_panel', true ) ) {
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
	}
}

add_action( 'load-index.php', 'remove_welcome_panel' );

//*only load woocommerce scripts on woocommerce pages 
function conditionally_load_woc_js_css(){
if( function_exists( 'is_woocommerce' ) ){
        # Only load CSS and JS on Woocommerce pages   
	if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) { 		
		
		## Dequeue scripts.
		wp_dequeue_script('woocommerce'); 
		wp_dequeue_script('wc-add-to-cart'); 
		wp_dequeue_script('wc-cart-fragments');
		
		## Dequeue styles.	
		wp_dequeue_style('woocommerce-general'); 
		wp_dequeue_style('woocommerce-layout'); 
		wp_dequeue_style('woocommerce-smallscreen'); 
			
		}
	}	
}

add_action( 'wp_enqueue_scripts', 'conditionally_load_woc_js_css' );

//* Use Featured Image as Hero Image with Title
add_action('genesis_after_header', 'eleven_online_add_hero_area');
function eleven_online_add_hero_area()
{
    if (!is_front_page()) {
        if (is_single() || is_page()) {
            if (has_post_thumbnail()) {
                // add the title with in a single hero area
                echo '<div class="single-hero" style="background: url(' . get_the_post_thumbnail_url(get_the_ID(), 'full') . ')"><div class="wrap"><div class="hero-content"><h1>' . get_the_title() . '</h1></div></div></div>';
                // remove the default title
                remove_action('genesis_entry_header', 'genesis_do_post_title');
            }
        }
    }
}

// GUTENBERG Compatibility
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style('eleven_online_theme_styles', get_theme_file_uri('/style.css') );
} );

add_action( 'after_setup_theme', function() {
    add_theme_support( 'editor-color-palette', [
        [
            'name'  => esc_html__( 'Black', 'Starter Theme' ),
            'slug' => 'black',
            'color' => '#000',
        ],
        [
            'name'  => esc_html__( 'Dark Gray', 'Starter Theme' ),
            'slug' => 'dark-gray',
            'color' => '#333',
        ],
        [
            'name'  => esc_html__( 'Medium Gray', 'Starter Theme' ),
            'slug' => 'medium-gray',
            'color' => '#aaa',
        ],
        [
            'name'  => esc_html__( 'Light Gray', 'Starter Theme' ),
            'slug' => 'light-gray',
            'color' => '#f5f5f5',
        ],
        [
            'name'  => esc_html__( 'White', 'Starter Theme' ),
            'slug' => 'white',
            'color' => '#fff',
        ],
        [
            'name'  => esc_html__( 'Red', 'Starter Theme' ),
            'slug' => 'red',
            'color' => '#c3251d',
        ]
    ] );
    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'align-wide' );
});



$aw_config_file = __DIR__ . '/config.php';
if (file_exists( $aw_config_file ) ) {
	require_once $aw_config_file;
} else {
	// to throw an error/warning here, or not? Maybe let's not, but let users
	// know another way that they should set the value in the config file
	require_once __DIR__ . '/config-sample.php';
}


function aw_grid_custom_post_class_halves( $classes ) {
	return aw_grid_custom_post_class( $classes, 2, 'one-half' );
}


function aw_grid_custom_post_class_thirds( $classes ) {
	return aw_grid_custom_post_class( $classes, 3, 'one-third' );
}


function aw_grid_custom_post_class( $classes, $cols_per_row = 3, $column_class = 'one-third' ) {
	global $wp_query;

	$term         = $wp_query->get_queried_object();

	$classes[] = 'grid ' . $column_class;

	if ( 0 == $wp_query->current_post % $cols_per_row ) {
		$classes[] = 'first';
	}
	return $classes;
}


function aw_add_location_type_card_grid_view_customizations( ) {
	/* I guess we could also wrap this in
	 *    if( ! is_single() && 'location' == get_post_type ) { ... }
	 * and run it automatically, but for now i think it's best to just call this
	 * function when doing a card grid view for location type. -- aw 2019-10-02 */

	add_action( 'genesis_entry_header', 'aw_location_card_image', 5 );

	add_action( 'genesis_entry_footer', 'aw_location_card_bottom');

}



function aw_location_card_image( ) {

	print_r(get_field('google_map'));

	$map_image_url = gmap_static_map(
		get_field( 'latitude' ),
		get_field( 'longitude' ),
		380, 285,
		get_field('zoom_level')
	);

	if ( ! defined( 'AW_GOOGLE_MAPS_API_KEY' ) || empty( AW_GOOGLE_MAPS_API_KEY )
	) {
		$map_image_alt = __( 'Set AW_GOOGLE_MAPS_API_KEY in config.php of theme directory to get maps.', CHILD_THEME_NAME );
	} else {
		$map_image_alt = __( "Small Google Map of ", CHILD_THEME_NAME ) . get_the_title();
	}

	echo "<a href='" . get_permalink() . "'><img alt='$map_image_alt' class='location-map' src='$map_image_url' /></a>";

}

function aw_location_card_bottom( ) {

	echo "<div class='aw-LocationCard__gradientHolder'></div>";

	$more_link = get_permalink();
	echo "<div class='aw-LocationCard__moreLink'><a href='$more_link'>";
	_e("More ...", CHILD_THEME_NAME);
	echo "</a></div>";

}



function aw_add_location_cards_wrapper( $priority = 10 ) {

	// Add a wrapper around our card grid
	add_action( 'genesis_before_while', function ( ) {
		echo "<div class='aw-LocationCardGrid'>";
	}, $priority );

	add_action( 'genesis_after_endwhile', function ( ) {
		echo "</div>";
	}, $priority );

}


function gmap_static_map($lat, $long, $width = 400, $height = 400, $zoom = 12) {
	return
		"https://maps.googleapis.com/maps/api/staticmap?"
		. "size={$width}x{$height}&zoom=$zoom"
		// '%7C' is a URL-escaped pipe character ('|')
		. "&markers=color:red%7C$lat,$long"
		. "&key=" . AW_GOOGLE_MAPS_API_KEY;
}




add_action( 'genesis_footer', 'aw_show_email_signup', 9 );
function aw_show_email_signup() {

	echo "<div class='aw-FooterEmailForm__wrap' id='aw-FooterEmailSignup'>";
	gravity_form( 1 );
	echo "</div>";
	echo "<div class='aw-FooterHR'></div>";
}
