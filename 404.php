<?php

/* Template for 404 Page */

// Full Width Layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

function anania_404_body($classes) {
	
	$classes[] = 'page-builder-template';
	
	return $classes;
	
} add_filter( 'body_class', 'anania_404_body' );

function anania_404() {
	block_template_part( '404' );
}

// Replace Default Content
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action('genesis_loop', 'anania_404');


genesis();