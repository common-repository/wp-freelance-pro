<?php get_header(); ?>

<?php
// visiting or owning this page ??
global $wp_query;
$auth = $wp_query->get_queried_object();
//echo "<h2>page about</h2>";
//print_R($auth);

$current_user = wp_get_current_user();
$loggedin_id = $current_user->ID;
//echo "<h2>visitor</h2>";
//print_R($current_user);

$um = get_user_meta($auth->ID);
//echo "<h2>user meta</h2>";
//print_R($um);


?>
    <div id="content" class="clearfix">
		<div class='freelance-single'>
				
			<?php if ($current_user->user_login === $auth->user_login)  include('personal.php'); 
			//include('personal.php');
			?>
			
			<?php include('authorinfo.php'); ?>
						
		</div>
    </div> <!-- end #content -->
        
<?php get_footer(); ?>