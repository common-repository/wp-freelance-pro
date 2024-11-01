<div class='postjob'>

<?php 
// get post data
$post_object = get_post( $np );
print_R($post_object); //->post_content;

// check if current user can edit
global $current_user;
get_currentuserinfo();

if  ($current_user->ID == $post_object->post_author || $current_user->ID == '1')
	{
	// authorized
	_e( '<h3>Enhance your listing</h3>' , 'wpfrl' );
	?>
	
		<form method='post'>	
		<div class='notify-small'><?php _e( 'your information' , 'wpfrl' ); ?></div>
		<input type='text' required name='first-name' value='<?php echo $_POST['first-name']; ?>' placeholder="<?php _e( 'first name' , 'wpfrl' ); ?>" id='first-name'>
		<input type='text' required name='last-name' value='<?php echo $_POST['last-name']; ?>' placeholder="<?php _e( 'last name' , 'wpfrl' ); ?>" id='last-name'>
		<input type='email' required name='email' value='<?php echo $_POST['email']; ?>' placeholder="<?php _e( 'email address' , 'wpfrl' ); ?>" id='email'>
		<input type='text' required name='zip' value='<?php echo $_POST['zip']; ?>' placeholder="<?php _e( 'zipcode' , 'wpfrl' ); ?>" id='zip'>
		<div class='clear'></div> 			
		<div class='clear'></div>
		<?php wp_nonce_field('submit','post-jobform2'); ?>
		</form>

	</div>
	<?php
	}
else
	{
	echo "<div class='error'><img src='".get_bloginfo('stylesheet_directory') ."/library/images/error.png'>".__('Were sorry, but it appears you are not authorized to edit this listing.<br>Maybe you are not logged in with the correct credentials ?', 'wpfrl' ). "</div>";
	}
	?>
	
</div>