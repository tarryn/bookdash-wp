<?php
/**
 * Book Dash functions and definitions, based largely on Wordpress Twenty Fourteen
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * @package WordPress
 * @subpackage Book_Dash
 * @since Book Dash 1.0
 */

if ( ! function_exists( 'bookdash_setup' ) ) :
/**
 * Book Dash setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Book Dash 1.0
 */
function bookdash_setup() {

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'bookdash-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary menu in sidebar', 'bookdash' ),
		'secondary' => __( 'Secondary menu in sidebar', 'bookdash' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

}
endif; // bookdash_setup
add_action( 'after_setup_theme', 'bookdash_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Book Dash 1.0
 */
function bookdash_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'bookdash_content_width' );


register_sidebar( array(
	'name'          => __( 'Sidebar', 'bookdash' ),
	'id'            => 'sidebar',
	'description'   => '',
    'class'         => '',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div><!--.widget-->',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>',
) );


if ( ! function_exists( 'bookdash_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Book Dash 1.0
 */
function bookdash_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Book Dash attachment size.
	 *
	 * @since Book Dash 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'bookdash_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;


/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Book Dash 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function bookdash_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'bookdash_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Book Dash 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function bookdash_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'bookdash_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Book Dash 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function bookdash_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'bookdash' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'bookdash_wp_title', 10, 2 );

/**
 * Add an image size that suits our theme
 */
add_image_size( 'post-width', 530, 530 ); // Up to 530 pixels wide or 530 pixels tall, soft proportional crop mode
 /*And add it to the admin size chooser */ 
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'post-width' => __('Full post width'),
    ) );
}

/**
 * Remove scroll on clicking more link
 */
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

/**
 * Manage the 'read more' link text
 */
add_filter( 'the_content_more_link', 'modify_read_more_link' );
function modify_read_more_link() {
return '<a class="more-link" href="' . get_permalink() . '">Read more</a>';
}

/**
 * Add a [tags] shortcode to display posts anywhere
 * (Thanks Aibrean http://stackoverflow.com/a/28202573/1781075)
 */

function sc_taglist(){

    return get_the_tag_list('<span class="tag-list-before"></span>',', ','');
}
add_shortcode('tags', 'sc_taglist');

/**
 * Add a [languages] shortcode to display a post's categories.
 * If the post is in 'Books', i.e. it's a book, this will display.
 * It'll list the subcategories of 'Book', which should only be languages.
 */

function languages( $atts, $content = null ) {
   if ( in_category('books') ) {
      global $post;
         $categories = wp_list_categories( array(
            'child_of'            => '6',
            'title_li'            => __( '' ),
            'echo'                => false,
         ) );
      echo '<ul class="language-list">' . $categories . '</ul>';
   }
}
add_shortcode("languages", "languages");