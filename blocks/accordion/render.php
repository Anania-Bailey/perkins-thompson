<?php

$post_id = $context['postId'];
$className = 'pt-accordion';

$anchor = null;

if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}

if (!empty($block['anchor'])) {
	$anchor = ' id="' . $block['anchor'] . '"';
} 

$id = $post_id + mt_rand(1,1000);

$template = array(
);

?>

<div<?php echo $anchor;?> class="<?php echo $className; ?>">
		<input type="radio" name="<?php the_field('name'); ?>" id="accordion-<?php echo $id; ?>" value="accordion-<?php echo $id; ?>" class="pt-radio"<?php if (get_field('open')) {?> checked<?php } ?>>
		<label for="accordion-<?php echo $id;?>" class="pt-radio-label"><?php the_field('title'); ?><span class="screen-reader-text"> (Select to learn more.)</span></label>
		<div class="accordion-content">
			<div class="accordion-content-inner">
				<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"/>
			</div>
		</div>
</div>