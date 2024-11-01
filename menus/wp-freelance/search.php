<?php
/**
 * The template for displaying Search Results pages.
 */
get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="col620 clearfix" role="main">
		<div class='freelance-single'> 

		<div class='wpf-search'>
		<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<div><label class="screen-reader-text" for="s"><?PHP _e('search for:', 'wpfrl'); ?></label>
        <input type="text" value="" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="<?PHP _e('search', 'wpfrl'); ?>" />
		</div>
		</form>
		</div>
		
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'wpfrl' ), '<span class="red">' . get_search_query() . '</span>' ); ?></h1>
                    <div class="dash2"></div>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

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

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpfrl' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
		</div>
        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>