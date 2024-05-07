<?php

/* =========================================================

	Archive Index

========================================================= */

// Full Width Layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

function anania_index_body($classes) {
	
	$classes[] = 'page-builder-template';
	
	return $classes;
	
} add_filter( 'body_class', 'anania_index_body' );

// Blog Grid
function anania_blog_content() { 

	block_template_part( 'blog' );
	
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action('genesis_loop', 'anania_blog_content');

genesis();