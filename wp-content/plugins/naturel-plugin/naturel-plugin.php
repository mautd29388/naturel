<?php
/**
 * Plugin Name: Naturel Plugin
 * Plugin URI: #
 * Description: Plugin accompany the themes of mTheme.
 * Version: 1.0
 * Author: mTheme
 * Author URI: http://themeforest.net/user/mtheme_market
 * License: license purchased
 */
function mTheme_activate() {
	flush_rewrite_rules ();
}

register_activation_hook ( __FILE__, 'mTheme_activate' );
function mTheme_deactivate() {
	flush_rewrite_rules ();
}
register_deactivation_hook ( __FILE__, 'mTheme_deactivate' );

add_action( 'admin_enqueue_scripts', 'mTheme_admin_menu_scripts' );
function mTheme_admin_menu_scripts($hook) {

	if ( 'nav-menus.php' != $hook ) {
		return;
	}

	wp_enqueue_media();

	if (function_exists('add_thickbox'))
		add_thickbox();

	wp_enqueue_script('mTheme-admin-menu-js', plugin_dir_url( __FILE__ ) .'assets/js/admin-menu.js', array('common', 'jquery', 'media-upload', 'thickbox'), false, '1.0');
}


$current_active_theme = wp_get_theme();
if ( $current_active_theme->get('Author') == 'mTheme' ) {
	//require plugin_dir_path( __FILE__ ) . 'custom-post-type.php';
	require plugin_dir_path( __FILE__ ) . 'shortcode.php';
	require plugin_dir_path( __FILE__ ) . 'menu.php';
}