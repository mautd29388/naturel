<?php
class mTheme_Shortcode {
	
	public static $int = 0;
	public function __construct() {
		
		// Define shortcodes
		$shortcodes = array (
				'mTheme_posttypes' => __CLASS__ . '::posttypes',
				'mTheme_maps' => __CLASS__ . '::maps',
		);
		
		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode ( apply_filters ( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
		
		add_filter ( 'the_content', array ( $this, 'shortcode_empty_paragraph_fix' ) );
		add_action ( 'vc_before_init', array ( $this, 'add_shortcodes_to_vc' ) );
		
		$plugin_dir_url = untrailingslashit ( plugin_dir_url ( __FILE__ ) );
	}
	
	public static function mTheme_get_template_part($slug, $name = '') {
		$template_path = untrailingslashit ( plugin_dir_path ( __FILE__ ) );
		
		$template = '';
		
		$name = ( string ) $name;
		if ('' !== $name) {
			$template = $template_path . "/contents/{$slug}-{$name}.php";
		} else
			$template = $template_path . "/contents/{$slug}.php";
		
		return $template;
	}
	
	public static function shortcode_empty_paragraph_fix($content) {
		$array = array (
				'<p>[' => '[',
				']</p>' => ']',
				']<br />' => ']' 
		);
		
		$content = strtr ( $content, $array );
		
		return $content;
	}
	
	public static function posttypes($atts, $contents){
	
		self::$int++;
		$int = self::$int;
	
		$post_types = get_post_types( array( 'public' => true) );
		$posttypes = array();
		foreach ( $post_types as $post_type ) {
				
			if ( 'attachment' !== $post_type ) {
				$posttypes[$post_type] = '';
			}
		}
		$atts = shortcode_atts ( array_merge(array (
				'title' => '',
				'styles' => 'carousel',
				'source' => 'media_library',
				'images' => '',
				'posttypes' => '',
				'order' => '',
				'orderby' => '',
				'after_content' => '',
				'before_content' => '',
				'max_items' => '10',
				'img_size' => 'thumbnail',
				'el_class' => '',
				'css' => '',
				'width' => '1/3',
				'offset' => ''
		), $posttypes), $atts );
	
		//wp_localize_script ( 'mtheme-plugin-main-js', 'mtheme_carousel_'. $int , $atts );
	
		ob_start();
	
		if ( ( $atts['source'] == 'media_library' && isset($atts['images']) && !empty($atts['images']) ) ||
				$atts['source'] == 'posttypes' && !empty($atts['posttypes']) ) {
						
			$template = self::mTheme_get_template_part ( 'content', $atts['styles'] );
			if ( file_exists("{$template}") ) {
				require "{$template}";
			}
		} else
			echo __ ( 'Not empty', 'mTheme' );

		return ob_get_clean ();
	}
	
	public static function maps($atts, $content = '') {
		$atts = shortcode_atts ( array (
				'LatLng' => '51.5042389, -0.1061977',
				'zoom' => 13,
				'icon' => trailingslashit( get_template_directory_uri () ) . 'assets/imgs/icon-map.png',
				'class_name' => '',
		), $atts );
		
		if ( !empty($content) )
			$content = '<p>Email: noreply@gmail.com<br>Phone: +800 - 568 - 8989<br>96 Isabella ST, London, SE 1 8DD</p>';
		
		wp_enqueue_script('google-maps-js');
		wp_enqueue_script('maps-js');
		
		$mtheme_maps = array();
		$mtheme_maps['LatLng'] = $atts['LatLng'];
		$mtheme_maps['desc_contact'] = $content;
		$mtheme_maps['zoom'] = $atts['zoom'];
		$mtheme_maps['icon'] = $atts['icon'];
		
		wp_localize_script ( 'maps-js', 'mtheme_maps', $mtheme_maps );
		
		ob_start();
		
		echo '<div class="maps '. $atts['class_name'] .'"><div id="map-canvas"></div></div>';
		
		return ob_get_clean ();
	}
	
	/**
	 * Add Shortcodes to Visual Composer
	 */
	public static function add_shortcodes_to_vc() {
		
		$vc_column_width_list = array(
				__( '1 column - 1/12', 'mTheme' ) => '1/12',
				__( '2 columns - 1/6', 'mTheme' ) => '1/6',
				__( '3 columns - 1/4', 'mTheme' ) => '1/4',
				__( '4 columns - 1/3', 'mTheme' ) => '1/3',
				__( '5 columns - 5/12', 'mTheme' ) => '5/12',
				__( '6 columns - 1/2', 'mTheme' ) => '1/2',
				__( '7 columns - 7/12', 'mTheme' ) => '7/12',
				__( '8 columns - 2/3', 'mTheme' ) => '2/3',
				__( '9 columns - 3/4', 'mTheme' ) => '3/4',
				__( '10 columns - 5/6', 'mTheme' ) => '5/6',
				__( '11 columns - 11/12', 'mTheme' ) => '11/12',
				__( '12 columns - 1/1', 'mTheme' ) => '1/1',
		);
		
		
		$parems = array();
		$parems = array(
				
						array(
								'type' => 'textfield',
								'heading' => __( 'Widget title', 'mTheme' ),
								'param_name' => 'title',
								'description' => __( 'Enter text used as widget title (Note: located above content element).', 'mTheme' )
						),
						array(
								'type' => 'dropdown',
								'heading' => __( 'Styles', 'mTheme' ),
								'param_name' => 'styles',
								'value' => array(
										__( 'Carousel', 'mTheme' ) => 'carousel',
										__( 'Gallery', 'mTheme' ) => 'gallery',
										__( 'Blog', 'mTheme' ) => 'blog',
								),
						),
						array(
								'type' => 'dropdown',
								'heading' => __( 'Image source', 'mTheme' ),
								'param_name' => 'source',
								'value' => array(
										__( 'Media library', 'mTheme' ) => 'media_library',
										__( 'Post types', 'mTheme' ) => 'posttypes'
								),
								'std' => 'media_library',
								'description' => __( 'Select image source.', 'mTheme' )
						),
						array(
								'type' => 'attach_images',
								'heading' => __( 'Images', 'mTheme' ),
								'param_name' => 'images',
								'value' => '',
								'description' => __( 'Select images from media library.', 'mTheme' ),
								'dependency' => array(
										'element' => 'source',
										'value' => 'media_library'
								),
						),
						array(
								'type' => 'posttypes',
								'heading' => __( 'Post types', 'mTheme' ),
								'param_name' => 'posttypes',
								'value' => '',
								'description' => __( 'Select post types.', 'mTheme' ),
								'dependency' => array(
										'element' => 'source',
										'value' => 'posttypes'
								),
						)
			
		);
		
		
		$post_types = get_post_types( array( 'public' => true) );
		foreach ( $post_types as $post_type ) {
			
			if ( 'attachment' !== $post_type ) {
				
				$posts = get_posts(array(
								'numberposts'	=> -1,
								'order'			=> 'ASC',
								'orderby'		=> 'title',
								'post_type'		=> $post_type
						));
				
				if ( count($posts) > 0 ) {
					$values = array();
					foreach ( $posts as $post ) {
						$values[$post->post_title] = $post->ID;
					}
				}
				
				$parems[] = array(
									'type' => 'checkbox',
									'heading' => __( 'Choose ' . $post_type, 'mTheme' ),
									'param_name' => $post_type,
									'description' => __( '', 'mTheme' ),
									'value' => $values,
									'dependency' => array(
											'element' => 'posttypes',
											'value' => $post_type
									),
							);
			}
		}
		
		$parems[] = array(
							'type' => 'dropdown',
							'heading' => __( 'Order', 'mTheme' ),
							'param_name' => 'order',
							'value' => array(
									__( 'ASC', 'mTheme' ) => 'ASC',
									__( 'DESC', 'mTheme' ) => 'DESC'
							),
							'description' => __( '', 'mTheme' ),
							'dependency' => array(
									'element' => 'source',
									'value' => 'posttypes'
							),
					);
		$parems[] = array(
							'type' => 'dropdown',
							'heading' => __( 'Orderby', 'mTheme' ),
							'param_name' => 'orderby',
							'value' => array(
									__( 'ID', 'mTheme' ) => 'ID',
									__( 'Title', 'mTheme' ) => 'title',
									__( 'Name', 'mTheme' ) => 'name',
									__( 'Date', 'mTheme' ) => 'date',
									__( 'Random', 'mTheme' ) => 'rand',
									__( 'Comment count', 'mTheme' ) => 'comment_count',
									__( 'Menu order', 'mTheme' ) => 'menu_order',
							),
							'description' => __( '', 'mTheme' ),
							'dependency' => array(
									'element' => 'source',
									'value' => 'posttypes'
							),
					);
		$parems[] = array(
							'type' => 'textfield',
							'heading' => __( 'Total items', 'mTheme' ),
							'param_name' => 'max_items',
							'description' => __( 'Set max limit for items in grid or enter -1 to display all.', 'mTheme' ),
							'dependency' => array(
									'element' => 'source',
									'value' => 'posttypes'
							),
							'std' => '10',
					);
		$parems[] = array(
							'type' => 'textfield',
							'heading' => __( 'Images size', 'mTheme' ),
							'param_name' => 'img_size',
							'value' => 'thumbnail',
							'description' => __( 'Enter image size (Example: "post-thumbnail", "thumbnail", "medium", "large", "full" or "shop_catalog_image_size", "shop_single_image_size", "shop_thumbnail_image_size" for Woocommerce or other sizes defined by theme). Leave parameter empty to use "thumbnail" by default.', 'mTheme' )
					);
		$parems[] = array(
							'type' => 'textarea',
							'heading' => __( 'Before Content', 'mTheme' ),
							'param_name' => 'before_content',
							'value' => '',
							'description' => __( 'Content is added before the Content', 'mTheme' )
					);
		$parems[] = array(
							'type' => 'textarea_html',
							'heading' => __( 'After Content', 'mTheme' ),
							'param_name' => 'content',
							'value' => '',
							'description' => __( 'Content is added after the Content', 'mTheme' )
					);
		$parems[] = array(
							'type' => 'textfield',
							'heading' => __( 'Extra class name', 'mTheme' ),
							'param_name' => 'el_class',
							'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'mTheme' )
					);
		$parems[] = array(
							'type' => 'css_editor',
							'heading' => __( 'CSS box', 'mTheme' ),
							'param_name' => 'css',
							'group' => __( 'Design Options', 'mTheme' )
					);
		$parems[] = array(
							'type' => 'dropdown',
							'heading' => __( 'Width', 'mTheme' ),
							'param_name' => 'width',
							'value' => $vc_column_width_list,
							'group' => __( 'Responsive Options', 'mTheme' ),
							'description' => __( 'Select column width.', 'mTheme' ),
							'std' => '1/3',
					);
		$parems[] = array(
							'type' => 'column_offset',
							'heading' => __( 'Responsiveness', 'mTheme' ),
							'param_name' => 'offset',
							'group' => __( 'Responsive Options', 'mTheme' ),
							'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'mTheme' ),
					);
		
		
		vc_map ( array (
				'name' => __ ( 'mTheme Posttypes', 'mTheme' ),
				'base' => 'mTheme_posttypes',
				'category' => __ ( 'mTheme', 'mTheme' ),
				'icon' => 'vc_element-icon icon-wpb-atm',
				'admin_enqueue_js' => array( untrailingslashit ( plugin_dir_url ( __FILE__ ) ) . '/assets/js/vc_extend.js'),
				"params" => $parems,
				'js_view' => 'mTheme_posttype',
		) );
		
		 vc_map ( array (
		 		'name' => __ ( 'mTheme Maps', 'mTheme' ),
		 		'base' => 'mTheme_maps',
		 		'category' => __ ( 'mTheme', 'mTheme' ),
		 		'icon' => 'vc_element-icon icon-wpb-map-pin',
		 		"params" => array (
		 				array (
		 						'type' => 'textfield',
		 						'heading' => __ ( 'Longitude and latitude of the map center', 'mTheme' ),
		 						'param_name' => 'LatLng',
		 						'value' => '51.5042389, -0.1061977'
		 				),
		 				array (
		 						'type' => 'textarea',
		 						'heading' => __ ( 'Locations Description', 'mTheme' ),
		 						'param_name' => 'content',
		 						'value' => '<p>Email: noreply@gmail.com<br>Phone: +800 - 568 - 8989<br>96 Isabella ST, London, SE 1 8DD</p>'
		 				),
		 				array (
		 						'type' => 'textfield',
		 						'heading' => __ ( 'Zoom', 'mTheme' ),
		 						'param_name' => 'zoom',
		 						'value' => '13'
		 				),
		 				array (
		 						'type' => 'textfield',
		 						'heading' => __ ( 'Icon', 'mTheme' ),
		 						'param_name' => 'icon',
		 				),
		 				array (
		 						'type' => 'textfield',
		 						'heading' => __ ( 'Extra class name', 'mTheme' ),
		 						'param_name' => 'class_name'
		 				)
		 		)
		 ) );
	}

}

new mTheme_Shortcode ();