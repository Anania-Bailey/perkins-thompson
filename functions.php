<?php

/****************************************************************

    Genesis Basics

****************************************************************/

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Perkins Thompson' );
define( 'CHILD_THEME_URL', 'https://ananiabailey.com' );
define( 'CHILD_THEME_VERSION', '1.0.0' );


/****************************************************************

    Enqueue Scripts & Styles

****************************************************************/

// no-js class on load
function anania_no_js($classes) {
  
  $classes[] = 'no-js';
  
  return $classes;
  
} add_filter( 'body_class', 'anania_no_js' );

// disable no-js
function anania_html_js_class () {
    echo '<script>document.querySelector(\'body\').classList.remove(\'no-js\');</script>'. "\n";
}
add_action( 'genesis_before_header', 'anania_html_js_class', 1 );

// Enqueue Scripts & Styles
function anania_enqueue_scripts_styles() {

    wp_enqueue_style( 'adobe-fonts', '//use.typekit.net/qpn4vfv.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'anania-css', get_stylesheet_directory_uri() . '/main.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'anania-scripts', get_stylesheet_directory_uri() . '/js/anania-scripts-min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
    
    // Remove Superfish
    wp_deregister_script( 'superfish' );
    wp_deregister_script( 'superfish-args' );
    wp_dequeue_script( 'superfish' );
    wp_dequeue_script( 'superfish-args' );

} add_action( 'wp_enqueue_scripts', 'anania_enqueue_scripts_styles' );

// Admin Scripts & Styles
function anania_enqueue_editor() {
  wp_enqueue_style( 'adobe-fonts', '//use.typekit.net/qpn4vfv.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'editor-styles', get_stylesheet_directory_uri() . '/editor-style.css', array(), CHILD_THEME_VERSION );
} add_action( 'enqueue_block_editor_assets', 'anania_enqueue_editor' );

// Noscript tags
function anania_footer_junk() { ?>
  <noscript>
    <style>
    </style>
  </noscript>
<?php } add_action('wp_footer', 'anania_footer_junk');

// Add onclick to Body to fix iPad hover issue
function anania_body_attr( $attributes ) {
 $attributes['onclick'] = true; 
 return $attributes;
} add_filter( 'genesis_attr_body', 'anania_body_attr' );


/****************************************************************

    Supports & Outputs

****************************************************************/
// Adds support for HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support('genesis-responsive-viewport');

// Add Gutenberg Alignments
function anania_alignments() {
  add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'anania_alignments' );

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
	)
);

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Removes Dual-Sidebar Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Remove Blog & Archive Page Templates
function anania_remove_page_templates( $templates ) {
	unset( $templates['page_blog.php'] );
	unset( $templates['page_archive.php'] );
	return $templates;
} add_filter( 'theme_page_templates', 'anania_remove_page_templates' );

// Block-based template parts
add_theme_support( 'block-template-parts' );

// Remove category extras
remove_action( 'admin_init', 'genesis_add_taxonomy_archive_options' );


/****************************************************************

    Navigation

****************************************************************/

// Renames primary and secondary navigation menus.
add_theme_support(
    'genesis-menus', array(
        'primary'   => __( 'Primary Menu', 'anania-bailey' ),
        'secondary'   => __( 'Practice Area Menu', 'anania-bailey' ),
        'tertiary' =>__('Mobile Menu', 'anania-bailey')
    )
);

// Custom Nav Walker
class AB_Desktop_Walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
    $output .= "<li class='" .  implode(" ", $item->classes) . "'>";
    
    if ($item->url && $item->url != '#') {
      $output .= '<a href="' . $item->url . '">';
    } else {
      $output .= '<span class="linkless" tabindex="0">';
    }
 
    $output .= $item->title; 
    
    if ($args->walker->has_children && $depth == 0) {
      $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.385 10" class="down-icon"><path id="angle-down-shprfc-solid" d="M26.892,124.7l.9-.9,6.385-6.385.906-.906L33.277,114.7l-.9.9-5.483,5.483-5.483-5.479-.9-.906L18.7,116.508l.9.9,6.385,6.385Z" transform="translate(-18.7 -114.7)"/></svg>';
    }
 
    if ($item->url && $item->url != '#') {
      $output .= '</a>';
    } else {
      $output .= '</span>';
    }
  }
}

// Custom Nav Walker
class AB_Mobile_Walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
    $output .= "<li class='" .  implode(" ", $item->classes) . "'>";

    if ($args->walker->has_children) {
      $output .= '<span class="menu-item-wrapper">';
    }
    
    if ($item->url && $item->url != '#') {
      $output .= '<a href="' . $item->url . '">';
    } else {
      $output .= '<span class="linkless" tabindex="0">';
    }
 
    $output .= $item->title; 
 
    if ($item->url && $item->url != '#') {
      $output .= '</a>';
    } else {
      $output .= '</span>';
    }
    
    if ($args->walker->has_children) {
      $output .= '<button class="submenu-toggle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.385 10" class="submenu-icon"><path id="angle-down-shprfc-solid" d="M26.892,124.7l.9-.9,6.385-6.385.906-.906L33.277,114.7l-.9.9-5.483,5.483-5.483-5.479-.9-.906L18.7,116.508l.9.9,6.385,6.385Z" transform="translate(-18.7 -114.7)"/></svg><span class="screen-reader-text">' .  __( 'Toggle Sub-Menu', 'anania-bailey' ). '</span></button></span>';
    }
  }
}

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Apply Walker to Menu
function anania_menu_args( $args ) {
  if( 'primary' == $args['theme_location'] || 'secondary' == $args['theme_location'] ) {
    $args['walker'] = new AB_Desktop_Walker();
  }
  if( 'tertiary' == $args['theme_location'] ) {
    $args['walker'] = new AB_Mobile_Walker();
    $args['menu_class'] = 'menu genesis-nav-menu menu-mobile';
  }
  return $args;
}
add_filter( 'wp_nav_menu_args', 'anania_menu_args' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

function anania_mobile_output() {
  wp_nav_menu(array('menu'=>'tertiary'));
}
add_action( 'anania_mobile_menu', 'anania_mobile_output');

// Inset Mobile Menu Button
function anania_mobile_toggle() { ?>
    <button class="menu-toggle"><svg width="100%" height="100%" viewBox="0 0 500 300" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" class="toggle-icon" aria-hidden="true"> <g transform="matrix(1,0,0,1,-52.9449,-103.528)"> <g transform="matrix(1.03536,0,0,0.991213,-5.91155,-29.1244)"> <rect x="56.846" y="133.829" width="482.925" height="50.443"/> </g> <g transform="matrix(1.03536,0,0,0.991213,-5.91155,220.145)"> <rect x="56.846" y="133.829" width="482.925" height="50.443"/> </g> <g transform="matrix(1.03536,0,0,0.991213,-5.91155,95.5102)"> <rect x="56.846" y="133.829" width="482.925" height="50.443"/> </g> </g> </svg><span class="screen-reader-text"><?php _e( 'Open Menu', 'anania-bailey' ) ?></span></button>
<?php } add_action('genesis_header', 'anania_mobile_toggle', 11);

// Insert Mobile Menu Container
function anania_mobile_container() { ?>
    <div class="mobile-nav">
        <button class="menu-close"><svg width="100%" height="100%" viewBox="0 0 389 389" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" class="toggle-icon" aria-hidden="true"> <g transform="matrix(1,0,0,1,-96.4586,-97.8764)"> <g transform="matrix(0.732109,-0.732109,0.700893,0.700893,-38.9589,399.248)"> <rect x="56.846" y="133.829" width="482.925" height="50.443"> </g> <g transform="matrix(-0.732109,-0.732109,-0.700893,0.700893,620.785,399.248)"> <rect x="56.846" y="133.829" width="482.925" height="50.443"/> </g> </g> </svg><?php _e( 'Close Menu', 'anania-bailey' ) ?></button>
        <?php do_action('anania_mobile_menu'); ?>
    </div>
<?php } add_action('genesis_after', 'anania_mobile_container');


/****************************************************************

    Widgets

****************************************************************/

//* Enable the block-based widget editor
add_filter( 'use_widgets_block_editor', '__return_true' );

// Remove header right
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Footer Template Output
function anania_footer() { ?>
  <div class="footer-wrap">
    <?php block_template_part( 'footer' ); ?>
  </div>
<?php } add_action('genesis_before_footer', 'anania_footer');

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

/****************************************************************

    Custom Blocks

****************************************************************/

function anania_register_acf_blocks() {
  
    register_block_style('core/cover', [
      'name' => 'page-header',
      'label' => __('Page Header', 'anania-bailey'),
    ]);
    
    register_block_style('core/group', [
      'name' => 'page-header',
      'label' => __('Page Header', 'anania-bailey'),
    ]);
    
    register_block_style('core/group', [
      'name' => 'site-footer',
      'label' => __('Site Footer', 'anania-bailey'),
    ]);
    
    register_block_style('core/heading', [
      'name' => 'page-title',
      'label' => __('Page Title', 'anania-bailey'),
    ]);
    
    register_block_style('core/post-title', [
      'name' => 'page-title',
      'label' => __('Page Title', 'anania-bailey'),
    ]);
    
    // Register Blocks
    register_block_type( __DIR__ . '/blocks/credits' );
    
} add_action( 'init', 'anania_register_acf_blocks', 5 );

// Register Block Scripts
function anania_register_block_script() {
 wp_register_script( '', get_stylesheet_directory_uri() . '', [ 'jquery', 'acf' ] );
} //add_action( 'init', 'anania_register_block_script' ); 

// Disable Front-End ACF InnerBlocks Wrapper
function acf_should_wrap_innerblocks( $wrap, $name ) {
    return false;
} add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2 );

// Remove Default Patterns
function anania_remove_patterns() {
    remove_theme_support('core-block-patterns');
} add_action('after_setup_theme', 'anania_remove_patterns');

/****************************************************************

    ACF Customizations

****************************************************************/

// Filter ACF Index to Start at 0
add_filter('acf/settings/row_index_offset', '__return_zero');

/****************************************************************

    Misc.

****************************************************************/

// Add Image Sizes
add_image_size( 'square', 950, 950, true );

// Add Custom Sizes to Block Editor Drop Down
function anania_custom_image_size($sizes){
    $custom_sizes = array(
      'square' => __( 'Square', 'anania-bailey' )
    );
    return array_merge( $sizes, $custom_sizes );
}
add_filter('image_size_names_choose', 'anania_custom_image_size');


// Set Max upload size
function filter_site_upload_size_limit( $size ) {
  $size = 25 * 1048576;
  return $size;
} add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );


// Filter Archive Titles
function anania_archive_title( $title ) {

    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}

add_filter( 'get_the_archive_title', 'anania_archive_title' );

// More Link
function anania_more_link() {
	return '... <a class="wp-block-post-excerpt__more-link" href="' . get_permalink() . '">' . __( 'Read More', 'anania-bailey' ) . '</a>';
} add_filter( 'get_the_content_more_link', 'anania_more_link' );

// Remove Entry Header Meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );


// Author Gravatar
function anania_author_box_gravatar( $size ) {

	return 120;

} add_filter( 'genesis_author_box_gravatar_size', 'anania_author_box_gravatar' );

// Re-Arrange Comment Fields
function anania_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
} add_filter( 'comment_form_fields', 'anania_move_comment_field_to_bottom' );

// Gravatar Size in Comments
function anania_comments_gravatar( $args ) {

	$args['avatar_size'] = 90;
	return $args;

} add_filter( 'genesis_comment_list_args', 'anania_comments_gravatar' );

/** Remove the edit link */
add_filter ( 'genesis_edit_post_link' , '__return_false' );