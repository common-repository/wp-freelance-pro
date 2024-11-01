﻿	<?php
	if (wp_verify_nonce($_POST['usersets'],'update') )	//security
		{
		if($_POST) 
			{
			global $wpdb;
			echo "<h2>profile updated.</h2>";
			$first = $wpdb->escape($_POST['first-name']);
			$last = $wpdb->escape($_POST['last-name']);
			$gender = $wpdb->escape($_POST['gender']);
			$age = $wpdb->escape($_POST['age']);
			$email = $wpdb->escape($_POST['email']);
			$website = $wpdb->escape($_POST['wurl']);
			$bio = $wpdb->escape($_POST['bio']);
			$refr = $wpdb->escape($_POST['refr']);
			$password = $wpdb->escape($_POST['pas1']);
			$confirm_password = $wpdb->escape($_POST['pas2']);
			$street = $wpdb->escape($_POST['street']);
			$country = $wpdb->escape($_POST['country']);
			$zip = $wpdb->escape($_POST['zip']);
			$phone = $wpdb->escape($_POST['phone']);
			$contactinfo = $wpdb->escape($_POST['contactinfo']);
			
			update_user_meta( $auth->id, 'fname', $first );
			update_user_meta( $auth->id, 'lname', $last );
			update_user_meta( $auth->id, 'bio', $bio );
			update_user_meta( $auth->id, 'gender', $gender );
			update_user_meta( $auth->id, 'age', $age );			
			update_user_meta( $auth->id, 'refr', $refr );						
			update_user_meta( $auth->id, 'street', $street );
			update_user_meta( $auth->id, 'country', $country );
			update_user_meta( $auth->id, 'zip', $zip );
			update_user_meta( $auth->id, 'phone', $phone );
			update_user_meta( $auth->id, 'contactinfo', $contactinfo );
			update_user_meta( $auth->id, 'website', $website );
			
			$psc = 0;
			if (strlen(get_user_meta( $auth->id, 'fname',TRUE )) > 2) $psc=$psc+10;
			if (strlen(get_user_meta( $auth->id, 'lname',TRUE )) > 2) $psc=$psc+10;
			if (strlen(get_user_meta( $auth->id, 'gender',TRUE )) > 20) $psc=$psc+5;
			if (strlen(get_user_meta( $auth->id, 'age',TRUE )) > 20) $psc=$psc+5;			
			if (strlen(get_user_meta( $auth->id, 'bio',TRUE )) > 20) $psc=$psc+10;
			if (strlen(get_user_meta( $auth->id, 'refr',TRUE )) > 20) $psc=$psc+10;
			if (strlen(get_user_meta( $auth->id, 'street',TRUE )) > 2) $psc=$psc+1;
			if (strlen(get_user_meta( $auth->id, 'zip',TRUE )) > 2) $psc=$psc+4;
			if (strlen(get_user_meta( $auth->id, 'phone',TRUE )) > 6) $psc=$psc+5;
			if (strlen(get_user_meta( $auth->id, 'contactinfo',TRUE )) > 8) $psc=$psc+10;
			if (strlen(get_user_meta( $auth->id, 'website',TRUE )) > 6) $psc=$psc+5;
			if (strlen(get_user_meta( $auth->id, 'lavatar',TRUE )) > 6) $psc=$psc+25;
			update_user_meta( $auth->id, 'profilescore', $psc );
			
			
			if(isset($email)) 
				{
				if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email))
					{ 
					if ( email_exists( $email ) ) 
						{
						$message .= "<div id='error'>" . __('This e-mail address already exists in the system. Please use a different e-mail address, or log in to your account','wpfrl'). ".</div>"; 
						}
					else
						{
						wp_update_user( array ('ID' => $auth->ID, 'user_email' => $email) ) ;
						}
					}
				else 
					{ 
					$message .= "<div id='error'>" . __('Please enter a valid email id.', 'wpfrl') . "</div>"; 
					}
				}
			if($password) 
				{
				if (strlen($password) < 5 || strlen($password) > 15) 
					{
					$message = "<div id='error'>" . __('Password must be 5 to 15 characters in length.', 'wpfrl'). "</div>";
					}
				//elseif( $password == $confirm_password ) {
				elseif(isset($password) && $password != $confirm_password) 
					{
						$message = "<div class='error'>" . __('Password Mismatch','wpfrl'). "</div>";
					} 
				elseif ( isset($password) && !empty($password) ) 
					{
						$update = wp_set_password( $password, $auth->id );
						$message = "<div id='success'>" . __('Your profile updated successfully.', 'wpfrl'). "</div>";
					}
				}
			}
		}
	?>

<div class='author-private'>
	<div class='freelance-header'>
	<?php 
	_e('<h2>Profile and Settings</h2>Fill out all fields to raise your score and ranking.', 'wpfrl');	
	$profilescore = get_user_meta( $auth->id, 'profilescore', TRUE );if (empty($profilescore)) $profilescore = 15;
	?>	
	<div style='width:70%;background-color:red;height:20px;margin:3px auto;'>
	<div style='width:<?php echo $profilescore;?>%;background-color:green;height:20px;color:white'>
	</div>
	</div>
	<?php _e('profilescore:', 'wpfrl'); echo "$profilescore/100";?>
	</div>
	
	<div class='left-50'>
	<?php _e('<h3>User settings</h3>', 'wpfrl'); ?>
	<div><?php _e('items marked * are never public', 'wpfrl'); ?></div>
	<form method="post">	
		<label for="first-name"><?php _e('First Name', 'wpfrl'); ?></label>
		<input class="text-input" name="first-name" type="text" id="first-name" value="<?php echo stripslashes(get_user_meta($auth->id , 'fname' ,TRUE)); ?>" />

		<label for="last-name"><?php _e('Last Name', 'wpfrl'); ?></label>
		<input class="text-input" name="last-name" type="text" id="last-name" value="<?php echo stripslashes(get_user_meta($auth->id ,'lname' ,TRUE)); ?>" />

		<label for="last-name"><?php _e('gender (age)', 'wpfrl'); ?></label>
		<select name='gender' style='width:20%;float:left;margin-left:4%;'>
			<option value=''> <?php echo get_user_meta($auth->id ,'gender' ,TRUE); ?> </option>
			<option value='male'> male </option>
			<option value='female'> female </option>
		</select>
		<input class="text-input" style='width:20%;float:right;margin-right:4%;' name="age" type="number" id="age" min='16' max='99' value="<?php echo get_user_meta($auth->id ,'age' ,TRUE); ?>" />		
		<div style='clear:both'></div>
		
		<label for="last-name"><?php _e('zipcode', 'wpfrl'); ?></label>
		<input class="text-input" name="zip" type="text" id="zip" value="<?php echo stripslashes(get_user_meta($auth->id ,'zip' ,TRUE)); ?>" />
		<div style='clear:both'></div>
		
		<label for="country"><?php _e('country', 'wpfrl'); ?></label>
		<select id="country" name="country">
			<option value=""><?php echo stripslashes(get_user_meta($auth->id ,'country' ,TRUE) ); ?></option>
			<option value="Afghanistan">Afghanistan</option>
			<option value="Albania">Albania</option>
			<option value="Algeria">Algeria</option>
			<option value="American_Samoa">American Samoa</option>
			<option value="Andorra">Andorra</option>
			<option value="Angola">Angola</option>
			<option value="Anguilla">Anguilla</option>
			<option value="Antarctica">Antarctica</option>
			<option value="Antigua_And_Barbuda">Antigua and Barbuda</option>
			<option value="Argentina">Argentina</option>
			<option value="Armenia">Armenia</option>
			<option value="Aruba">Aruba</option>
			<option value="Australia">Australia</option>
			<option value="Austria">Austria</option>
			<option value="Azerbaijan">Azerbaijan</option>
			<option value="Bahamas">Bahamas</option>
			<option value="Bahrain">Bahrain</option>
			<option value="Bangladesh">Bangladesh</option>
			<option value="Barbados">Barbados</option>
			<option value="Belarus">Belarus</option>
			<option value="Belgium">Belgium</option>
			<option value="Belize">Belize</option>
			<option value="Benin">Benin</option>
			<option value="Bermuda">Bermuda</option>
			<option value="Bhutan">Bhutan</option>
			<option value="Bolivia">Bolivia</option>
			<option value="Bosnia_And_Herzegovina">Bosnia and Herzegovina</option>
			<option value="Botswana">Botswana</option>
			<option value="Bouvet_Island">Bouvet Island</option>
			<option value="Brazil">Brazil</option>
			<option value="British_Indian_Ocean_Territory">British Indian Ocean Territory</option>
			<option value="Brunei_Darussalam">Brunei Darussalam</option>
			<option value="Bulgaria">Bulgaria</option>
			<option value="Burkina_Faso">Burkina Faso</option>
			<option value="Burundi">Burundi</option>
			<option value="Cambodia">Cambodia</option>
			<option value="Cameroon">Cameroon</option>
			<option value="Canada">Canada</option>
			<option value="Cape_Verde">Cape Verde</option>
			<option value="Cayman_Islands">Cayman Islands</option>
			<option value="Central_African_Republic">Central African Republic</option>
			<option value="Chad">Chad</option>
			<option value="Chile">Chile</option>
			<option value="China">China</option>
			<option value="Christmas_Island">Christmas Island</option>
			<option value="Cocos_(Keeling)_Islands">Cocos (Keeling) Islands</option>
			<option value="Colombia">Colombia</option>
			<option value="Comoros">Comoros</option>
			<option value="Congo">Congo</option>
			<option value="Congo,_The_Democratic_Republic_Of_The">Congo, The Democratic Republic of The</option>
			<option value="Cook_Islands">Cook Islands</option>
			<option value="Costa_Rica">Costa Rica</option>
			<option value="Cote_D'ivoire">Cote D'ivoire</option>
			<option value="Croatia">Croatia</option>
			<option value="Cuba">Cuba</option>
			<option value="Cyprus">Cyprus</option>
			<option value="Czech_Republic">Czech Republic</option>
			<option value="Denmark">Denmark</option>
			<option value="Djibouti">Djibouti</option>
			<option value="Dominica">Dominica</option>
			<option value="Dominican_Republic">Dominican Republic</option>
			<option value="Ecuador">Ecuador</option>
			<option value="Egypt">Egypt</option>
			<option value="El_Salvador">El Salvador</option>
			<option value="Equatorial_Guinea">Equatorial Guinea</option>
			<option value="Eritrea">Eritrea</option>
			<option value="Estonia">Estonia</option>
			<option value="Ethiopia">Ethiopia</option>
			<option value="Falkland_Islands_(Malvinas)">Falkland Islands (Malvinas)</option>
			<option value="Faroe_Islands">Faroe Islands</option>
			<option value="Fiji">Fiji</option>
			<option value="Finland">Finland</option>
			<option value="France">France</option>
			<option value="French_Guiana">French Guiana</option>
			<option value="French_Polynesia">French Polynesia</option>
			<option value="French_Southern_Territories">French Southern Territories</option>
			<option value="Gabon">Gabon</option>
			<option value="Gambia">Gambia</option>
			<option value="Georgia">Georgia</option>
			<option value="Germany">Germany</option>
			<option value="Ghana">Ghana</option>
			<option value="Gibraltar">Gibraltar</option>
			<option value="Greece">Greece</option>
			<option value="Greenland">Greenland</option>
			<option value="Grenada">Grenada</option>
			<option value="Guadeloupe">Guadeloupe</option>
			<option value="Guam">Guam</option>
			<option value="Guatemala">Guatemala</option>
			<option value="Guernsey">Guernsey</option>
			<option value="Guinea">Guinea</option>
			<option value="Guinea-bissau">Guinea-bissau</option>
			<option value="Guyana">Guyana</option>
			<option value="Haiti">Haiti</option>
			<option value="Heard_Island_And_Mcdonald_Islands">Heard Island and Mcdonald Islands</option>
			<option value="Holy_See_(Vatican_City_State)">Holy See (Vatican City State)</option>
			<option value="Honduras">Honduras</option>
			<option value="Hong_Kong">Hong Kong</option>
			<option value="Hungary">Hungary</option>
			<option value="Iceland">Iceland</option>
			<option value="India">India</option>
			<option value="Indonesia">Indonesia</option>
			<option value="Iran,_Islamic_Republic_Of">Iran, Islamic Republic of</option>
			<option value="Iraq">Iraq</option>
			<option value="Ireland">Ireland</option>
			<option value="Isle_Of_Man">Isle of Man</option>
			<option value="Israel">Israel</option>
			<option value="Italy">Italy</option>
			<option value="Jamaica">Jamaica</option>
			<option value="Japan">Japan</option>
			<option value="Jersey">Jersey</option>
			<option value="Jordan">Jordan</option>
			<option value="Kazakhstan">Kazakhstan</option>
			<option value="Kenya">Kenya</option>
			<option value="Kiribati">Kiribati</option>
			<option value="Korea,_Democratic_People's_Republic_Of">Korea, Democratic People's Republic of</option>
			<option value="Korea,_Republic_Of">Korea, Republic of</option>
			<option value="Kuwait">Kuwait</option>
			<option value="Kyrgyzstan">Kyrgyzstan</option>
			<option value="Lao_People's_Democratic_Republic">Lao People's Democratic Republic</option>
			<option value="Latvia">Latvia</option>
			<option value="Lebanon">Lebanon</option>
			<option value="Lesotho">Lesotho</option>
			<option value="Liberia">Liberia</option>
			<option value="Libyan_Arab_Jamahiriya">Libyan Arab Jamahiriya</option>
			<option value="Liechtenstein">Liechtenstein</option>
			<option value="Lithuania">Lithuania</option>
			<option value="Luxembourg">Luxembourg</option>
			<option value="Macao">Macao</option>
			<option value="Macedonia,_The_Former_Yugoslav_Republic_Of">Macedonia, The Former Yugoslav Republic of</option>
			<option value="Madagascar">Madagascar</option>
			<option value="Malawi">Malawi</option>
			<option value="Malaysia">Malaysia</option>
			<option value="Maldives">Maldives</option>
			<option value="Mali">Mali</option>
			<option value="Malta">Malta</option>
			<option value="Marshall_Islands">Marshall Islands</option>
			<option value="Martinique">Martinique</option>
			<option value="Mauritania">Mauritania</option>
			<option value="Mauritius">Mauritius</option>
			<option value="Mayotte">Mayotte</option>
			<option value="Mexico">Mexico</option>
			<option value="Micronesia,_Federated_States_Of">Micronesia, Federated States of</option>
			<option value="Moldova,_Republic_Of">Moldova, Republic of</option>
			<option value="Monaco">Monaco</option>
			<option value="Mongolia">Mongolia</option>
			<option value="Montenegro">Montenegro</option>
			<option value="Montserrat">Montserrat</option>
			<option value="Morocco">Morocco</option>
			<option value="Mozambique">Mozambique</option>
			<option value="Myanmar">Myanmar</option>
			<option value="Namibia">Namibia</option>
			<option value="Nauru">Nauru</option>
			<option value="Nepal">Nepal</option>
			<option value="Netherlands">Netherlands</option>
			<option value="Netherlands_Antilles">Netherlands Antilles</option>
			<option value="New_Caledonia">New Caledonia</option>
			<option value="New_Zealand">New Zealand</option>
			<option value="Nicaragua">Nicaragua</option>
			<option value="Niger">Niger</option>
			<option value="Nigeria">Nigeria</option>
			<option value="Niue">Niue</option>
			<option value="Norfolk_Island">Norfolk Island</option>
			<option value="Northern_Mariana_Islands">Northern Mariana Islands</option>
			<option value="Norway">Norway</option>
			<option value="Oman">Oman</option>
			<option value="Pakistan">Pakistan</option>
			<option value="Palau">Palau</option>
			<option value="Palestinian_Territory,_Occupied">Palestinian Territory, Occupied</option>
			<option value="Panama">Panama</option>
			<option value="Papua_New_Guinea">Papua New Guinea</option>
			<option value="Paraguay">Paraguay</option>
			<option value="Peru">Peru</option>
			<option value="Philippines">Philippines</option>
			<option value="Pitcairn">Pitcairn</option>
			<option value="Poland">Poland</option>
			<option value="Portugal">Portugal</option>
			<option value="Puerto_Rico">Puerto Rico</option>
			<option value="Qatar">Qatar</option>
			<option value="Reunion">Reunion</option>
			<option value="Romania">Romania</option>
			<option value="Russian_Federation">Russian Federation</option>
			<option value="Rwanda">Rwanda</option>
			<option value="Saint_Helena">Saint Helena</option>
			<option value="Saint_Kitts_And_Nevis">Saint Kitts and Nevis</option>
			<option value="Saint_Lucia">Saint Lucia</option>
			<option value="Saint_Pierre_And_Miquelon">Saint Pierre and Miquelon</option>
			<option value="Saint_Vincent_And_The_Grenadines">Saint Vincent and The Grenadines</option>
			<option value="Samoa">Samoa</option>
			<option value="San_Marino">San Marino</option>
			<option value="Sao_Tome_And_Principe">Sao Tome and Principe</option>
			<option value="Saudi_Arabia">Saudi Arabia</option>
			<option value="Senegal">Senegal</option>
			<option value="Serbia">Serbia</option>
			<option value="Seychelles">Seychelles</option>
			<option value="Sierra_Leone">Sierra Leone</option>
			<option value="Singapore">Singapore</option>
			<option value="Slovakia">Slovakia</option>
			<option value="Slovenia">Slovenia</option>
			<option value="Solomon_Islands">Solomon Islands</option>
			<option value="Somalia">Somalia</option>
			<option value="South_Africa">South Africa</option>
			<option value="South_Georgia_And_The_South_Sandwich_Islands">South Georgia and The South Sandwich Islands</option>
			<option value="Spain">Spain</option>
			<option value="Sri_Lanka">Sri Lanka</option>
			<option value="Sudan">Sudan</option>
			<option value="Suriname">Suriname</option>
			<option value="Svalbard_And_Jan_Mayen">Svalbard and Jan Mayen</option>
			<option value="Swaziland">Swaziland</option>
			<option value="Sweden">Sweden</option>
			<option value="Switzerland">Switzerland</option>
			<option value="Syrian_Arab_Republic">Syrian Arab Republic</option>
			<option value="Taiwan,_Province_Of_China">Taiwan, Province of China</option>
			<option value="Tajikistan">Tajikistan</option>
			<option value="Tanzania,_United_Republic_Of">Tanzania, United Republic of</option>
			<option value="Thailand">Thailand</option>
			<option value="Timor-leste">Timor-leste</option>
			<option value="Togo">Togo</option>
			<option value="Tokelau">Tokelau</option>
			<option value="Tonga">Tonga</option>
			<option value="Trinidad_And_Tobago">Trinidad and Tobago</option>
			<option value="Tunisia">Tunisia</option>
			<option value="Turkey">Turkey</option>
			<option value="Turkmenistan">Turkmenistan</option>
			<option value="Turks_And_Caicos_Islands">Turks and Caicos Islands</option>
			<option value="Tuvalu">Tuvalu</option>
			<option value="Uganda">Uganda</option>
			<option value="Ukraine">Ukraine</option>
			<option value="United_Arab_Emirates">United Arab Emirates</option>
			<option value="United_Kingdom">United Kingdom</option>
			<option value="United_States">United States</option>
			<option value="United_States_Minor_Outlying_Islands">United States Minor Outlying Islands</option>
			<option value="Uruguay">Uruguay</option>
			<option value="Uzbekistan">Uzbekistan</option>
			<option value="Vanuatu">Vanuatu</option>
			<option value="Venezuela">Venezuela</option>
			<option value="Viet_Nam">Viet Nam</option>
			<option value="Virgin_Islands,_British">Virgin Islands, British</option>
			<option value="Virgin_Islands,_U.S.">Virgin Islands, U.S.</option>
			<option value="Wallis_And_Futuna">Wallis and Futuna</option>
			<option value="Western_Sahara">Western Sahara</option>
			<option value="Yemen">Yemen</option>
			<option value="Zambia">Zambia</option>
			<option value="Zimbabwe">Zimbabwe</option>
		</select>
		<div style='clear:both'></div>		
		<label for="email"><?php _e('E-mail *', 'wpfrl'); ?></label>
		<input class="text-input" name="email" type="text" id="email" value="<?php echo stripslashes($auth->user_email); ?>" />

		<label for="url"><?php _e('Website', 'wpfrl'); ?></label>
		<input class="text-input" name="wurl" type="text" id="wurl" value="<?php echo  stripslashes(get_user_meta($auth->id ,'website' ,TRUE)); ?>" />

		<label for="pass1"><?php _e('Password *', 'wpfrl'); ?> </label>
		<input class="text-input" name="pas1" type="password" id="pas1" />

		<label for="pass2"><?php _e('Repeat Password *', 'wpfrl'); ?></label>
		<input class="text-input" name="pas2" type="password" id="pas2" />

		<label for="description"><?php _e('About me', 'wpfrl') ?></label>
		<textarea name="bio" id="desc" rows="5" cols="50"><?php echo stripslashes(get_user_meta($auth->id ,'bio',TRUE )); ?></textarea>

		<label for="refr"><?php _e('references/experience', 'wpfrl') ?></label>
		<textarea name="refr" id="refr" rows="5" cols="50"><?php echo stripslashes(get_user_meta($auth->id ,'refr',TRUE )); ?></textarea>
		
		<div><?php _e('<strong>info below is shown to job lister when your estimate is selected, or to freelancer when you are the job lister.</strong>', 'wpfrl'); ?></div>
		
		<label for="phone"><?php _e('my phone number', 'wpfrl'); ?></label>		
		<input class="text-input" name="phone" type="text" id="phone" value="<?php echo get_user_meta($auth->id ,'phone' ,TRUE); ?>" />
		
		<label for="contactinfo"><?php _e('my contactinfo', 'wpfrl'); ?></label>		
		<textarea name="contactinfo" id="desc" rows="3" cols="50"><?php echo stripslashes(get_user_meta($auth->id ,'contactinfo',TRUE )); ?></textarea>
		
		<?php wp_nonce_field('update','usersets'); ?>
		<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'wpfrl'); ?>" />
	</form>
	</div>
	
	<div class='left-50'>
	<?php
		_e('<h2>Avatar Update</h2>', 'wpfrl');
	if (wp_verify_nonce($_POST['alavatar'],'update') )	//security
		{
		if ( strstr( $_FILES['lavatar']['name'], '.php' ) ) wp_die('For security reasons, the extension ".php" cannot be in your file name.');
		if ( ! empty( $_FILES['lavatar']['name'] ) ) 
			{
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
				'bmp' => 'image/bmp',
				'tif|tiff' => 'image/tiff'
			);
		
			// front end (theme my profile etc) support
			if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

			//$simple_local_avatars->user_id_being_edited = $auth->id; // make user_id known to unique_filename_callback function
			$avatar = wp_handle_upload( $_FILES['lavatar'], array( 'mimes' => $mimes, 'test_form' => false ) );
			
			if ( empty($avatar['file']) ) 
				{
				echo "error, please try again";	
				}			
			update_user_meta( $auth->id, 'lavatar', $avatar['url'] );		// save user information (overwriting old)
			} 		
		}
	?>
	<?php wpfr_avatar( $auth->id ,140); ?>
	<form method='post' ENCTYPE="multipart/form-data">
	<input type='file' name='lavatar'>
	<?php wp_nonce_field('update','alavatar'); ?>
	<input type='submit' value='update avatar'>
	</form>
	<?php _e('<small>Tip: use a transparant png for maximum effects.</small><br>', 'wpfrl'); ?>
	
	
	<?php _e('<br><h3>system data</h3>', 'wpfrl'); ?>
	<?php echo "<br><strong>Username: $auth->user_login <br>Registration: $auth->user_registered</strong>"; ?>
	<br/>
	<?PHP include('mapme.php'); ?>
	</div>	
	
	<div style='clear:both'></div>	
	
<div style='margin:10px;background:white;padding:10px'>
	<h2><?php _e('Publish your jobs ! (if any)', 'wpfrl'); ?></h2>	
	<br/><br/>
		<?php
		if (!empty($_POST['ppost']))
			{
			$my_post['ID'] = $wpdb->escape($_POST['ppost']);
			$my_post['post_status'] = 'publish';
			// Update the post into the database
			wp_update_post( $my_post );
			
			// reward user
			$current_user = wp_get_current_user();
			$score = get_user_meta($current_user->ID ,'score',TRUE );
			$score = $score + 100;
			update_user_meta($current_user->ID ,'score',$score );
			}
		
		$the_query = new WP_Query( array( 'author' => $auth->ID, 'post_status' => 'pending','post_type' => 'freelance_post') );		
		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
			
			echo '<div style="margin:5px;padding:5px;border:2px solid red">';
			echo "<H3>";
			the_title();
			ECHO "</H3>";			
			the_excerpt();
			echo '<form method="POST"><input type="hidden" name="ppost" value="' . get_the_ID() . '"><input type="SUBMIT" VALUE="PUBLISH THIS LISTING"></form>';
			echo '</div>';
			
		endwhile;
		// Reset Post Data
		wp_reset_postdata();
		?>	

</div>

<?php _e('Below we show you what everyone else sees when they visit this page' , 'wpfrl'); ?>	
</div>
<div style='clear:both'></div>	