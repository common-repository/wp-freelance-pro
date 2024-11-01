<?php
/**
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 */
include('wpf-setup.php');


// block WP-ADMIN
add_action('admin_init','mp_admin_init');

// Deny wp-admin to all but the super admin.
function mp_admin_init()
{
require_once(ABSPATH . WPINC . '/pluggable.php');
$current_user = wp_get_current_user();
if($current_user->ID != '1' )
{
wp_redirect(get_option('home'),302);
die();
}
}

if ( ! function_exists( 'majormedia_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function majormedia_setup() {
	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'wpfrl', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpfrl' ),
	) );

	add_theme_support('post-thumbnails'); 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// custom backgrounds
	

	// adding post format support
	add_theme_support( 'post-formats', 
		array( 
			'aside', /* Typically styled without a title. Similar to a Facebook note update */
			'gallery', /* A gallery of images. Post will likely contain a gallery shortcode and will have image attachments */
			'link', /* A link to another site. Themes may wish to use the first <a href=ÓÓ> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it */
			'image', /* A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image */
			'quote', /* A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title */
			'status', /*A short status update, similar to a Twitter status update */
			'video', /* A single video. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin) */
			'audio', /* An audio file. Could be used for Podcasting */
			'chat' /* A chat transcript */
		)
	);
}
endif;

add_action( 'after_setup_theme', 'majormedia_setup' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
function majormedia_content_width() {
	global $content_width;
	if (!isset($content_width))
		$content_width = 615; /* pixels */
}
add_action( 'after_setup_theme', 'majormedia_content_width' );

/**
 * Title filter 
 */
function majormedia_filter_wp_title( $title ) {
    // Get the Site Name
    $majormedia_site_name = get_bloginfo( 'name' );
    // Prepend name
    $majormedia_filtered_title = $majormedia_site_name . $title;

	// Get the Site Description
	$majormedia_site_description = get_bloginfo( 'description' );
	// Append Site Description to title
	if ( $majormedia_site_description && ( is_home() || is_front_page() ) ) {
		$majormedia_filtered_title = $majormedia_site_name . ' | ' . $majormedia_site_description;
	}

    // Return the modified title
    return $majormedia_filtered_title;
}
// Hook into 'wp_title'
add_filter( 'wp_title', 'majormedia_filter_wp_title' );




/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( ! function_exists( 'majormedia_main_nav' ) ) :
function majormedia_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'menu' => 'primary', /* menu name */
			'container' => 'div',
			'container_class' => 'hmenuc',
    		'theme_location' => 'primary', /* where in the theme it's assigned */
    		'container_class' => 'menu', /* container class */
    		'fallback_cb' => 'majormedia_main_nav_fallback' /* menu fallback */
    	)
    );
}
endif;

if ( ! function_exists( 'majormedia_main_nav_fallback' ) ) :
	function majormedia_main_nav_fallback() { wp_page_menu( 'show_home=Home&menu_class=menu' ); }
endif;


function majormedia_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
 }
add_action( 'wp_enqueue_scripts', 'majormedia_enqueue_comment_reply' );


function majormedia_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'majormedia_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function majormedia_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar Right', 'wpfrl' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar block', 'wpfrl' ),
		'id' => 'sidebar-block',
		'description' => 'barebones small 300 x 60 px fixed block underneath sidebar',
		'before_widget' => '',
		'after_widget' => "",
		'before_title' => '',
		'after_title' => '',
	) );

register_sidebar( array(
		'name' => __( 'middle cut', 'wpfrl' ),
		'id' => 'middle-cut',
		'description' => 'a widget area that sliced the INDEX page right down the middle. This area has no css make-up on its own',
		'before_widget' => '<center>',
		'after_widget' => "</center>",
		'before_title' => '',
		'after_title' => '',
	) );
	
register_sidebar(array(
'name' => 'Footer Widget left',
'before_widget' => '<li class="" >',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));
	
	register_sidebar(array(
'name' => 'Footer Widgets Middle',
'before_widget' => '<li class="" >',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));

register_sidebar(array(
'name' => 'Footer Widgets Right',
'before_widget' => '<li class="" id="3">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));

}
add_action( 'widgets_init', 'majormedia_widgets_init' );

if ( ! function_exists( 'majormedia_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function majormedia_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'wpfrl' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wpfrl' ) . '</span> Previous' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', 'Next <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wpfrl' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wpfrl' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wpfrl' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


if ( ! function_exists( 'majormedia_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function majormedia_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'wpfrl' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'wpfrl' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
	echo " | " . get_the_term_list( $post->ID, 'freelance_category', 'category: ', ', ', '' );
	echo " | " .  get_the_term_list( $post->ID, 'freelance_tag', 'tags: ', ', ', '' );
	if (is_super_admin() ) edit_post_link( __( '(Edit)', 'wpfrl' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Adds custom classes to the array of body classes.
 */
function majormedia_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'majormedia_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 */
function majormedia_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so majormedia_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so majormedia_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in majormedia_categorized_blog
 */
function majormedia_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'majormedia_category_transient_flusher' );
add_action( 'save_post', 'majormedia_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function majormedia_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'majormedia_enhanced_image_navigation' );


if ( ! function_exists( 'majormedia_pagination' ) ) :
function majormedia_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
 
     if($pages == '')
     {
         global $the_query;
         $pages = $the_query->max_num_pages;
         add_query_arg( 'post_type', 'freelance_post' );
		 if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         printf( __( '<div class="pagination"><span>Page %1$s of %2$s</span>', 'wpfrl'), $paged, $pages );
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) printf( __( '<a href="%1$s">&laquo; First</a>', 'wpfrl' ), get_pagenum_link(1) );
         if($paged > 1 && $showitems < $pages) printf( __( '<a href="%1$s">&lsaquo; Previous</a>', 'wpfrl' ), get_pagenum_link($paged - 1) );
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Next &rsaquo;</a>', 'wpfrl' ), get_pagenum_link($paged + 1) );
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Last &raquo;</a>', 'wpfrl' ), get_pagenum_link($pages) );
         echo "</div>\n";
     }
}
endif;

function majormedia_custom_scripts() {
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '1.0.0' );
}
add_action('wp_enqueue_scripts', 'majormedia_custom_scripts');

/*
comment form data - ESTIMATES RESPONSES
*/

if ( ! function_exists( 'majormedia_comment' ) ) :

function majormedia_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'wpfrl' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'wpfrl' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class='estimates'>

			<div class='estimates-left'>
			<?php
			// let post owner decide which estimate to accept.
			$current_user = wp_get_current_user();			
			if (get_the_author_meta('ID') == $current_user->ID)
				{
				// we are the post owner
				echo "<!--welcome postowner estimateaccept is set to ". $_POST['estimateaccept'] ."-->";
				// postowner chose something on an estimate
				$bc = get_post_meta(get_the_ID(), 'estimatechosen', TRUE);
				if (wp_verify_nonce($_POST['estimateaccept'],get_comment_ID().'yes') && empty($bc) )	//security
					{
					// estimate selected - mark postmeta
					update_post_meta(get_the_ID(), 'estimatechosen', get_comment_ID() ); // set current comment ID in postmeta						
					// reward estimate author
					$authorname = $comment->comment_author;
					$cauthor = get_user_by('login', $authorname);		
					$rating = get_user_meta($cauthor->ID ,'rating',TRUE );
					$rating=$rating+7;
					update_user_meta($cauthor->ID ,'rating', $rating );
					// show victory
					echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/award.png' . "' title='" . __('And the winner is ......' , 'wpfrl') . "'>";
					_e('<br><strong>The job lister has chosen this offer and has closed the job offer</strong>', 'wpfrl');
					// send e-mail to estimator
					}					
				elseif (wp_verify_nonce($_POST['estimateaccept'],get_comment_ID().'no') && empty($bc) )	//security
					{	
					// declined this estimate but not yet chosen a winner
					update_comment_meta( $comment->comment_ID, 'declined', '1' ); // set this estimate's meta
					echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/error.png' . "' title='" . __('Sorry, this is not the estimate chosen by the job poster.' , 'wpfrl') . "'>";						
					_e('<br><strong>The job lister has declined this offer but is still taking estimates and bids</strong>', 'wpfrl');
					}					
				else
					{
					echo "<!--welcome postowner - no requests taken-->";
					$declined = get_comment_meta( $comment->comment_ID, 'declined', TRUE );					
					$bidcheck = get_post_meta(get_the_ID(), 'estimatechosen', TRUE);
					if ($declined)
						{
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/error.png' . "' title='" . __('Sorry, this is not the estimate chosen by the job poster.' , 'wpfrl') . "'>";												
						_e('<br><strong>The job lister has declined this offer and has closed this job offer.</strong>', 'wpfrl');
						}
					elseif ($bidcheck == get_comment_ID())
						{
						// this is the winning estimate
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/award.png' . "' title='" . __('And the winner is ......' , 'wpfrl') . "'>";
						_e('<br><strong>The job lister has chosen this offer and has closed the job offer</strong>', 'wpfrl');
						}
					elseif (!empty($bidcheck))
						{
						// estimate is chosen but it's not us
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/error.png' . "' title='" . __('Sorry, this is not the estimate chosen by the job poster.' , 'wpfrl') . "'>";
						_e('<br><strong>The job lister has declined this offer and has closed this job offer.</strong>', 'wpfrl');
						}
					else
						{
						// provide postowner choice to accept offer
						_e('Accept offer<br>','wpfrl');
						?>
						<form method='post'>
						<?php wp_nonce_field(get_comment_ID().'yes','estimateaccept'); ?>
						<input type="hidden" name="accept" value="yes">
						<input type="hidden" name="commid" value="<?php comment_ID(); ?>">
						<input type='image' src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/ok.png"; ?>' onmouseover="this.src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/tu.png"; ?>'" onmouseout="this.src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/ok.png"; ?>'">
						</form>
						<?php
						_e('Decline offer<br>','wpfrl');
						?>
						<form method='post'>
						<?php wp_nonce_field(get_comment_ID().'no','estimateaccept'); ?>
						<input type="hidden" name="accept" value="no">
						<input type="hidden" name="commid" value="<?php comment_ID(); ?>">
						<input type='image' src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/error.png"; ?>' onmouseover="this.src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/td.png"; ?>'" onmouseout="this.src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/error.png"; ?>'">
						</form>
						<?php
						}
					}
				}
			else
				{
				echo "<!--welcome visitor - just browsing ?-->";
				// we are not the postowner so no choices - just display scenarios
				$declined = get_comment_meta( $comment->comment_ID, 'declined', TRUE );					
				$bidcheck = get_post_meta(get_the_ID(), 'estimatechosen', TRUE);
					if ($declined)
						{
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/error.png' . "' title='" . __('Sorry, this is not the estimate chosen by the job poster.' , 'wpfrl') . "'>";												
						}
					elseif ($bidcheck == get_comment_ID())
						{
						// this is the winning estimate
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/award.png' . "' title='" . __('And the winner is ......' , 'wpfrl') . "'>";
						}
					elseif (!empty($bidcheck))
						{
						// estimate is chosen but it's not us
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/error.png' . "' title='" . __('Sorry, this is not the estimate chosen by the job poster.' , 'wpfrl') . "'>";
						}
					else
						{
						echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/question.png' . "' ><br/>";
						printf(__('%1$s has not yet decided to accept or decline this offer','wpfrl'), get_the_author()) ;
						}
				}
			?>				
			</div>
				
			<div class='estimates-middle'>
			
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your estimate is awaiting moderation.', 'wpfrl' ); ?></em>
					<br />
				<?php endif; ?>

					<div>				
					<?php 
					comment_text(); 
					echo "<br>";
					$dline = get_comment_meta( $comment->comment_ID, 'deadline', true ); 
					if (!empty($dline))
						{
						printf( __( '%s', 'wpfrl' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) );
						echo " ";
						_e('thinks this job can be completed in' , 'wpfrl');
						echo " ";
						echo $dline;
						}									
					?>
					</div>
	
			</div>
			
			<div class='estimates-right'>
			<?php 
				// get author ID and show avatar
				$authorname = $comment->comment_author;
				$cauthor = get_user_by('login', $authorname);					
				wpfr_avatar( $cauthor->ID,100); 
				?>
				<h3><?php printf( __( '%s', 'wpfrl' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h3>
				
				<?php 
				printf( __( '%s', 'wpfrl' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) );
				echo " ";
				_e('estimated this job' , 'wpfrl');
				echo " ";
				echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) ." " . __(' ago at: <br>','wpfrl');
				$budget = get_comment_meta( $comment->comment_ID, 'budget', true ); 
				echo $budget;
				?>
				
			</div>
			
			<div style='clear:both'></div>
			
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">				
				<time pubdate datetime="<?php comment_time( 'c' ); ?>">
				<?php printf( __( 'Posted %1$s at %2$s', 'wpfrl' ), get_comment_date(), get_comment_time() ); ?>
				</time></a>
				<?php edit_comment_link( __( '(Edit)', 'wpfrl' ), ' ' ); ?>
			
			<?PHP
			// only show comment response when job is still open
			$bidcheck = get_post_meta(get_the_ID(), 'estimatechosen', TRUE);
			if (empty($bidcheck))
				{
				?>
				<div class='response'>
				<form method='post'>
				
				<input type='text' name='response' placeholder="<?php _e( 'respond to this estimate' , 'wpfrl' ); ?>" >
				<input type="hidden" name="commid" value="<?php comment_ID(); ?>">
				<?php 		
				if (is_user_logged_in() ) 
					{
					wp_nonce_field(get_comment_ID(),'respond'); 
					?>
					<input type='submit' value='<?php _e('respond', 'wpfrl'); ?>' id='button'>
					<?php
					}
				else
					{
					?>
					<a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login"><?php _e('log in to respond','wpfrl');?></a>
					<?php				
					}
				?>
				</form>
				</div>
				<?PHP
				}
				?>
		</div>
		
		<?php 
		// estimate response box - small dashed
					
			if (wp_verify_nonce($_POST['respond'],get_comment_ID() )  && $_POST['commid'] == get_comment_ID() )	//security
				{
				echo "<div class='estimate-comment'>";
				$response = get_comment_meta( get_comment_ID() , 'response', true );
				$link = get_author_posts_url( $current_user->ID , $current_user->user_login ); // author page of currently logged in user
				$response =  stripslashes($response) . "<a href='$link'>$current_user->user_login</a> : ". $_POST['response'] . "<br/>";	
				update_comment_meta( get_comment_ID() , 'response', $response ); 
				echo $response;
				echo "</div>";
				}
			else
				{
				$response = get_comment_meta( get_comment_ID() , 'response', true ); 
				if (!empty($response))
					{
					echo "<div class='estimate-comment'>";
					echo stripslashes($response);
					echo "</div>";
					}
				}					

			break;
	endswitch;
}
endif;

// extra form fields comments
	add_action( 'comment_form_logged_in_after', 'additional_fields' );
	add_action( 'comment_form_after_fields', 'additional_fields' );

	function additional_fields () 
		{
		$current_user = wp_get_current_user();
		echo '<div class="half"><label for="budget">' . __( 'your price estimate:' ,'wpfrl') . '</label><input id="title" name="budget" type="text" size="30"  tabindex="5" /></div>';		
		echo '<div class="half"><label for="deadline">' . __( 'estimated time to complete:' ,'wpfrl') . '</label><input id="title" name="deadline" type="text" size="30"  tabindex="5" /></div>';			
		echo '<input type="hidden" name="commentauthor" value="' . $current_user->ID . '">';
		echo '<input type="hidden" name="postauthor" value="' . get_the_author_meta('ID') . '">';		
		}

// save form field data		
	add_action( 'comment_post', 'processfields', 10, 1 );
	function processfields( $comment_ID )
		{
		if( isset( $_POST['budget'] ) ) update_comment_meta( $comment_ID, 'budget', esc_attr( $_POST['budget'] ) );
		if( isset( $_POST['deadline'] ) ) update_comment_meta( $comment_ID, 'deadline', esc_attr( $_POST['deadline'] ) );
		// reward comment author
		$score = get_user_meta($_POST['commentauthor'] ,'score',TRUE );
		$score++;
		update_user_meta($_POST['commentauthor'] ,'score',$score );
		// reward post author
		$score = get_user_meta($_POST['postauthor'] ,'score',TRUE );
		$score=$score+6;
		update_user_meta($_POST['postauthor'] ,'score',$score );
		
		// send notice to the post owner
		$user = get_user_by('id', $_POST['postauthor']);
		$to = $user->user_email;
		$subject = __('someone responded to your freelance listing', 'wpfrl');
		$message .= __('Hello, a response to one of your listings was just posted on our site.', 'wpfrl');
		$message .= sprintf(__('You can visit %1$s to see your listing and its responses', 'wpfrl'), home_url() );
		wp_mail( $to, $subject, $message );			
		}

	

// simple local avatar	
function wpfr_avatar($id ,$size= '200' )
	{
	$imurl = get_user_meta( $id, 'lavatar',TRUE);
	if (strlen($imurl) < 5) $imurl = get_bloginfo('stylesheet_directory') . '/library/images/dunno.jpg';
	$data = "<img src='$imurl' width='$size' height='$size'>";

	printf( __( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>', 'wpfrl' ),
		esc_url( get_author_posts_url( $id ) ),
		esc_attr( __( 'View all listings by this person', 'wpfrl' )),
		$data );	
	}
	
// counters - pulled from content single 
function  wpfrl_add_view_count() {
	$id = get_the_ID() ;
	$count = get_post_meta( $id, 'viewcount', TRUE);
	if ($count < 1) { update_post_meta( $id, 'viewcount', 1);}
	else {$count++; update_post_meta( $id, 'viewcount', $count);}
	
	// reward post author
	if ($count == 50)
		{
		$score = get_user_meta(get_the_author_meta('ID') ,'score',TRUE );
		$score=$score+5;
		update_user_meta(get_the_author_meta('ID') ,'score',$score );	
		}
	if ($count == 200)
		{
		$score = get_user_meta(get_the_author_meta('ID') ,'score',TRUE );
		$score=$score+15;
		update_user_meta(get_the_author_meta('ID') ,'score',$score );

		$score = get_user_meta(get_the_author_meta('ID') ,'rating',TRUE );
		$score=$score+7;
		update_user_meta(get_the_author_meta('ID') ,'rating',$score );
		}
	}	

// check if title already exists
function wpf_title_exist($title) {
	global $wpdb;
    $number = $wpdb->get_var($wpdb->prepare( "SELECT ID FROM wp_posts WHERE post_title = '" . $title . "' " ) );
    if ( empty($number) ) return FALSE; else return TRUE;	
	}

// lists

	