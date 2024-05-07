<?php

$post_id = $context['postId'];
$className = 'pt-articles';

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
	'post_type' => 'post',
	'posts_per_page' => 4
  );

if (get_post_type($post_id) == 'people') {
	$args['meta_query'][] = array(
			'key' => 'attorneys',
			'value' => '"' . $post_id . '"',
			'compare' => 'LIKE'
	);
} 

if (get_post_type($post_id) == 'practice-areas') {
	$args['meta_query'][] = array(
			'key' => 'practice_areas',
			'value' => '"' . $post_id . '"',
			'compare' => 'LIKE'
	);
} 

if (get_field('practice_areas')) {
	$paargs = array(
		'post_type' => 'practice-area',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'tax_query' => array(array(
				'taxonomy' => 'silo',
				'field'    => 'term_id',
				'terms'    => get_field('practice_areas') 
			))
	);
	
	$pas = get_posts($paargs);
	
	$args['meta_query'][] = array(
			'key' => 'practice_areas',
			'value' => $pas,
			'compare' => '='
	);
}

$articles = new WP_QUERY($args);

if ($articles->have_posts()): ?>
	
	<div<?php echo $anchor;?> class="<?php echo $className; ?>">
	<?php while ($articles->have_posts()): $articles->the_post(); ?>
	<div class="pt-article">
		<div class="pt-article-img">
			<?php if (has_post_thumbnail()):
						the_post_thumbnail('square', array('class'=>'pt-article-thumb'));
					endif; ?>
		</div>
		<div class="pt-article-desc">
			
				<h3 class="pt-article-title"><a href="<?php the_permalink(); ?>" class="pt-article-link"><?php the_title(); ?></a></h3>
			<div class="pt-article-meta">
				<div class="pt-article-date">
					<div class="wp-block-outermost-icon-block">
						<div class="icon-container has-icon-color has-pt-gray-color" style="color:#A7ADAF;width:15px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-label="Calendar">
								<path d="M152 24V0H104V24 64H0v80 48V464v48H48 400h48V464 192 144 64H344V24 0H296V24 64H152V24zM48 192H400V464H48V192z"></path>
							</svg></div>
					</div>
					<time datetime="<?php echo get_the_date('Y-m-d H:i:s');?>">
						<?php echo get_the_date('F j');?>
					</time>
				</div>
				<?php if (get_field('attorneys', get_the_ID()) && get_post_type($post_id) != 'people'):?>
				<div class="pt-article-author">
					<div class="wp-block-outermost-icon-block"><div class="icon-container has-icon-color has-pt-gray-color" style="color:#A7ADAF;width:15px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-label="Author"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg></div></div>
					<?php foreach(get_field('attorneys', get_the_ID()) as $attorney):?>
						<a href="<?php echo get_the_permalink($attorney);?>"><?php echo get_the_title($attorney);?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
	</div>

<?php endif;  wp_reset_query(); ?>