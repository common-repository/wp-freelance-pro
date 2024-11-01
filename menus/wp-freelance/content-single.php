
		<div class='freelance-single'>
			<div class="freelance-header">
				<h2><?php the_title(); ?></h2>		
			</div>
			
			<div class="freelance-header-meta">				
			<?php
			echo "<img src='".get_bloginfo('stylesheet_directory') ."/library/images/money.png'>";
			$budg = get_post_meta( get_the_ID(), 'budget', TRUE);
			if ($budg == 'not_disclosed') _e('no budget', 'wpfrl' );
			else echo  __('Budget: $ ', 'wpfrl' ) . $budg ;
			
			echo "<img src='".get_bloginfo('stylesheet_directory') ."/library/images/time.png'>";
			$deadl = get_post_meta( get_the_ID(), 'deadline', TRUE);
			if ($deadl > 9999999999) echo __('No deadline', 'wpfrl' );
			else echo  __('deadline in ', 'wpfrl' ) . human_time_diff(current_time('timestamp'),$deadl);
			
			echo "<img src='".get_bloginfo('stylesheet_directory') ."/library/images/bar.png'>";
			
			$rate = get_user_meta( get_the_author_meta('ID'), 'rating', TRUE ); 
			if (empty($rate) || !is_numeric($rate)) $rate = "-?-";
			_e('author rating: ', 'wpfrl' );			
			$stars = (int)$rate / 20; if ($stars > 5) $stars = 5;
			for ($q=0;$q < $stars; $q++)
				{
				echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/star.png' . "' style='margin:0px' >";
				}
			echo "<strong>($rate)</strong>";		
			?>
			</div>
						
			<div class="entry-content post_content">
			
				<div class='avatarpop'>
				<?php wpfr_avatar( get_the_author_meta('ID') ,60); ?>
				</div>
				
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpfrl' ), 'after' => '</div>' ) ); ?>
			</div>
				
		<div class="dash"></div>
		
		<?php majormedia_posted_on(); ?> 
		
			<div class="freelance-header">
				<div class='data'>
				<?php
				_e('job views:','wpfrl');
				echo "<br><span>".get_post_meta( get_the_ID(), 'viewcount', TRUE) ."</span>";
				?>
				</div>
				<div class='data'>
				<?php
				_e('estimates:','wpfrl');
				echo "<br><span>";
				comments_number( __('none','wpfrl'),  __('one','wpfrl'), '%' ); 
				echo "</span>";
				?>
				</div>
				<div class='datanb'>				
				</div>
				<div class='data'>
				<?php
				$score = get_user_meta(get_the_author_meta('ID') ,'score',TRUE );
				if ($score < 1) $score = "?";
				_e('my score:','wpfrl');
				echo "<br><span>$score</span>";
				?>
				</div>
				
				<div class='datanb'>
				<?php
				if (wp_verify_nonce($_POST['rating'],'up') )	//security
					{
					echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/smile.png' . "' title='" . __('Thanks for voting ! I appreciate it' , 'wpfrl') . "'>";
					$rating = get_user_meta(get_the_author_meta('ID') ,'rating',TRUE );
					$rating++;
					update_user_meta(get_the_author_meta('ID') ,'rating', $rating );
					}
				else
					{
					?>
					<form method='post'>
					<?php wp_nonce_field('up','rating'); ?>
					<input type="hidden" name="accept" value="no">
					<input type="hidden" name="commid" value="<?php comment_ID(); ?>">
					<input type='image' src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/tu.png"; ?>' title='<?php _e('Click if you think this is cool', 'wpfrl'); ?>' >
					</form>	
					<?php
					}
					?>
				</div>
				
				<div class='datanb'>
				<?php
				if (wp_verify_nonce($_POST['rating'],'down') )	//security
					{
					echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/sad.png' . "' title='" . __('I appreciate your downvote, but could you please let me know what is wrong ?' , 'wpfrl') . "'>";
					$rating = get_user_meta(get_the_author_meta('ID') ,'rating',TRUE );
					$rating--; if ($rating < 1) $rating = 1;
					update_user_meta(get_the_author_meta('ID') ,'rating', $rating );
					}
				else
					{
					?>
					<form method='post'>
					<?php wp_nonce_field('down','rating'); ?>
					<input type="hidden" name="accept" value="no">
					<input type="hidden" name="commid" value="<?php comment_ID(); ?>">
					<input type='image' src='<?php echo get_bloginfo('stylesheet_directory') ."/library/images/td.png"; ?>' title='<?php _e('Click if you think this is not so great', 'wpfrl'); ?>' >
					</form>	
					<?php
					}
					?>
				</div>
				
				
			<div style='clear:both'></div>
			</div>
			
		<?php majormedia_content_nav( 'nav-below' ); ?>
		
		<?php wpfrl_add_view_count(); ?>
		</div>

