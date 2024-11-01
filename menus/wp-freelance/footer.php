
		<footer id="colophon" role="contentinfo">
			<div id="site-generator">
				<?php do_action( 'majormedia_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'wpfrl' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'wpfrl' ); ?>" ><?php printf( __( 'Proudly powered by %s', 'wpfrl' ), 'WordPress' ); ?></a>
				<span class="sep"> | majormedia conversion |</span>
				<a href="<?php echo esc_url( __( 'http://wpprogrammeurs.nl/', 'wpfrl' ) ); ?>" ><?php printf( __( ' %1$s Theme by %2$s', 'wpfrl' ), 'WP Freelance', 'WPprogrammeurs.nl' ); ?></a> 		
				
				<div style='float:right'>
				<a href='http://wpfreelancepro.com'><img src='<?PHP echo get_bloginfo('stylesheet_directory') .'/library/images/wpfrllogo.png'; ?>' style="height:32px;margin-right:10px"></a>
				</div>
			</div>

		</footer><!-- #colophon -->
		
		<div id="footer-widget-block">
		<div class="fwidget">
			<ul class="sidebar_list">
			<?php dynamic_sidebar( 'Footer Widget left' ); ?>
			</ul>
		</div>

		<div class="fwidget">
			<ul class="sidebar_list">			
			<?php dynamic_sidebar( 'Footer Widgets Middle' ); ?>
			</ul>
		</div>

		<div class="fwidget">
			<ul class="sidebar_list">			
			<?php dynamic_sidebar( 'Footer Widgets Right' ); ?>
			</ul>
		</div>		
		</div>
		
	</div><!--#curtains-->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>