<?php

/* =========================================================

    Archive Index

========================================================= */

// Full Width Layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

function anania_search_body($classes) {
    
    $classes[] = 'page-builder-template';
    
    return $classes;
    
} add_filter( 'body_class', 'anania_search_body' );

// Blog Grid
function anania_search_content() { 

    block_template_part( 'blog' );
    
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action('genesis_loop', 'anania_search_content');

genesis();