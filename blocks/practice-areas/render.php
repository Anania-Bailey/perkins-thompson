<?php

$post_id = $context['postId'];
$className = 'pt-practice-areas';

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

$args = array(
	'post_type' => 'practice-area',
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC'
  );

if (get_post_type($post_id) == 'people') {
	$args['meta_query'][] = array(
			'key' => 'attorneys',
			'value' => '"' . $post_id . '"',
			'compare' => 'LIKE'
	);
} 

if (get_field('practice_areas')) {
	$args['tax_query'][] = array(
		'taxonomy' => 'silo',
		'field'    => 'term_id',
		'terms'    => get_field('practice_areas') 
	);
}

$areas = new WP_QUERY($args);

if ($areas->have_posts()): ?>
	
	<div<?php echo $anchor;?> class="<?php echo $className; ?>">
		<?php while ($areas->have_posts()): $areas->the_post(); ?>
			<div class="pt-practice-area">
				<div class="pt-practice-img">
					<?php if (has_post_thumbnail()):
						the_post_thumbnail('portrait', array('class'=>'pt-practice-thumb'));
					endif; ?>
				</div>
				<div class="pt-practice-desc">
					<h3 class="pt-practice-title"><?php the_title(); ?></h3>
					<div class="pt-practice-snippet has-small-font-size">
						<?php if (get_field('short_description', get_the_ID())):
							the_field('short_description', get_the_ID());
						else:
							the_excerpt();
						endif; ?>
					</div>
					<div class="wp-block-button is-style-arrow-link pt-practice-link"><a class="wp-block-button__link wp-element-button" href="<?php the_permalink();?>">Learn More</a></div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>

<?php endif;  wp_reset_query(); ?>