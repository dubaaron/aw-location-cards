<?php
/**
 * This file adds the Home Page to the Owner Direct Theme.
 *
 */

add_action( 'genesis_meta', 'starter_theme_home_genesis_meta' );
function starter_theme_home_genesis_meta() {

}

//* Remove the default Genesis loop (don't do the posts)
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', 'add_home_page_widgets' );
function add_home_page_widgets() {
	genesis_widget_area( 'home-widget-1', [
		'before' => '<div id="home-widget-1" class="home-widget-1 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	] );
	genesis_widget_area( 'home-widget-2', [
		'before' => '<div id="home-widget-2" class="home-widget-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	] );
	genesis_widget_area( 'home-widget-3', [
		'before' => '<div id="home-widget-3" class="home-widget-3 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	] );
	genesis_widget_area( 'home-widget-4', [
		'before' => '<div id="home-widget-4" class="home-widget-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	] );
	genesis_widget_area( 'home-widget-5', [
		'before' => '<div id="home-widget-5" class="home-widget-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	] );
}


// remove post meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// remove pagination
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

aw_add_location_cards_wrapper( );

aw_add_location_type_card_grid_view_customizations();

// do the first row of 2 cards
add_action( 'genesis_loop', 'aw_show_first_row_locations' );
function aw_show_first_row_locations( $query ) {

	add_filter( 'post_class', 'aw_grid_custom_post_class_halves' );
	$args = [
		'posts_per_page' => 2,
		'post_type'      => 'location',
		'order'          => 'ASC',
	];
	genesis_custom_loop( $args );
}

// do the second row of 3 cards
add_action( 'genesis_loop', 'aw_show_next_row_locations' );
function aw_show_next_row_locations( $query ) {

	// take off the previous filter for the row of 2, or it will interfere with the query for the row of 3
	remove_filter( 'post_class', 'aw_grid_custom_post_class_halves' );
	add_filter( 'post_class', 'aw_grid_custom_post_class_thirds' );
	$args = [
		'posts_per_page' => 3,
		'offset'         => 2,
		'post_type'      => 'location',
		'order'          => 'ASC',
	];
	genesis_custom_loop( $args );
}

// add link to view location archive
add_action( 'genesis_after_loop', function ( ) {
	?>
    <div class='aw-LocationTiles__archiveLink_wrap'>
        <a class="aw-LocationTiles__archiveLink button" href="/location/">
          <?php _e( 'View All', CHILD_THEME_NAME ) ?> &raquo;</a>
    </div>
	<?php
} );


genesis();
