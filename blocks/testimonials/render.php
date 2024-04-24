<?php

$post_id = $context['postId'];
$className = 'pt-slider pt-testimonials';

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

$num = 1;

if (get_field('number_to_display')) {
	$num = get_field('number_to_display');
}

$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => $num,
	'orderby' => 'rand' 
);

if (get_post_type($post_id) == 'practice-area') {
	$args['meta_query'] = array(
		array(
			'key' => 'practice_areas',
			'value' => '"' . $post_id . '"',
			'compare' => 'LIKE'
		)
	);
} 

$testimonials = new WP_QUERY($args);
$slideArgs = array(
	'slidesToShow' => 1,
	'slidesToScroll' => 1,
	'dots' => true,
	'arrows' => false,
	'adaptiveHeight' => false,
	'autoplay' => true,
	'autoPlaySpeed' => 8000,
	'fade' => true,
	'cssEase' => 'linear'
);

if ($testimonials->have_posts()):
	$data = '';
	if (!is_admin()) {
		$data = json_encode($slideArgs);
	} ?>
	
	<div<?php echo $anchor;?> class="<?php echo $className; ?>" data-slick='<?php echo $data; ?>'>
		<?php while ($testimonials->have_posts()): $testimonials->the_post(); ?>
			<div class="pt-testimonial">
				<blockquote>
					<?php the_content();?>
					<?php if (get_field('name', get_the_ID()) || get_field('company_title', get_the_ID())):?>
					<cite>
						<?php if (get_field('name', get_the_ID())): ?>
							<span class="pt-testimonial-name"><?php the_field('name', get_the_ID()); ?></span>
						<?php endif;
						if (get_field('company_title', get_the_ID())):?>
							<span class="pt-testimonial-extras"><?php the_field('company_title', get_the_ID()); ?></span>
						<?php endif; ?>
					</cite>
					<?php endif; ?>
				</blockquote>
			</div>
		<?php endwhile; ?>
	</div>

<?php endif;  wp_reset_query(); ?>