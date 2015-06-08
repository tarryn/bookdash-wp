<?php
/**
 * Blocking direct access to theme PHP files for security
 */
	defined('ABSPATH') or die("No script kiddies please!");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="http://ogp.me/ns/fb#"
<?php language_attributes(); ?>
>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title('—', true, right); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat+Alternates:400,700|Crimson+Text:400,400italic,700,700italic|Source+Sans+Pro:300,400,600,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
</head>

<body>

<div id="debug">
</div><!--#debug-->

    <div id="wrapper">

		<div id="header">
		</div><!--#header -->
        
        <div id="go-to">
        	<a href="#" class="go-top-button">Top</a>
        </div><!--#go-to-->
		
        <div class="content">