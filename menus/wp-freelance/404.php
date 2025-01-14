<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="col620 clearfix" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Well this is somewhat embarrassing, isn&rsquo;t it?', 'wpfrl' ); ?></h1>
				</header>

				<div class="entry-content post_content">
					<h3><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'wpfrl' ); ?></h3>

					<div class='wpf-search'>
					<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
					<div><label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="Search" />
					</div>
					</form>
					</div>

					<?php
					the_widget( 'WP_Widget_Recent_Posts', 'title=Most recent jobs' ); ?>

					<div class="widget">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'wpfrl' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div>

					<?php
					/* translators: %1$s: smilie */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'wpfrl' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>