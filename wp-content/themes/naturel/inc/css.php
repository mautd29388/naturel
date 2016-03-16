<?php

/**
 * Extend body classes
 */
add_filter ( 'body_class', 'm_wedding_body_classes' );
function m_wedding_body_classes($classes) {

	if ( is_front_page() )
		$classes [] = 'loadpage';

	$classes [] = m_wedding_get_options('main_styles', '');
	
	return $classes;
}

/**
 * Extend Product classes
 */
add_filter ( 'post_class', 'm_wedding_post_classes' );
function m_wedding_post_classes($classes) {

	if ( function_exists('is_woocommerce') && is_woocommerce() && !is_product() )
		$classes [] = 'animated fadeInUp';

	return $classes;
}

/**
 * Custom Style
 */
add_action ( 'wp_head', 'm_wedding_style' );
function m_wedding_style() {

	$style = '';

	/**
	 * MAIN
	 * */
	// Background Body
	$__background_body = m_wedding_get_options('background_body');
	if ( isset($__background_body) && is_array($__background_body) && count($__background_body) > 0 ) {
		$background_body = array();
		foreach ( $__background_body as $k => $val ) {

			if ( $k == 'background-image' )
				$background_body[] = $k . ': url(' . $val . ')' . '!important';

			else
				$background_body[] = $k . ':' . $val . '!important';
		}
		if ( count($background_body) > 0 ) {
			$style .= 'body {' ;
			$style .= implode(';', $background_body);
			$style .= '}';
		}
	}
	
	// Background Boxed
	$__background_boxed = m_wedding_get_options('background_boxed');
	$boxed 			= m_wedding_get_options('main_boxed', 'on');
	if ( $boxed == 'on' && isset($__background_boxed) && is_array($__background_boxed) && count($__background_boxed) > 0 ) {
		$background_boxed = array();
		foreach ( $__background_boxed as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_boxed[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_boxed[] = $k . ':' . $val . '!important';
		}
		if ( count($background_boxed) > 0 ) {
			$style .= '#wrap.container {' ;
			$style .= implode(';', $background_boxed);
			$style .= '}';
		}
	}

	// Background Main
	$__background_main = m_wedding_get_options('background_main');
	if ( isset($__background_main) && is_array($__background_main) && count($__background_main) > 0 ) {
		$background_main = array();
		foreach ( $__background_main as $k => $val ) {

			if ( $k == 'background-image' )
				$background_main[] = $k . ': url(' . $val . ')' . '!important';

			else
				$background_main[] = $k . ':' . $val . '!important';
		}
		if ( count($background_main) > 0 ) {
			$style .= '#main-content {' ;
			$style .= implode(';', $background_main);
			$style .= '}';
		}
	}
	
	
	/**
	 * HEADER
	 * */
	// Background Header
	$__background_header = m_wedding_get_options('background_header');
	if ( isset($__background_header) && is_array($__background_header) && count($__background_header) > 0 ) {
		$background_header = array();
		foreach ( $__background_header as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_header[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_header[] = $k . ':' . $val . '!important';
		}
		if ( count($background_header) > 0 ) {
			$style .= '.header {' ;
			$style .= implode(';', $background_header);
			$style .= '}';
		}
	}
	
	// Background Top
	$__background_header_top = m_wedding_get_options('background_header_top');
	if ( isset($__background_header_top) && is_array($__background_header_top) && count($__background_header_top) > 0 ) {
		$background_header_top = array();
		foreach ( $__background_header_top as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_header_top[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_header_top[] = $k . ':' . $val . '!important';
		}
		if ( count($background_header_top) > 0 ) {
			$style .= '.header .header-top {' ;
			$style .= implode(';', $background_header_top);
			$style .= '}';
		}
	}
	
	// Background Header Middle
	$__background_header_middle = m_wedding_get_options('background_header_middle');
	if ( isset($__background_header_middle) && is_array($__background_header_middle) && count($__background_header_middle) > 0 ) {
		$background_header_middle = array();
		foreach ( $__background_header_middle as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_header_middle[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_header_middle[] = $k . ':' . $val . '!important';
		}
		if ( count($background_header_middle) > 0 ) {
			$style .= '.header .header-middle {' ;
			$style .= implode(';', $background_header_middle);
			$style .= '}';
		}
	}
	
	// Background Header Bottom
	$__background_header_bottom = m_wedding_get_options('background_header_bottom');
	if ( isset($__background_header_bottom) && is_array($__background_header_bottom) && count($__background_header_bottom) > 0 ) {
		$background_header_bottom = array();
		foreach ( $__background_header_bottom as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_header_bottom[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_header_bottom[] = $k . ':' . $val . '!important';
		}
		if ( count($background_header_bottom) > 0 ) {
			$style .= '.header .header-bottom {' ;
			$style .= implode(';', $background_header_bottom);
			$style .= '}';
		}
	}
	
	
	/**
	 * FOOTER
	 * */
	// Background Footer
	$__background_footer = m_wedding_get_options('background_footer');
	if ( isset($__background_footer) && is_array($__background_footer) && count($__background_footer) > 0 ) {
		$background_footer = array();
		foreach ( $__background_footer as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_footer[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_footer[] = $k . ':' . $val . '!important';
		}
		if ( count($background_footer) > 0 ) {
			$style .= '.footer {' ;
			$style .= implode(';', $background_footer);
			$style .= '}';
		}
	}
	
	// Background Footer Top
	$__background_footer_top = m_wedding_get_options('background_footer_top');
	if ( isset($__background_footer_top) && is_array($__background_footer_top) && count($__background_footer_top) > 0 ) {
		$background_footer_top = array();
		foreach ( $__background_footer_top as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_footer_top[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_footer_top[] = $k . ':' . $val . '!important';
		}
		if ( count($background_footer_top) > 0 ) {
			$style .= '.footer {' ;
			$style .= implode(';', $background_footer_top);
			$style .= '}';
		}
	}
	
	// Background Footer Middle
	$__background_footer_middle = m_wedding_get_options('background_footer_middle');
	if ( isset($__background_footer_middle) && is_array($__background_footer_middle) && count($__background_footer_middle) > 0 ) {
		$background_footer_middle = array();
		foreach ( $__background_footer_middle as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_footer_middle[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_footer_middle[] = $k . ':' . $val . '!important';
		}
		if ( count($background_footer_middle) > 0 ) {
			$style .= '.footer {' ;
			$style .= implode(';', $background_footer_middle);
			$style .= '}';
		}
	}
	

	/**
	 * TYPOGRAPHY
	 * */
	// Typography Body
	$typography = m_wedding_get_options('typography_body');
	if ( isset($typography) && is_array($typography) && count($typography) > 0 ) {
		$typography_body = array();
		if ( isset($typography['font-family']) && !empty($typography['font-family']) ) {
			$google_font = m_wedding_ot_google_font_stack( array(), $typography['font-family'] );
			$typography['font-family'] = $google_font[$typography['font-family']];
		}
	
		if ( isset($typography['font-color']) && !empty($typography['font-color']) ) {
			$typography_body[] = 'color' . ':' . $typography['font-color'];
			unset($typography['font-color']);
		}
	
		foreach ( $typography as $k => $val ) {
	
			if ( !empty($val) )
				$typography_body[] = $k . ':' . $val;
		}
		
		if ( count($typography_body) > 0 ) {
			$style .= 'body {' ;
			$style .= implode(';', $typography_body);
			$style .= '}';
		}
	
	}
	
	// Typography Heading
	$heading = m_wedding_get_options('typography_heading');
	if ( isset($heading) && is_array($heading) && count($heading) > 0 ) {
		$heading_css = array();
		if ( isset($heading['font-family']) && !empty($heading['font-family']) ) {
			$google_font = m_wedding_ot_google_font_stack( array(), $heading['font-family'] );
			$heading['font-family'] = $google_font[$heading['font-family']];
		}
	
		if ( isset($heading['font-color']) && !empty($heading['font-color']) ) {
			$heading_css[] = 'color' . ':' . $heading['font-color'];
			unset($heading['font-color']);
		}
	
		foreach ( $heading as $k => $val ) {
	
			if ( !empty($val) )
				$heading_css[] = $k . ':' . $val;
		}
	
		if ( count($heading_css) > 0 ) {
			$style .= 'nav.navbar,h1,h2,h3,h4,h5,h6 {' ;
			$style .= implode(';', $heading_css);
			$style .= '}';
		}
	
	}
	
	
	/**
	 * PAGE HEADER
	 * */
	
	//Background Page Title
	$__background_page_title = array();
	
	if ( function_exists('is_woocommerce') && is_woocommerce() ) {
		$__background_page_title = m_wedding_get_options('shop_background_title');
		
	} elseif ( is_page() ) {
		$__background_page_title = get_post_meta(get_the_ID(), '__background_title', true);
		
	} else {
		$__background_page_title = m_wedding_get_options('blog_background_title');
	}
	
	if ( isset($__background_page_title) && is_array($__background_page_title) && count($__background_page_title) > 0 ) {
		$background_page_title = array();
		foreach ( $__background_page_title as $k => $val ) {
	
			if ( $k == 'background-image' )
				$background_page_title[] = $k . ': url(' . $val . ')' . '!important';
	
			else
				$background_page_title[] = $k . ':' . $val . '!important';
		}
		if ( count($background_page_title) > 0 ) {
			$style .= '.main-content .page-header {' ;
			$style .= implode(';', $background_page_title);
			$style .= '}';
		}
	}
	
	echo "<style type='text/css'>$style</style>";
}

