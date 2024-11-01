<?php
/*
Plugin Name: * wp-freelance
Plugin URI: http://wordpressprogrammeurs.nl
Description: transconvermify your wordpress into a fully featured freelance job site while maintaining all the blog features and WP core options
Author: pete scheepens
Author URI: http://wordpressprogrammeurs.nl
Version: 0.7
*/

 // start & stop
register_activation_hook(__FILE__, 'wpfrl_plugin_activation');
register_deactivation_hook(__FILE__, 'wpfrl_plugin_deactivation');

function wpfrl_plugin_activation(){
}
function wpfrl_plugin_deactivation(){
}

add_action('admin_menu', 'wpfrl_menu',6);
function wpfrl_menu() {
	add_menu_page('wpfrl_menu', 'wp freelance', 'administrator', 'wpfrl_mainmenu', 'wpfrl_settings', plugins_url('/images/menu-icon.png', __FILE__) );
	add_submenu_page( 'wpfrl_mainmenu', 'setme', 'setme', 'administrator', 'listings','wpfrl_settings' );	
	}
	
	function wpfrl_settings(){
	include_once('menus/wpfrl_settings.php');
	}