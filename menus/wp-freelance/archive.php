<?php get_header(); ?>

    <div id="content" class="clearfix">
       
		<div id="main" class="col620 clearfix" role="main">
		
			<div class='freelance-single'> 
				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title">
							<?php
								if ( is_day() ) :
									printf( __( 'Daily Archives: %s', 'wpfrl' ), '<span class="red">' . get_the_date() . '</span>' );
								elseif ( is_month() ) :
									printf( __( 'Monthly Archives: %s', 'wpfrl' ), '<span class="red">' . get_the_date( 'F Y' ) . '</span>' );
								elseif ( is_year() ) :
									printf( __( 'Yearly Archives: %s', 'wpfrl' ), '<span class="red">' . get_the_date( 'Y' ) . '</span>' );
								else :
									_e( 'Archives', 'wpfrl' );
								endif;
							?>
						</h1>
						<div class="dash2"></div>
					</header>

					<?php rewind_posts(); ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 */
							get_template_part( 'content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php if (function_exists("majormedia_pagination")) {
								majormedia_pagination(); 
					} elseif (function_exists("majormedia_content_nav")) { 
								majormedia_content_nav( 'nav-below' );
					}?>

				<?php else : ?>

					<article id="post-0" class="post no-results not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'wpfrl' ); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content post_content">
							<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wpfrl' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				<?php endif; ?>

			</div><!--# freelance border-->
        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>