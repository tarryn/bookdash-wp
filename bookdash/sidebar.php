<?php
/**
 * Blocking direct access to your theme PHP files for security
 */
	defined('ABSPATH') or die("No script kiddies please!");
?>

	<div class="sidebar">

		<div class="logo">
                	<a href="<?php echo site_url(); ?>"></a>
                </div><!--.logo-->
            	
		<?php dynamic_sidebar( 'sidebar' ); ?> 

	</div><!--.sidebar-->