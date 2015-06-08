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
?><div class="post">
<?php

/* If this is a search-results page */
if (is_search()) { ?>
	<h1 class="page-title">You searched for <?php the_search_query(); ?></h1>
	<?php }

if (have_posts()) :
	while (have_posts()) :
		the_post();
		?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title( '<h2 class="post-title-archive">', '</h2>' )?></a><?php;
			if ( has_post_thumbnail() ) {
			?><a class="archive-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_post_thumbnail($page->ID, 'thumbnail')?></a><?php;
			}
		the_content();
	endwhile;
endif;
?></div><!--.post--><?php
get_footer(); 
?>