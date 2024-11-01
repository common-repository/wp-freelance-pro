<?php

// process job posting
if (wp_verify_nonce($_POST['post-jobform'],'submit') ) // form from standard.php
	{	
	// does table exist ?
	wpf_init();
	
	// error checking
	if (strlen($_REQUEST['wpf-job']) < 20) {$error .= __('Please enter a (longer) description', 'wpfrl'); $error2 .= "<script>document.getElementById('job').style.backgroundColor='#F5A9A9';</script>";}
	if (strlen($_REQUEST['title']) < 10) {$error .= __('<br>Please enter a (longer) title', 'wpfrl'); $error2 .= "<script>document.getElementById('title').style.backgroundColor='#F5A9A9';</script>";}		
	if (strlen($_REQUEST['deadline']) < 1) {$error .= __('<br>Please select a deadline', 'wpfrl'); $error2 .= "<script>document.getElementById('pdeadline').style.backgroundColor='#F5A9A9';</script>";}		
	if (strlen($_REQUEST['budget']) < 1) {$error .= __('<br>Please select a budget', 'wpfrl'); $error2 .= "<script>document.getElementById('pbudget').style.backgroundColor='#F5A9A9';</script>";}		
	if (wpf_title_exist($_REQUEST['title'])) {$error .= __('<br>Please change the title. This title already exists', 'wpfrl'); $error2 .= "<script>document.getElementById('title').style.backgroundColor='#F5A9A9';</script>";}
	if (!is_numeric($_REQUEST['category'])) {$error .= __('<br>undefined category error', 'wpfrl'); $error2 .= "<script>document.getElementById('category').style.backgroundColor='#F5A9A9';</script>";}
	
	
	if (! is_user_logged_in())
		{
		if (strlen($_REQUEST['first-name']) < 3) {$error .= __('<br>Please enter your first name', 'wpfrl'); $error2 .= "<script>document.getElementById('first-name').style.backgroundColor='#F5A9A9';</script>";}		
		if (strlen($_REQUEST['last-name']) < 3) {$error .= __('<br>Please enter your last name', 'wpfrl'); $error2 .= "<script>document.getElementById('last-name').style.backgroundColor='#F5A9A9';</script>";}		
		if (strlen($_REQUEST['email']) < 3) {$error .= __('<br>Please enter your e-mail address', 'wpfrl'); $error2 .= "<script>document.getElementById('email').style.backgroundColor='#F5A9A9';</script>";}		
		if (strlen($_REQUEST['zip']) < 3) {$error .= __('<br>Please enter your zipcode', 'wpfrl'); $error2 .= "<script>document.getElementById('zip').style.backgroundColor='#F5A9A9';</script>";}		
		
		// do we know this user ?
		if ( username_exists( $_REQUEST['first-name'] . $_REQUEST['last-name'] ) ) 
			{
			{$error .= sprintf(__('<br>Username %s already exists. Please change the name or log in first. ','wpfrl'), $_REQUEST['first-name'] . $_REQUEST['last-name'] , 'wpfrl'); 
			$error2 .= "<script>document.getElementById('first-name').style.backgroundColor='#F5A9A9';</script><script>document.getElementById('last-name').style.backgroundColor='#F5A9A9';</script>";}
			}
		if ( email_exists( $_REQUEST['email'] ) ) 
			{
			{$error .= sprintf(__('<br>A user with e-mail address %s already exists. Please use a different e-mail address or log in first. ','wpfrl'), $_REQUEST['email']); 
			$error2 .= "<script>document.getElementById('email').style.backgroundColor='#F5A9A9';</script>";}
			}
		}
	
	$term = get_term_by( 'id', $_REQUEST['category'], 'freelance_category' );
	//then get the term_id
	$term_id = $term->term_id;
	
	$tags = str_replace(" ", "," ,$_REQUEST['tags']);
	//$tags = "'" . str_replace(",", "','",$tags) . "'";
		
	echo "CAT $term_id  TAG $tags";
	// push data
	$identifier = uniqid();	
	if ( is_user_logged_in() && !($error) )
		{
		// DON'T I KNOW YOU ALREADY ?
		global $current_user;
		get_currentuserinfo();
		
		// Create post object
		$my_post = array(
		  'post_title'    => $_POST['title'],
		  'post_content'  => $_POST['wpf-job'],
		  'post_status'   => 'publish',
		  'tags_input'    => $_POST['tags'],
		  'post_author'   => $current_user->ID,
		  'post_type'     => 'freelance_post',
		  'tax_input'     => array('freelance_category' => array($term_id)),		 
		);
		
		// Insert the post into the database
		$np = wp_insert_post( $my_post );
		// insert tags
		wp_set_post_terms( $np, $tags, 'freelance_tag' );
		
		add_post_meta($np, 'budget', $_REQUEST['budget'] , TRUE);
		add_post_meta($np, 'deadline', time() + $_REQUEST['deadline'] , TRUE);
		add_post_meta($np, 'zip', $_REQUEST['zip'] , TRUE);
		
		
		$notify =  __('Your listing was received and is being processed. It should show up on the site shortly !', 'wpfrl');
		
		// submit to database
		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$table = $wpdb->prefix . "freelance";
		$data = array(
			'pid' => $np,
			'fname' => $current_user->user_login,
			'lname' => $_REQUEST['last-name'],
			'email' => $current_user->user_email,
			'zip' => $_REQUEST['zip'],
			'actcode' => $identifier,
			'timein' => time(),
			'visitorip' => wpf_getIp()
			);
		$wpdb->insert( $table, $data);	

		// reward user
		$score = get_user_meta($current_user->ID ,'score',TRUE );
		$score = $score + 100;
		update_user_meta($current_user->ID ,'score',$score );
		}
		
	elseif (!$error)
		{
		// WE'RE STRANGERS
		$user_name = $_REQUEST['first-name'] . $_REQUEST['last-name'];
		$user_email = $_REQUEST['email'];
		
		$user_id = username_exists( $user_name );
		
		// no username && no mail on record
		if ( !$user_id and email_exists($user_email) == false ) 
			{
			// create the new user
			$random_password = wp_generate_password( $length=6, $include_standard_special_chars=false );
			$user_id = wp_create_user( $user_name, $random_password, $user_email );
			
			// insert user profile
			update_user_meta( $user_id, 'fname', $_REQUEST['first-name'] );
			update_user_meta( $user_id, 'lname', $_REQUEST['last-name'] );
			update_user_meta( $user_id, 'zip', $_REQUEST['zip'] );
			
			// send mail to new user
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			$to = $_POST['email'];
			$subject =  __('activate your job posting', 'wpfrl');
			$message = __('We have created an account for you at : ', 'wpfrl');
			$message .= "<br /><a href='" . get_bloginfo('wpurl') ."'>";			
			$message .= get_bloginfo('wpurl'). "</a><br />";
			$message .= __('you can now log in with the following credentials : <br />', 'wpfrl');
			$message .= __('username : ', 'wpfrl') ."<strong>" .  $user_name . "</strong><br>";
			$message .= __('password : ', 'wpfrl') ."<strong>" . $random_password . "</strong><br><br>";
			$message .= __('this message was sent to you by :', 'wpfrl');
			$message .= "<br>" . get_option('blogname');
			$headers = "From: ". get_bloginfo() . " <$to> \r\n";
			$mail = wp_mail($to, $subject, $message, $headers);
			$notify =  __('Your listing was received and we have created an account for you !<br><strong>Log in now to activate your listing !<br>Please check your mailbox for your account details.<br>Here is a copy of your mail sent to : ', 'wpfrl');
			$notify .= "$to <br/><br/>$message";
			
			$notify .= '<div style="margin:10px;border:1px solid black;padding:5px;background-color:white">
			</form><form name="loginform" id="loginform" action="' . get_bloginfo('wpurl') . '/wp-login.php" method="post">						
			<input type="text" name="log" id="user_login" class="input" value="'. $user_name . '" size="6" tabindex="10">
			<input type="text" name="pwd" id="user_pass" class="input" value="' . $random_password . '" size="6" tabindex="20">
			<input name="rememberme" type="hidden" id="rememberme" value="forever" tabindex="90"><br>
			<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In now" tabindex="100">
			<input type="hidden" name="redirect_to" value="' . get_author_posts_url( $user_id ) . '">
			</form></div>';
			} 
			
		// username OR mail exists	
		elseif ( $user_id )
			{			
			$notify = __('Your listing was saved but is not yet active. ', 'wpfrl');
			$notify .= sprintf(__('You listed as an unregistered user, but an account with username %s already exists. ','wpfrl'), $user_name);
			$notify .=__('Please log in to your account now to activate/publish your listing. ', 'wpfrl');
			}
			
		// username OR mail exists	
		elseif ( email_exists($user_email) )
			{	
			$user = get_user_by('email', $user_email);
			$user_id = $user->ID;
			$notify = __('Your listing was saved but is not yet active. ', 'wpfrl');
			$notify .= sprintf(__('You listed as an unregistered user, but an account already exists with e-mail address %s . ','wpfrl'), $user_email);
			$notify .=__('Please log in to your account now to activate/publish your listing. ', 'wpfrl');
			}
		else
			{			
			exit ('could not determine user status');
			}
			
		// Create post object
		$my_post = array(
		  'post_title'    => $_POST['title'],
		  'post_content'  => $_POST['wpf-job'],
		  'post_status'   => 'pending',
		  'tags_input'    => $_POST['tags'],
		  'post_author'   => $user_id,
		  'post_type'     => 'freelance_post',
		  'tax_input'     => array('freelance_category' => array($term_id)),
		);
		
		// Insert the post into the database
		$np = wp_insert_post( $my_post );
		// insert tags
		wp_set_post_terms( $np, $tags, 'freelance_tag' );
		// add post meta's
		add_post_meta($np, 'budget', $_REQUEST['budget'] , TRUE);
		add_post_meta($np, 'deadline', time() + $_REQUEST['deadline'] , TRUE);
		add_post_meta($np, 'zip', $_REQUEST['zip'] , TRUE);
		
		// submit to database
		global $wpdb;
		$table = $wpdb->prefix . "freelance";
		$data = array(
			'pid' => $np,
			'fname' => $_REQUEST['first-name'],
			'lname' => $_REQUEST['last-name'],
			'email' => $_REQUEST['email'],
			'zip' => $_REQUEST['zip'],
			'actcode' => $identifier,
			'timein' => time(),
			'visitorip' => wpf_getIp()
			);
		$wpdb->insert( $table, $data);
		}
	}

include ('frontforms/standard.php');


