<?php

/**
 * Options default
 * */
add_action ( 'load-themes.php', 'm_wedding_init_theme' );
function m_wedding_init_theme() {
	global $pagenow;
	
	if ('themes.php' == $pagenow && isset ( $_GET ['activated'] )) {
		update_option ( 'thumbnail_size_h', 400 );
		update_option ( 'thumbnail_size_w', 900 );
		update_option ( 'medium_size_h', 0 );
		update_option ( 'medium_size_w', 1000 );
		update_option ( 'posts_per_page', 3 );
		//update_option ( 'users_can_register', 1 );
	}
}

/**
 * Theme Options
 */
add_filter ( 'ot_child_theme_mode', '__return_false' );

add_filter ( 'ot_show_options_ui', '__return_false' );

add_filter ( 'ot_show_new_layout', '__return_false' );

add_filter ( 'ot_use_theme_options', '__return_true' );

add_filter ( 'ot_meta_boxes', '__return_true' );

add_filter ( 'ot_post_formats', '__return_true' );

require (trailingslashit ( get_template_directory () ) . 'inc/theme-options.php');
require (trailingslashit ( get_template_directory () ) . 'inc/meta-boxes.php');

/**
 * Widget and Sidebar
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/widgets.php');

/**
 * Funtion for Woocommerce
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/woocommerce.php');

/**
 * Custom css
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/css.php');


/**
 * Disable support for comments in page types
 * */
add_action ( 'init', 'm_wedding_disable_comments_page_support' );
function m_wedding_disable_comments_page_support() {
	remove_post_type_support ( 'page', 'comments' );
}

/* do_shortcode Widget Text */
add_filter('widget_text', 'do_shortcode');


/**
 * Get link post_type and page number
 */
function m_wedding_get_post_type_archive_pagenum_link($post_type, $max_page, $pagenum) {
	global $wp_rewrite;
	
	$pagenum = ( int ) $pagenum;
	$max_page = ( int ) $max_page;
	
	if ($max_page < $pagenum)
		return false;
	
	if (! $post_type_obj = get_post_type_object ( $post_type ))
		return false;
	
	if (! $post_type_obj->has_archive)
		return false;
	
	if (get_option ( 'permalink_structure' ) && is_array ( $post_type_obj->rewrite )) {
		$struct = (true === $post_type_obj->has_archive) ? $post_type_obj->rewrite ['slug'] : $post_type_obj->has_archive;
		if ($post_type_obj->rewrite ['with_front'])
			$struct = $wp_rewrite->front . $struct;
		else
			$struct = $wp_rewrite->root . $struct;
		
		$request = user_trailingslashit ( $struct, 'post_type_archive' );
	} else {
		$request = '?post_type=' . $post_type;
	}
	
	$home_root = parse_url ( home_url () );
	$home_root = (isset ( $home_root ['path'] )) ? $home_root ['path'] : '';
	$home_root = preg_quote ( $home_root, '|' );
	
	$request = preg_replace ( '|^' . $home_root . '|i', '', $request );
	$request = preg_replace ( '|^/+|', '', $request );
	
	if (! $wp_rewrite->using_permalinks () || is_admin ()) {
		$base = trailingslashit ( home_url () );
		
		if ($pagenum > 1) {
			$result = add_query_arg ( 'paged', $pagenum, $base . $request );
		} else {
			$result = $base . $request;
		}
	} else {
		$qs_regex = '|\?.*?$|';
		preg_match ( $qs_regex, $request, $qs_match );
		
		if (! empty ( $qs_match [0] )) {
			$query_string = $qs_match [0];
			$request = preg_replace ( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}
		
		$request = preg_replace ( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
		$request = preg_replace ( '|^' . preg_quote ( $wp_rewrite->index, '|' ) . '|i', '', $request );
		$request = ltrim ( $request, '/' );
		
		$base = trailingslashit ( home_url () );
		
		if ($wp_rewrite->using_index_permalinks () && ($pagenum > 1 || '' != $request))
			$base .= $wp_rewrite->index . '/';
		
		if ($pagenum > 1) {
			$request = ((! empty ( $request )) ? trailingslashit ( $request ) : $request) . user_trailingslashit ( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}
		
		$result = $base . $request . $query_string;
	}
	
	/**
	 * Filter the page number link for the current request.
	 *
	 * @since 2.5.0
	 *       
	 * @param string $result
	 *        	The page number link.
	 */
	$result = apply_filters ( 'get_pagenum_link', $result );
	
	if ($escape)
		return esc_url ( $result );
	else
		return esc_url_raw ( $result );
}

/**
 * Portfolio pre get posts
 * */
//add_action ( 'pre_get_posts', 'm_wedding_pre_get_posts' );
function m_wedding_pre_get_posts() {
	global $wp_query;
	
	if (is_post_type_archive ( 'mportfolio' )) {
		
		$posts_per_page = m_wedding_get_options ( 'portfolio_items', 12 );
		
		$wp_query->set ( 'posts_per_page', $posts_per_page );
	}
}

/**
 * Less
 */
add_action( 'init', 'm_wedding_include_less_dev' );
function m_wedding_include_less_dev(){
	
	if ( is_admin() ) 
		return false;
	
	m_wedding_include_less();
}

add_filter('ot_before_page_messages', 'm_wedding_ot_before_page_messages_less');
function m_wedding_ot_before_page_messages_less($before) {
	
	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	$message = isset( $_REQUEST['message'] ) ? $_REQUEST['message'] : '';
	
	if ( $action == 'import-data' && $message == 'success' ) {
		m_wedding_include_less();
	}
	
	return $before;
}

add_action( 'ot_after_theme_options_save', 'm_wedding_include_less' );
function m_wedding_include_less() {
	global $wpdb;
	
	$cookie_name = $wpdb->prefix . 'featured_color';
	$featured_color = m_wedding_get_options( 'featured_color' );
	
	if ( is_admin() ) {
		
		if ( !isset($featured_color) || empty($featured_color) || ( isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == $featured_color ) ) {
			return false;
			
		} else{
			setcookie($cookie_name, $featured_color, time() + (86400 * 30), "/");
		}
		
	}
	
	require_once ('less/Less.php');
	
	try{
		
		$options = array(
				//'compress'			=> true,
				'cache_dir'				=> get_template_directory () . "/assets/less/cache",
				'sourceMap' 			=> true,
				//'sourceMapWriteTo'  	=> get_template_directory () . '/assets/less/stylesheets.map',
				//'sourceMapURL'      	=> get_template_directory_uri() . '/assets/less/stylesheets.map',
		);
		
		
		$parser = new Less_Parser( $options );
		
		$parser->parseFile( get_template_directory () . "/assets/less/stylesheets.less", '../' );
		
		$parser->ModifyVars( array('font-size-base'=>'17px', 'brand-primary' => $featured_color) );
		
		$css = $parser->getCss();
		
		global $wp_filesystem;
		
		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		
		if ( ! $wp_filesystem->put_contents(  get_template_directory () . "/assets/css/". $wpdb->prefix ."main.css", $css, FS_CHMOD_FILE) ) {
			wp_die("error saving file css!");
		}
		
	} catch(Exception $e){
		$error_message = $e->getMessage();
	}
	
}


/**
 * Get Font google
 * */
function m_wedding_ot_google_font_stack($families, $field_id) {
	$ot_google_fonts = get_theme_mod ( 'ot_google_fonts', array () );
	$ot_set_google_fonts = get_theme_mod ( 'ot_set_google_fonts', array () );
	
	if (! empty ( $ot_set_google_fonts )) {
		foreach ( $ot_set_google_fonts as $id => $sets ) {
			foreach ( $sets as $value ) {
				$family = isset ( $value ['family'] ) ? $value ['family'] : '';
				if ($family && isset ( $ot_google_fonts [$family] )) {
					$spaces = explode ( ' ', $ot_google_fonts [$family] ['family'] );
					$font_stack = count ( $spaces ) > 1 ? '"' . $ot_google_fonts [$family] ['family'] . '"' : $ot_google_fonts [$family] ['family'];
					$families [$family] = apply_filters ( 'ot_google_font_stack', $font_stack, $family, $field_id );
				}
			}
		}
	}
	
	return $families;
}



/**
 * Check Ajax
 * @return boolean
 */
function m_wedding_is_ajax() {
	if (! empty ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest') {
		return true;
	}
	
	return false;
}

/**
 * Get Option of mTheme
 * @param unknown $option_id
 * @param string $default
 * @return string
 */
function m_wedding_get_options($option_id, $default = '') {

	if ( isset($_GET[$option_id]) && !empty($_GET[$option_id]) ) {
		return $_GET[$option_id];
	
	} elseif ( function_exists('ot_get_option') )
		return ot_get_option($option_id, $default);

	return $default;
}

/**
 * mTheme Trim
 * */
function m_wedding_trim( $text, $excerpt_length = 55){

	$excerpt_more = apply_filters( 'excerpt_more', '...' );
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;
}


/**
 * Container
 * */
function m_wedding_container(){
	$container = m_wedding_get_options('main_container', 'off');

	if ( $container == 'off' ) {
		return 'container';
	}

	return 'container-fluid';
}

/**
 * Themes Template Part
 * */
function m_wedding_get_template_part($slug, $name = '') {
	$template_path = untrailingslashit ( get_template_directory() );

	$template = '';

	$name = ( string ) $name;
	if ('' !== $name) {
		$template = $template_path . "/contents/{$slug}-{$name}.php";
	} else
		$template = $template_path . "/contents/{$slug}.php";

	return $template;
}

/**
 * Social Share
 * */
function m_wedding_social_share_title(){
	$title = str_replace(' ', '%20', get_the_title());
	$title  = str_replace('{', '%7B', $title);
	$title = str_replace('}', '%7D', $title);
	return strip_tags($title);
}

function m_wedding_social_shares(){
	
	$social = m_wedding_get_options('blog_social', 
			array(
					array(
							'title' => 'Facebook',
							'icons' => 'fa-facebook',
					),
					array(
							'title' => 'Twitter',
							'icons' => 'fa-twitter',
					),
					array(
							'title' => 'Google',
							'icons' => 'fa-google-plus',
					)
			)
	);

	if ( isset($social) && is_array($social) ) {
		
		$currentUrl = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		if( !empty($_SERVER['HTTPS']) ){
			$currentUrl = "https://" . $currentUrl;
		}else{
			$currentUrl = "http://" . $currentUrl;
		}
	
		echo '<div class="social-shares">';
		echo '<ul>';
		
		foreach ($social as $sl) {
			if( $sl['icons'] == 'fa-facebook' ){
			?>
				<li>
					<a href="http://www.facebook.com/share.php?u=<?php echo $currentUrl;?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-twitter' ){		
				?>
				<li>
					<a href="http://twitter.com/share?url=<?php echo $currentUrl;?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-stumbleupon' ){		
				?>
				<li>
					<a href="http://www.stumbleupon.com/submit?url=<?php echo $currentUrl;?>&#038;title=<?php echo m_wedding_social_share_title();?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-linkedin' ){		
				?>
				<li>
					<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $currentUrl;?>&#038;title=<?php echo m_wedding_social_share_title(); ?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			
			if( $sl['icons'] == 'fa-google-plus' ){		
				?>
				<li>		
					<a href="https://plus.google.com/share?url=<?php echo $currentUrl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>					
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-pinterest'){	
					$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'full' );
				?>
				<li>
					<a href="http://pinterest.com/pin/create/button/?url=<?php echo $currentUrl;?>&media=<?php echo $thumbnail[0]; ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>	
				</li>
				<?php
			}		
		}
		
		echo '</ul>';
		echo '</div>';
	}
}

/**
 * Custom Comment
 * @param unknown $comment
 * @param unknown $args
 * @param unknown $depth
 */
function m_wedding_comment($comment, $args, $depth) {
	$GLOBALS ['comment'] = $comment;
	extract ( $args, EXTR_SKIP );

	if ('div' == $args ['style']) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
			<article class="comment-body">
				<div class="comment-avatar">
					<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
				<div class="comment-main">
					<h5 class="title"><?php echo get_comment_author_link(); ?></h5>
					<div class="comment-date">Posted: <?php echo get_comment_date(); ?>, <?php echo get_comment_date(get_option('time_format')); ?></div>
					<div class="comment-content">
						<?php comment_text(); ?>
					</div>
					<div class="comment-reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				</div>
			</article>
<?php
}

/**
 * Custom typography fields
 * */
add_filter( 'ot_recognized_typography_fields', 'm_wedding_ot_recognized_typography_fields', 1, 2);
function m_wedding_ot_recognized_typography_fields( $default, $field_id ) {

	if ( $field_id == 'typography_heading' )
		return array(
				'font-family',
				'font-style',
				'font-weight'
		);

		return $default;
}

/**
 * Display navigation to next/previous set of posts when applicable.
 * */
 function m_wedding_pagination() {
 	
 	global $wp_query;
 	
 	if ( $wp_query->max_num_pages <= 1 ) {
 		return;
 	}
 	
 	$args = array();
 	
 	if ( function_exists('is_woocommerce') && is_woocommerce() ) {
 		$args = array(
					'base'         	=> esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
	 				'prev_text'		=> __( 'Previous', 'mTheme' ),
	 				'next_text'		=> __( 'Next', 'mTheme' ),
 					'type'         	=> 'list',
				);
 		
 	} else {
 		$args = array(
		 			'prev_text'		=> __( 'Previous', 'mTheme' ),
					'next_text'		=> __( 'Next', 'mTheme' ),
		 			'type'         	=> 'list',
 				);
 	}
 	?>
 	<nav class="navigation paging-navigation" role="navigation">
 		<div class="pagination loop-pagination">
 		<?php
 			echo paginate_links( $args );
 		?>
 		</div>
 	</nav>
 	<?php 
 }