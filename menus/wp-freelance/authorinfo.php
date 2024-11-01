<div class='author-private'>
	<div class='freelance-header'>
		<h2><?php
		$name =  get_user_meta($auth->ID , 'fname' ,TRUE). " " . get_user_meta($auth->ID , 'lname' ,TRUE); 
		if (strlen($name) < 3) $name = get_the_author_meta( 'user_login' , $auth->ID );
		echo $name;
		?>'s <?php _e('Public Records', 'wpfrl'); ?></h2>
		<?PHP
		$profilescore = get_user_meta( $auth->id, 'profilescore', TRUE );if (empty($profilescore)) $profilescore = 15;
		?>	
		<div style='width:70%;background-color:#E3F2F4;height:20px;margin:3px auto;border-radius:10px'>
		<div style='width:<?php echo $profilescore;?>%;background-color:green;height:20px;color:white;border-radius:10px'>
		</div>
		</div>
		<?php echo "profilescore: $profilescore/100";?>
		</br>
	</div>
	
	<div class='left-50'>
		<label><?php _e('First Name', 'wpfrl'); ?></label><input value='<?php echo get_user_meta($auth->ID , 'fname' ,TRUE); ?>' disabled>

		<label><?php _e('Last Name', 'wpfrl'); ?></label><input value='<?php echo get_user_meta($auth->ID ,'lname' ,TRUE); ?>' disabled>

		<label><?php _e('gender (age)', 'wpfrl'); ?></label><input value='<?php echo get_user_meta($auth->ID ,'gender' ,TRUE) . "(" . get_user_meta($auth->ID ,'age' ,TRUE) . ")"; ?>' disabled>
		
		<label><?php _e('zipcode', 'wpfrl'); ?></label><input value='<?php echo get_user_meta($auth->ID ,'zip' ,TRUE); ?>' disabled>
		
		<label><?php _e('country', 'wpfrl'); ?></label><input value='<?php echo get_user_meta($auth->ID ,'country' ,TRUE); ?>' disabled>		
		
		<label for="url"><?php _e('Website', 'wpfrl'); ?></label>
		<a href='<?php echo  get_user_meta($auth->id ,'website' ,TRUE); ?>' title='visit <?php echo  get_user_meta($auth->id ,'website' ,TRUE); ?>' ><input class="text-input" name="wurl" type="text" id="wurl" value="<?php echo  get_user_meta($auth->id ,'website' ,TRUE); ?>" disabled /></a>

		<label for="bio"><?php _e('About me', 'wpfrl') ?></label>
		<textarea name="bio" id="desc" rows="8" cols="50" disabled><?php echo stripslashes(get_user_meta($auth->ID ,'bio',TRUE ) ); ?></textarea>
		
		<label for="refr"><?php _e('my references', 'wpfrl') ?></label>
		<textarea name="refr" id="refr" rows="8" cols="50" disabled><?php echo stripslashes(get_user_meta($auth->ID ,'refr',TRUE ) ); ?></textarea>
		
		
	</div>
	
	<div class='left-50'>
	<?php wpfr_avatar( $auth->ID ,180); ?>
	
	<?PHP include('mapme.php'); ?>
		
	</div>	
	<div style='clear:both'></div>	
	
	
		
	<div class='freelance-header'>
		<div class='data'>
		<?php
		$score = get_user_meta($auth->ID ,'score',TRUE );
		if ($score < 1) $score = "?";
		_e('my score:','wpfrl');
		echo "<br><span>$score</span>";
		?>
		</div>
		<div class='data'>
		<?php
		$rate = get_user_meta($auth->ID ,'rating',TRUE ); if ($rate < 1) $rate = "?";
		_e('my rating:','wpfrl');
		echo "<br><span>$rate</span>";
		?>
		</div>
		<div class='data'>
		
			<?php
			$rate = get_user_meta( get_the_author_meta('ID'), 'rating', TRUE ); 
			if (empty($rate) || !is_numeric($rate)) $rate = "-?-";
			_e('my stars: <br>', 'wpfrl' );			
			$stars = (int)$rate / 20; if ($stars > 5) $stars = 5; if ($stars == 0 ) $stars = 1;
			for ($q=0;$q < $stars; $q++)
				{
				echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/star.png' . "' style='margin:0px' >";
				}
			?>
		</div>
		<div class='data'>
		<?php _e('verified ? <br>', 'wpfrl' );	?>
		<br><strong>NO</strong>
		</div>
		<div style='clear:both'></div>	
	</div>

</div>
<div style='clear:both'></div>	

			<div class='authorbox'>
			<h2><?php printf(__('listings by %1$s', 'wpfrl') , $name , ('wpfrl')) ; ?></h2>
			<br>
			<?php
			 $args = array(
			'author' => $auth->ID,
			'number'  => '5',
			'post_type' => 'freelance_post',
			);
			$the_query = new WP_Query( $args );
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
				<li>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'go to view %s', 'wpfrl' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"> 
				<?php echo substr(get_the_title(),0,50)."..."; ?>
				</a>
				</li>
				<?php
			endwhile;
			// Reset Post Data
			wp_reset_postdata();
			?>			
			</div>
			
			<div class='authorbox'>
			<h2><?php printf(__('estimates by %1$s', 'wpfrl') , $name , ('wpfrl')) ; ?></h2>
				<?php
				$args = array(
					'user_id' => $auth->ID ,
					'number'  => '5',
					'post_type' => 'freelance_post',
				);
				$comments = get_comments($args);
				foreach($comments as $comment) :
				echo "<li><a href='" .get_permalink($comment->comment_post_ID). "'>" . substr($comment->comment_content,0,50) . "</a></li>";
				endforeach;
				?>
			</div>
			
			<div class='authorbox'>
			<h2><?php _e('Most active publishers', 'wpfrl'); ?></h2>
			<ul>
			<?php wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC&number=10'); ?>
			</ul>
			</div>
			
		<div style='clear:both'></div>


<?php
// add 1 point to author score
$score = get_user_meta($auth->ID ,'score',TRUE );
$score++; update_user_meta($auth->ID ,'score', $score );
