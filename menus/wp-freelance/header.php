<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title('|', true, 'left'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php wp_head(); ?>
</head>
<?PHP// print_R($wp_query);
 ?>
<body <?php body_class(); ?>>
<div id='curtains'>
	<div id="container">
	<?php do_action( 'before' ); ?>
		<header id="branding" role="banner">
		  <div id="inner-header" class="clearfix">
			
			<nav id="access" role="navigation">
				<h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'wpfrl' ); ?></h1>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'wpfrl' ); ?>"><?php _e( 'Skip to content', 'wpfrl' ); ?></a></div>
				<?php majormedia_main_nav(); // Adjust using Menus in Wordpress Admin ?>
				<?php // get_search_form(); 
				?>
			</nav><!-- #access -->
			
			<div style='float:right'>
			<?php if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			} ?>
			</div>	
	  
		  </div>
		  
		  
		</header><!-- #branding -->
