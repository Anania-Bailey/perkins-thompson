<?php

$className = ' has-small-font-size';

if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
} 

// Block alignment
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}?>

<div class="site-credits<?php echo $className; ?>" style="text-transform:uppercase">
	Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?> <span class="dev">Developed by <a href="https://ananiabailey.com" target="_blank" aria-label="Anania Bailey (Opens in New Tab)">Anania Bailey</a></span>
</div>