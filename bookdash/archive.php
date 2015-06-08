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
/* If this is a category archive */
if (is_category()) { ?>
	<h1 class="page-title"><?php single_cat_title(); ?></h1>
	<div class="category-page-description"><?php echo category_description( $category_id ); ?></div><!--.category-page-description-->
	<?php } 

if (have_posts()) :
	while (have_posts()) :
		?><div <?php post_class(); ?>><?php
		the_post();
		?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title( '<h2 class="post-title-archive">', '</h2>' )?></a><?php;
			if ( has_post_thumbnail() ) {
			?><a class="archive-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_post_thumbnail($page->ID, 'thumbnail')?></a><?php;
			}
		the_content();
		?></div><!--.<?php post_class(); ?>--><?php
	endwhile;
endif;
?></div><!--.post--><?php
get_footer(); 
?>