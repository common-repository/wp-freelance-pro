<?php
// setup functions wp-freelance

// ************ CPT **************************
add_action( 'init', 'wpfrl_create_post_type' );

function wpfrl_create_post_type() {
	register_post_type( 'freelance_post',
		array(
			'labels' => array(
				'name' => 'freelance projects',
				'singular_name' => 'freelance Project',
				'menu_name' => 'freelance projects'
			),
		'description'     => 'a job or project for the freelance section',
		'public'          => true,
		'has_archive'     => true,
		'capability_type' => 'post',
		'query_var'       => true,
		'rewrite'         => array('with_front' => false,'slug' => 'project'),
		'taxonomies'      => array('freelance_tag','freelance_category'),
		'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields','comments' )
		)
	);
}

if (!taxonomy_exists('freelance_tag'))	
		{		
		// and tie the new taxo to the posts
		  register_taxonomy('freelance_tag','freelance_post', array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => array(
			'name' => 'freelance tag',
			'singular_name' => 'freelance tag',
			'search_items' => 'search freelance tag',			
			'menu_name' => 'freelance tag',
			),	
			'query_var' => true,
			'rewrite' => array( 'with_front' => false,'slug' => 'freelance-tag' ),
		  ));
		}
if (!taxonomy_exists('freelance_category'))	
		{		
		// and tie the new taxo to the posts
		  register_taxonomy('freelance_category','freelance_post', array(
			'hierarchical' => true,
			'show_ui' => true,
			'labels' => array(
			'name' => 'freelance category',
			'singular_name' => 'freelance category',
			'search_items' => 'search freelance category',			
			'menu_name' => 'freelance category',
			),
			'query_var' => true,
			'rewrite' => array( 'with_front' => false,'slug' => 'freelance-category' ),
		  ));
		}
		
// ************ FLUSH PERM ON THEME SWITCH **************************		
function wpfrl_perm($oldname, $oldtheme=false) {
 flush_rewrite_rules();
}
add_action("after_switch_theme", "wpfrl_perm", 10 ,  2);
add_action("switch_theme", "wpfrl_perm", 10 , 2);

		
// ************ CREATE DATABASE **************************
function wpf_init() {
global $wpdb;
$table_name = $wpdb->prefix . "freelance";
		$sql2 = "CREATE TABLE $table_name (
		  pid mediumint(9) NOT NULL,
		  fname VARCHAR( 30 ) DEFAULT '' NOT NULL,
		  lname VARCHAR( 30 ) DEFAULT '' NOT NULL,
		  email VARCHAR( 30 ) DEFAULT '' NOT NULL,
		  zip VARCHAR( 10 ) DEFAULT '' NOT NULL,
		  actcode VARCHAR( 20 ) DEFAULT '' NOT NULL,
		  timein int(10) DEFAULT '0' NOT NULL,
		  visitorip VARCHAR( 16 ) DEFAULT '' NOT NULL,
		  UNIQUE KEY pid (pid)
		);";			
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql2);
}

// ************ GET IP **************************
function wpf_getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}

// *********** CRON ***************************
add_action('wp', 'wpfrl_activation');
add_action('wpfrl_mail', 'wpfrlmail');

register_deactivation_hook(__FILE__, 'wpfrl_deactivation');
register_activation_hook(__FILE__, 'wpfrl_activation');


function wpfrl_deactivation() {
	wp_clear_scheduled_hook('wpfrl_mail');
}

function wpfrl_activation() {
	if ( !wp_next_scheduled( 'wpfrl_mail' ) ) {
		wp_schedule_event(time(), 'daily', 'wpfrl_mail');
	}
}

function wpfrlmail()
	{
	// future
	}
	
function wpfrl_notice()
	{
	$expire = get_option('wpfrloutdate' , 0);
	if ($expire)
		{
		echo '<div class="error">
		   <p>Your wp freelance pro theme is outdated ! Please visit <a href="http://wpfreelancepro.com">freelancepro.com</a> to get your (security ?) updates.</p>
		</div>';
		}
	}
	
add_action('admin_notices', 'wpfrl_notice');
// ***********END CRON ***************************

// *********** WP SIGNUP LOGO ********************
function wpfrl_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(' . get_bloginfo('stylesheet_directory') .'/library/images/wpfrllogo.png) !important; }
    </style>';
}

add_action('login_head', 'wpfrl_logo');

// ************* HACK PAGINATION *******************
add_action( 'parse_query','wpfrl_changept' );
function wpfrl_changept() {
		if ( is_paged() && is_home() )
		set_query_var( 'post_type', array( 'freelance_post' )) ;
	return;
}