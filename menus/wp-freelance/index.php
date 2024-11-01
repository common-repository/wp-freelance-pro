<?php 
get_header(); 
?>

    <div id="content" class="clearfix">
        
        <div id="main" class="col620 clearfix" role="main">

		<?php include('postjob.php'); ?>					
        </div> <!-- end #main -->

        <?php get_sidebar(); ?>
		
		<div class='clear'></div>		
			<div>
			<?php if ( ! dynamic_sidebar( 'middle-cut' ) ) : ?>		
			<?php endif; // slice the indexpage with a widget area ?>
			</div>
		<div class='clear'></div>
	
	<div id="sidebar" class="widget-area col300 leftblock" style='float:left'>
		<aside id="archives" class="widget">
		<?php 
		if ( is_user_logged_in())
			{
			echo "<div style='float:left;padding-right:10px'>";
			$current_user = wp_get_current_user();
			wpfr_avatar( $current_user->ID ,100);
			echo "</div>";
			_e('Welcome Back' , 'wpfrl'); ?>
			<br/><br/>
			<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a>
			<br/><br/>			
			<a href="<?php echo get_author_posts_url( $current_user->ID );?>" title="<?php _e('update your profile' , 'wpfrl'); ?>"><?php _e('My profile' , 'wpfrl');?></a>		
			<div style='clear:both;'></div>
			<?php
			$profilescore = get_user_meta( $current_user->ID, 'profilescore', TRUE );
			if (empty($profilescore)) $profilescore = 15;
			if ($profilescore < 70)
				{
				_e('Your profile score is low. Boost it now by filling out your info and by selecting an avatar', 'wpfrl'); 
				?>	
				<a href="<?php echo get_author_posts_url( $current_user->ID );?>" title="<?php _e('update your profile' , 'wpfrl'); ?>">
					<div style='width:80%;background-color:red;height:20px;margin:3px auto;'>
					<div style='width:<?php echo $profilescore;?>%;background-color:green;height:20px;color:white'>					
					</div>
					</div>
					<?php echo __('profile score', 'wpfrl') . " $profilescore/100";?>
				</a>
				<?php
				echo "<br><br>";
				_e('<h2>Top listers</h2>' , 'wpfrl');
				echo "<br>";
				echo "<ul>";
				wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC&number=6');
				echo "</ul>";
				}					
			}
		else
			{
			echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/dunno.jpg' . "' title='" . __('Please log in to take full effect of all options.' , 'wpfrl') . "' style='width:90px;float:left;padding:10px'>";
			_e('You are currently not logged in ! If you do not yet have an account, simply start by posting something in the box above and you will automatically get registered','wpfrl');
			echo "<div style='clear:both'></div>";
			echo "<br>";
			$args = array(
				'remember' => false
			);
			wp_login_form( $args );
			echo "<div class='clear'></div>";
			?>
			<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="Lost Password"><?PHP _e('Lost Password', 'wpfrl'); ?></a>
			<?php
			echo "<br><div style='text-align:center'>";
			echo "<a href='". get_bloginfo('url') . "/wp-login.php?action=register' title='". __('register', 'wpfrl'). "'>";
			echo "<img src='" . get_bloginfo('stylesheet_directory') .'/library/images/signin.png' . "' width='70%'><br>";
			_e('register', 'wpfrl');
			echo "</a></div>";
			}
		?>
		</aside>
	</div>	
		
		
	<div id="main" class="col620 clearfix" role="main" style='float:right'>	
		<div class='index-titlebox'>
		<h3><?php _e( 'Recent Jobs.', 'wpfrl' ); ?></h3><br/>
		
		<div class='index-title'>
			<div class='jobline'>
				<div class='time'><strong><?php _e( 'posted', 'wpfrl' ); ?></strong></div>
				<div class='link'><strong><?php _e( 'job description', 'wpfrl' ); ?></strong></div>
				
				<div class='budget'>				
					<?PHP if ($_GET['budget'] == 'ltoh')
					{ echo "<a href='". get_bloginfo('url') .'/?budget=htol' .  "' title='" . __('Select budget from high to low', 'wpfrl') . "'>"; }
					else
					{ echo "<a href='". get_bloginfo('url') . '/?budget=ltoh' . "' title='" . __('Select budget from low to high', 'wpfrl') . "'>"; }
					?>
					<strong><?php _e( 'budget', 'wpfrl' ); ?></strong>
					<?PHP echo "</a>"; ?>				
				</div>
				
				<div class='deadline'><strong><?php _e( 'deadline', 'wpfrl' ); ?></strong></div>
			</div>
		</div> 
		
		<?php 
			// only show freelance_post in the box
			global $wp_query;
			
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			
			if ($_GET['budget'] == 'ltoh')
				{
				$args = array(
					'post_type'      => 'freelance_post',
					'paged'  		 => $paged,
					'meta_key'       => 'budget',
					'orderby'        => 'meta_value_num',
					'order'          => 'ASC',					
					);
				}
			if ($_GET['budget'] == 'htol')
				{
				$args = array(
					'post_type'      => 'freelance_post',
					'paged'  		 => $paged,
					'meta_key'       => 'budget',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',					
					);
				}	
			else 
				{
				$args = array(
					'post_type'      => 'freelance_post',
					'paged'  		 => $paged,
					);	
				}
				
			//query_posts($args);
			$the_query = new WP_Query( $args );
			//print_R($the_query);
			if ( $the_query->have_posts() ) : 
			?>

			<?php /* Start the Loop */ ?>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content-index', get_post_format() );
				?>

			<?php endwhile; 
			// Reset Post Data
			
			?>
			
			<?php if (function_exists("majormedia_pagination")) {
						majormedia_pagination(); 
			} elseif (function_exists("majormedia_content_nav")) { 
						majormedia_content_nav( 'nav-below' );
			wp_reset_postdata();			
			}?>

		<?php
		
		else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'There are no jobs yet.', 'wpfrl' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'Create some jobs by posting in the box above.', 'wpfrl' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>
		</div>
	</div>	
		
    </div> <!-- end #content -->
        
<?php get_footer(); ?>