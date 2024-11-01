<div style='margin:30px;padding:20px;border:2px solid #CCC'>
<h1>WP Freelance PRO</h1>
Transconvermifies* your wordpress into a full fledged Job posting site.<br>
Attract bids from freelancer and other Professionals while building a solid reference base for professional services.<br>
<h2>Getting started</h2>
To get started simply hit the button below. This is a one-step process and does not involve any user settings.<br>
All features and options are accessible through the front-end of your wordpress install.<br/><br/>
<?PHP
// wp freelance menu
function wpfrl_recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                wpfrl_recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

// process form input
if (wp_verify_nonce($_POST['wpfrl-field'],'wpfrl_nonce') )
  {
  // check if theme exists
	if (file_exists(get_theme_root() . "/wp-freelance"))
		{
		echo "<div style='margin:30px;padding:20px;border:2px solid #CCC'>";
		echo "<h1>The WP FREELANCE core already exists</h1>";
		switch_theme( 'wp-freelance','wp-freelance' ) ;
		echo "the wp-freelance is now activate";
		echo "</div>";
		}
	else
		{
		echo "<div style='margin:30px;padding:20px;border:2px solid #CCC'>";
		echo "<h2>Attempting to install WP FREELANCE</h2>"; 
		wpfrl_recurse_copy ( plugin_dir_path( __FILE__). 'wp-freelance',get_theme_root() . "/wp-freelance");
		sleep(6);
		if (file_exists(get_bloginfo('template_url') . "/wp-freelance"))
			{
			echo "<h2>switching to WP freelance core</h2>";
			switch_theme( $template, $stylesheet ) ;
			echo "WP-Freelance is now active";
			}
		else
			{
			?>
			<H2>Maybe I was too slow - hit the install button again please !</h2>
			<h1> OR .......</h1>
			<h3>--* I have mo Write Permission for the theme directory *--<h3><br>
			Oh bummer ... I do not seem to have permission to copy files to the theme directory. This is a pity since you now have to do some manual labor to get WP Freelance PRO installed.<br/>
			To install manually you will have to copy a theme from this plugin directory into your theme directory. Here's how : <br>
			<ul>
			<li>Go into the plugin directory -> wp-freelance-PRO -> menus -></li>
			<li>There you will find a directory called 'wp-freelance' ... this is actually a THEME</li>
			<li>Copy the whole wp-freelance directory into your wordpress theme directory (wp-themes)</li>
			<li>Now visit your appearance tab in your admin panel and activate the WP=freelance theme</li>
			</ul>
			<br>
			The easy way : make sure your plugins have write access to the wp-content directory !<br/>			
			<?PHP
			}
		echo "</div>";	
		}
  }
  
?>

<form method='post'>
<?php wp_nonce_field('wpfrl_nonce','wpfrl-field'); ?>
<input type='submit' value='INSTALL WP Freelance'>
</form>

	<div style='float:right;width:40%;font-size:0.8EM;border:2px solid red;padding:8px'>
	At this time WP freelance PRO is still under heavy development. Expect updates to arrive in short succession until Version 1.0 has been reached. While this product is now stable and fully functional, you may still be missing some awesome features that are undergoing testing as we speak.<br/>
	If you are not satisfied, please do not rate this plugin prematurely but contact us and let us know how we can improve things. Together we can make this a plugin that everyone enjoys !
	</div>
<div style='clear:both'></div>
Development and live demo version: <a href='http://wpfreelancepro.com'>http://wpfreelancepro.com</a><br/>
Engineers and developers : <a href='http://wpprogrammeurs.nl'>http://wpprogrammeurs.nl</a><br/>
<br><br>
* transconvermification : The act of converting a standard WordPress site into a PRO featured site by clicking just a single button !~(first used in the process of installing wpfreelancepro).
</div>  


<div style='box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto'>
<h3>Latest news</h3>
Visit <a href="http://wpfreelancepro.com" title="home of wpfreelancepro">wpfreelancepro.com</a> for more news.<hr>
	<?php 	
	if(function_exists('fetch_feed')) 
	{
		include_once(ABSPATH . WPINC . '/feed.php');
		$feed = 'http://wpfreelancepro.com/forums/feed';
		$rss = fetch_feed($feed);
		if (!is_wp_error( $rss ) ) :
			$maxitems = $rss->get_item_quantity(2);
			$rss_items = $rss->get_items(0, $maxitems);
			if ($rss_items):
				echo "<ul>\n";
				foreach ( $rss_items as $item ) :
					echo '<li>';
					//print_R($item);
					echo '<a href="' . $item->get_permalink() . '">' . $item->get_title() . "</a>\n";
					echo '<p>' . $item->get_content() . "</li>\n";
				endforeach;
				echo "</ul>\n";
			endif;
		endif;		
	}
	
?>
</div>