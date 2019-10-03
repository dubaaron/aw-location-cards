<?php

/*
 * This is a custom post type example single. To change it to use your custom post type, just rename to single-[your custom post type slug].php
 */

//* Remove the entry meta in the entry header (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_header', 'eo_add_featured_image', 5 );
function eo_add_featured_image() {
	global $post;
	if ( $image = genesis_get_image( 'format=url&size=full' ) ) {
		printf( '<img src="%s" alt="%s" class="aligncenter" />', $image, the_title_attribute( 'echo=0' ) );
	}
}

add_action( 'genesis_before_entry_content', function( ) {

	$map_url = sprintf( "https://www.google.com/maps/embed/v1/place?q=%f,%f&key=%s&zoom=%d",
		get_field('latitude'), get_field('longitude'),
		AW_GOOGLE_MAPS_API_KEY, get_field('zoom_level')
	);
		echo "<iframe class='map-container' width='100%' height='450' src='$map_url' frameborder='0' style='border:0' allowfullscreen></iframe>";
});

add_action( 'genesis_entry_footer', function( ) {
	echo "<div style='clear: both'></div>";
});

genesis();
