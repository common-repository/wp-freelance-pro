<div class='postjob'>
<?php if ($error) echo "<div class='error'><img src='".get_bloginfo('stylesheet_directory') ."/library/images/error.png'>$error</div>"; ?>

	<form method='post'>
	<div class='notify-small'><?php _e( 'submit a job' , 'wpfrl' ); ?></div>
	<?PHP 
	$settings =   array(
    'wpautop' => true, // use wpautop?
    'media_buttons' => false, // show insert/upload button(s)
    'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
    'tabindex' => '',
    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
    'editor_class' => '', // add extra class(es) to the editor textarea
    'teeny' => false, // output the minimal editor config used in Press This
    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
	);
	$descr = stripslashes($_POST['wpf-job']); if (empty($descr)) $descr =  __('post your job description', 'wpfrl');
	wp_editor($descr, 'wpf-job', array('media_buttons' => false,'textarea_rows' => 12) ); ?>
		
	<div class='notify-small'><?php _e( 'provide a job title' , 'wpfrl' ); ?></div>
	<input type='text' name='title' value='<?php echo stripslashes(htmlentities($_POST['title'],ENT_QUOTES )); ?>' placeholder="<?php _e( 'Write a catchy title ... it is the first thing people see!' , 'wpfrl' ); ?>" id='title' required>
	<div class='clear'></div>
	
	<select name='budget' id='pbudget'>
	<option value=''><?php _e( 'select a budget' , 'wpfrl' ); ?></option>
	<option value='20' <?php if ($_POST['budget'] == '20') echo 'selected'; ?> ><?php _e( '$ 0 - $ 20' , 'wpfrl' ); ?></option>
	<option value='50' <?php if ($_POST['budget'] == '50') echo 'selected'; ?> ><?php _e( '$ 21 - $ 50' , 'wpfrl' ); ?></option>
	<option value='100' <?php if ($_POST['budget'] == '100') echo 'selected'; ?> ><?php _e( '$ 51 - $ 100' , 'wpfrl' ); ?></option>
	<option value='175' <?php if ($_POST['budget'] == '175') echo 'selected'; ?> ><?php _e( '$ 101 - $ 175' , 'wpfrl' ); ?></option>
	<option value='250' <?php if ($_POST['budget'] == '250') echo 'selected'; ?> ><?php _e( '$ 176 - $ 250' , 'wpfrl' ); ?></option>
	<option value='500' <?php if ($_POST['budget'] == '500') echo 'selected'; ?> ><?php _e( '$ 250 - $ 500' , 'wpfrl' ); ?></option>
	<option value='500+' <?php if ($_POST['budget'] == '500+') echo 'selected'; ?> ><?php _e( 'over $ 500' , 'wpfrl' ); ?></option>
	<option value='not_disclosed' <?php if ($_POST['budget'] == 'not_disclosed') echo 'selected'; ?> ><?php _e( 'not disclosed' , 'wpfrl' ); ?></option>
	</select>	
	
	<select name='deadline' id='pdeadline'>
	<option value=''><?php _e( 'select a deadline' , 'wpfrl' ); ?></option>
	<option value='172800' <?php if ($_POST['deadline'] == '172800') echo 'selected'; ?> ><?php _e( '48 hours from now' , 'wpfrl' ); ?></option>
	<option value='604800' <?php if ($_POST['deadline'] == '604800') echo 'selected'; ?> ><?php _e( 'one week from now' , 'wpfrl' ); ?></option>
	<option value='1209600' <?php if ($_POST['deadline'] == '1209600') echo 'selected'; ?> ><?php _e( '2 weeks from now' , 'wpfrl' ); ?></option>
	<option value='2592000' <?php if ($_POST['deadline'] == '2592000') echo 'selected'; ?> ><?php _e( 'a month from now' , 'wpfrl' ); ?></option>
	<option value='7776000' <?php if ($_POST['deadline'] == '7776000') echo 'selected'; ?> ><?php _e( '3 months' , 'wpfrl'  ); ?></option>
	<option value='15552000' <?php if ($_POST['deadline'] == '15552000') echo 'selected'; ?> ><?php _e( '6 months' , 'wpfrl' ); ?></option>
	<option value='9999999999' <?php if ($_POST['deadline'] == '9999999999') echo 'selected'; ?> ><?php _e( 'negotiable' , 'wpfrl' ); ?></option>
	</select>	
	
	<?php wp_dropdown_categories('hide_empty=0&name=category&id=category&class=input&show_count=1&hierarchical=1&taxonomy=freelance_category'); ?>
	
	<input type='text' name='tags' value='<?php echo $_POST['tags']; ?>' placeholder="<?php _e( 'enter some tags: phone,ring,model' , 'wpfrl' ); ?>" id='tags'>
	
		<?php
		if ( is_user_logged_in() ) 
			{
			global $current_user;
			get_currentuserinfo();
			?>
			<div class='notify-small'><?php _e( 'your information (locked)' , 'wpfrl' ); ?></div>
			<input type='text' name='username' value='<?php echo $current_user->user_login; ?>' disabled>
			<input type='text' name='user-email' value='<?php echo "*****" . substr($current_user->user_email,5); ?>' disabled>
			<?php
			}
		else
			{
			?>
			<div class='notify-small'><?php _e( 'your information' , 'wpfrl' ); ?></div>
			<input type='text' required name='first-name' value='<?php echo $_POST['first-name']; ?>' placeholder="<?php _e( 'first name' , 'wpfrl' ); ?>" id='first-name'>
			<input type='text' required name='last-name' value='<?php echo $_POST['last-name']; ?>' placeholder="<?php _e( 'last name' , 'wpfrl' ); ?>" id='last-name'>
			<input type='email' required name='email' value='<?php echo $_POST['email']; ?>' placeholder="<?php _e( 'email address' , 'wpfrl' ); ?>" id='email'>
			<input type='text' required name='zip' value='<?php echo $_POST['zip']; ?>' placeholder="<?php _e( 'zipcode' , 'wpfrl' ); ?>" id='zip'>
			<div class='clear'></div> 
			<?php
			}	
		wp_nonce_field('submit','post-jobform'); 
		if ($notify) 
			{
			echo "<div class='notify'><img src='".get_bloginfo('stylesheet_directory') ."/library/images/ok.png'>$notify</div>";
			}
		else 
			{
			?>
			<input type='submit' value='<?php _e( 'submit' , 'wpfrl' ); ?>' id='submit'>
			<?php
			}
			if ($error2) echo "$error2 <script>document.getElementById('category').style.backgroundColor='#FFA500';</script>";
			?>
	<div class='clear'></div>
	</form>

</div>