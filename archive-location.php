<?php

/*
 * This is a custom post type example archive. To change it to use your custom post type, just rename to archive-[your custom post type slug].php
 */

add_action( 'genesis_before_while', 'aw_show_archive_header');
function aw_show_archive_header( $query ) {
	global $wp_query;

	$cur_page = $wp_query->get('paged', 1);
	$cur_page = $cur_page < 1 ? 1 : $cur_page;
	$listings_per_page = $wp_query->get('posts_per_page');
	$start_index = ($cur_page - 1) * $listings_per_page + 1;
	$end_index = min($cur_page * $listings_per_page, $wp_query->found_posts);

	echo "<p class='aw-ArchiveResultsDescription'>"
         . sprintf(__("Showing %d to %d of %d locations.", CHILD_THEME_NAME),
            $start_index, $end_index, $wp_query->found_posts) . "</p>";
}

aw_add_location_cards_wrapper( );

//* Remove the entry meta in each entry's header (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_filter( 'post_class', 'aw_grid_custom_post_class' );

aw_add_location_type_card_grid_view_customizations();

genesis();
