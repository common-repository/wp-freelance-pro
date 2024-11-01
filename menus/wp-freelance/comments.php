<?php
/**
 * The template for displaying Comments.
 */
?>
	<div id="comments">
	<?php	
	$bidcheck = get_post_meta(get_the_ID(), 'estimatechosen', TRUE);
	if (!empty($bidcheck))
		{
		echo "<div style='text-align:center'><h2>This Job-offer has closed down. You can scroll down for more information</h2></div>";
		}
	elseif ( is_user_logged_in() ) 
		{		
		$comments_args = array( 
			'title_reply'    => __('Respond to this job ', 'wpfrl'),
			'title_reply_to' => __('Provide an estimate for ', 'wpfrl'),
			'logged_in_as'   => '',
			'label_submit'   => __('Submit estimate/response', 'wpfrl'),
		   );

		comment_form($comments_args); 
		}
	else
		{
		echo "<div class='notlogged'>";
		echo "<table><tr><td><img src='" . get_bloginfo('stylesheet_directory') .'/library/images/notice.png' . "' width='100%'></td><td>";
		_e('<h3>You need to be logged in to provide estimates and respond to this job !</h3>Please log in or register now.<br/>', 'wpfrl');	
		$args = array(
				'remember' => false
			);
			wp_login_form( $args );				
		echo "</td><td>";
		echo "<a href='". get_bloginfo('url') . "/wp-login.php?action=register' title='". __('register', 'wpfrl'). "'>";
		echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/signin.png' . "' width='100%'><br>";
		_e('register', 'wpfrl');
		echo "</a></td></tr></table>";			
		}
	?>
	
	
	
	<?php if ( have_comments() ) : ?>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text section-heading"><?php _e( 'estimates navigator', 'major-media' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'major-media' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'newer estimates &rarr;', 'major-media' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments.
				 */
				wp_list_comments( array( 'callback' => 'majormedia_comment','reverse_top_level' => TRUE, ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text section-heading"><?php _e( 'estimates navigator', 'major-media' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older estimates', 'major-media' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'newer estimates &rarr;', 'major-media' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are no comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Job is closed.', 'major-media' ); ?></p>
	<?php endif; ?>


</div><!-- #comments -->