<?php
/**
 * Blocking direct access to your theme PHP files for security
 */
	defined('ABSPATH') or die("No script kiddies please!");

/**
 * Run the loop
 */
	
get_header();
get_sidebar();
?><div class="post"><?php
if (have_posts()) :
	while (have_posts()) :
		?><div id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
		the_post();
		?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title( '<h1 class="post-title">', '</h1>' )?></a><?php;
        ?><div class="post-thumbnail"><?php echo get_the_post_thumbnail($page->ID, 'thumbnail')?></div><?php
		the_content();
		?></div><!--.<?php post_class(); ?>--><?php edit_post_link(); ?><?php
	endwhile;
endif;
?></div><!--.post--><?php
get_footer(); 
?>