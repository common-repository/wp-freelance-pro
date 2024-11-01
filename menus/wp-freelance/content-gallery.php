
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_search() || is_archive() ) : ?>
    	<?php if ( has_post_format( 'gallery' ) ) : ?>
			<?php $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
            if ( $images ) :
                $image = array_shift( $images );
                $image_img_tag = wp_get_attachment_image( $image->ID, array(150, 125) );
        ?>
            <div class="imgthumb">
            <a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
            </div><!-- .gallery-thumb -->
            <?php endif; ?>

            <?php elseif ( has_post_thumbnail()) : ?>
            
            <div class="imgthumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( array(150, 125) ); ?></a></div>
            
            <?php else : ?>
            
            <?php $postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
            if ( !empty($postimgs) ) :
                $firstimg = array_shift( $postimgs );
                $my_image = wp_get_attachment_image( $firstimg->ID, array(150, 125) );
            ?>
            
            <div class="imgthumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $my_image; ?></a></div>
        
            <?php endif; ?>
         <?php endif; ?>
    <?php endif; ?>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpfrl' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( ! (is_search() || is_archive()) ) : ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php majormedia_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
        <?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_archive() ) : // Only display Excerpts for search pages ?>
	<div class="entry-summary post_content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content post_content">
		<?php if ( post_password_required() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wpfrl' ) ); ?>

			<?php else : ?>
				<?php
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>

				<figure class="gallery-thumb">
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</figure><!-- .gallery-thumb -->

				<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'wpfrl' ),
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'wpfrl' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></em></p>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpfrl' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
    	<?php if ( is_search() || is_archive() ) : ?>
            <div class="yellow-bar"></div>
            <?php majormedia_posted_on(); ?>
            <span class="sep"> | </span>
        <?php endif; ?>
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'wpfrl' ) );
				if ( $categories_list && majormedia_categorized_blog() ) :
			?>
			<?php if ( is_search() || is_archive() ) : ?>
            <span class="cat-links">
				<?php printf( __( 'Filed Under %1$s', 'wpfrl' ), $categories_list ); ?>
			</span>
			<span class="sep"> | </span>
            <?php  else : ?>
			<div class="cat-links">
				<span class="cat-under"><?php _e( 'Filed Under', 'wpfrl' ); ?></span>
                <span class="cat-list"><?php echo $categories_list ?></span>
			</div>
            <?php endif; ?>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'wpfrl' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'wpfrl' ), $tags_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wpfrl' ), __( '1 Comment', 'wpfrl' ), __( '% Comments', 'wpfrl' ) ); ?></span>
		<span class="sep"> | </span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'wpfrl' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
    <?php if ( ! (is_search() || is_archive()) ) : ?>
    	<div class="dash"></div>
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
