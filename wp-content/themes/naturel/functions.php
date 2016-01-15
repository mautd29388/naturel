<?php

if ( ! isset( $content_width ) ) $content_width = 1920;

add_action( 'after_setup_theme', 'm_wedding_setup' );
function m_wedding_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 600, 400, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'mTheme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array('search-form', 'comment-list', 'gallery', 'caption') );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	//add_theme_support( 'post-formats', array('video') );
	
	add_theme_support( 'woocommerce' );

}

// TGM-Plugin-Activation
require_once (trailingslashit ( get_template_directory () ) . 'inc/TGM-Plugin-Activation/load.php');

// Custom Function
require( trailingslashit( get_template_directory() ) . 'inc/function.php' );


add_action ( 'wp_enqueue_scripts', 'm_wedding_scripts' );
function m_wedding_scripts() {
	global $wpdb;
	
	// Load Style
	$less = "assets/css/". $wpdb->prefix ."main.css";
	if ( file_exists( trailingslashit( get_template_directory() ) . $less ) ) { 
		wp_enqueue_style ( 'mTheme-main', trailingslashit( get_template_directory_uri() ) . $less );
	}
	
	wp_enqueue_style ( 'mTheme-style', get_stylesheet_uri() );
	
	
	// Load Script
	wp_register_script ( 'google-maps-js', 'https://maps.googleapis.com/maps/api/js' );
	wp_register_script ( 'maps-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/maps.js', array (), null, true );
	
	wp_enqueue_script ( 'modernizr-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js' );
	wp_enqueue_script ( 'imagesloaded-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/imagesloaded.pkgd.min.js', array (), null, true );
	wp_enqueue_script ( 'bootstrap-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/bootstrap.min.js', array ('jquery'), null, true );
	//wp_enqueue_script ( 'waypoints-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/jquery.waypoints.min.js', array ('jquery'), null, true );
	//wp_enqueue_script ( 'sticky-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/sticky.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'flickity-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/flickity.pkgd.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'main-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/main.js', array ('jquery'), null, true );

	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
}	


