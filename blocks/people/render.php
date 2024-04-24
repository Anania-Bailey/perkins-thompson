<?php

$post_id = $context['postId'];
$className = 'pt-attorneys';

if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}

$anchor = null;
if (!empty($block['anchor'])) {
	$anchor = ' id="' . $block['anchor'] . '"';
}

$num = 3;

if (get_field('number_to_display')) {
	$num = get_field('number_to_display');
}

$args = array(
	'post_type' => 'people',
	'posts_per_page' => $num,
	'orderby' => 'rand'
);

if (get_post_type($post_id) == 'practice-area') {
	$args['meta_query'][] = array(
			'key' => 'practice_areas',
			'value' => '"' . $post_id . '"',
			'compare' => 'LIKE'
	);
} 

if (get_field('show_featured')) {
	$args['meta_query'][] = array(
			'key' => 'featured',
			'value' => 1
	);
}

if (get_field('positions')) {
	$args['tax_query'][] = array(
		'taxonomy' => 'position',
		'field'    => 'term_id',
		'terms'    => get_field('positions') 
	);
}

if (get_field('sort') == 'lastname') {
	$args['orderby'] = 'meta_value';
	$args['meta_key'] = 'last_name';
	$args['order'] = 'ASC';
}

if (get_field('sort') == 'firstname') {
	$args['orderby'] = 'title';
	$args['order'] = 'ASC';
}

$people = new WP_QUERY($args);

if ($people->have_posts()): ?>
	
	<div<?php echo $anchor;?> class="<?php echo $className; ?>">
		<?php while ($people->have_posts()): $people->the_post(); ?>
			<a href="<?php the_permalink(); ?>" class="pt-person">
				<?php the_post_thumbnail('portrait', array('class'=>'pt-portrait')); ?>
				<div class="pt-person-overlay">
					<span class="pt-person-name"><?php the_title(); ?></span>
				</div>
			</a>
		<?php endwhile; ?>
	</div>

<?php endif;  wp_reset_query(); ?>