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
		
		$atts = shortcode_atts ( array (
				'title' 			=> '',
				'source' 			=> 'media_library',
				'images' 			=> '',
				'product_layout' 	=> '',
				'product_styles' 	=> '',
				'product_banner'	=> '',
				'product_banner_align' => 'center',
				'product_group'		=> 'products_categories',
				'product_cat_ids'	=> '',
				'product_ids'		=> '',
				'product_skus'		=> '',
				'product_orderby'	=> 'date',
				'product_order'		=> 'DESC',
				'after_content' 	=> '',
				'before_content' 	=> '',
				'max_items' 		=> '10',
				'img_size' 			=> 'thumbnail',
				'el_class' 			=> '',
				'css' 				=> '',
				'width' 			=> '1/3',
				'offset' 			=> ''
		), $atts );
	
		$layout = '';
		if ( $atts['source'] == 'product' ) {
			$layout = $atts['product_layout'];
		}
		
		ob_start();
						
		$template = self::mTheme_get_template_part ( 'content-' . $atts['source'], $layout );
		if ( file_exists("{$template}") ) {
			require "{$template}";
		}

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
		$order_by_values = array(
				__( 'Date', 'mTheme' ) => 'date',
				__( 'ID', 'mTheme' ) => 'ID',
				__( 'Author', 'mTheme' ) => 'author',
				__( 'Title', 'mTheme' ) => 'title',
				__( 'Modified', 'mTheme' ) => 'modified',
				__( 'Random', 'mTheme' ) => 'rand',
				__( 'Comment count', 'mTheme' ) => 'comment_count',
				__( 'Menu order', 'mTheme' ) => 'menu_order',
		);
		
		$order_way_values = array(
				__( 'Descending', 'mTheme' ) => 'DESC',
				__( 'Ascending', 'mTheme' ) => 'ASC',
		);
		
		$parems = array();
		$parems = array(
				
						array(
								'type' 			=> 'textfield',
								'heading' 		=> __( 'Widget title', 'mTheme' ),
								'param_name' 	=> 'title',
								'description' 	=> __( 'Enter text used as widget title (Note: located above content element).', 'mTheme' )
						),
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Image source', 'mTheme' ),
								'param_name' 	=> 'source',
								'value' 		=> array(
														__( 'Media library', 'mTheme' ) => 'media_library',
														__( 'Product', 'mTheme' ) 		=> 'product'
												),
								'std' 			=> 'media_library',
								'description' 	=> __( 'Select image source.', 'mTheme' )
						),
						array(
								'type'			=> 'attach_images',
								'heading' 		=> __( 'Images', 'mTheme' ),
								'param_name' 	=> 'images',
								'value' 		=> '',
								'description' 	=> __( 'Select images from media library.', 'mTheme' ),
								'dependency' 	=> array(
														'element' 	=> 'source',
														'value' 	=> 'media_library'
												),
						),
			
		);
		
		/**
		 * Product
		 * */
		 $parems = array_merge( $parems, 
				 		array(
				 				array(
				 						'type' 			=> 'dropdown',
				 						'heading' 		=> __( 'Layout', 'mTheme' ),
				 						'param_name' 	=> 'product_layout',
				 						'value' 		=> array(
								 								__( 'Default', 'mTheme' ) 	=> '',
								 								__( 'Carousel', 'mTheme' )	=> 'carousel',
								 						),
				 						'dependency' 	=> array(
								 								'element' 	=> 'source',
								 								'value' 	=> 'product'
								 						),
				 				),
				 				array(
				 						'type' 			=> 'dropdown',
				 						'heading' 		=> __( 'Styles', 'mTheme' ),
				 						'param_name' 	=> 'product_styles',
				 						'value' 		=> array(
								 								__( 'Style v1', 'mTheme' ) 	=> '',
								 								__( 'Style v2', 'mTheme' ) 	=> 'style-v2',
								 								__( 'Style v3', 'mTheme' ) 	=> 'style-v3',
								 						),
				 						'dependency' 	=> array(
								 								'element' 	=> 'source',
								 								'value' 	=> 'product'
								 						),
				 				),
						 		array(
						 				'type'			=> 'attach_images',
						 				'heading' 		=> __( 'Product Banner', 'mTheme' ),
						 				'param_name' 	=> 'product_banner',
						 				'value' 		=> '',
						 				'description' 	=> __( 'Select images from media library.', 'mTheme' ),
						 				'dependency' 	=> array(
										 						'element' 	=> 'product_styles',
										 						'value' 	=> 'style-v2'
										 				),
						 		),
				 				array(
				 						'type' 			=> 'dropdown',
				 						'heading' 		=> __( 'Product Banner alignment', 'mTheme' ),
				 						'param_name' 	=> 'product_banner_align',
				 						'value' 		=> array(
				 												__( 'Center', 'mTheme' ) => 'center',
								 								__( 'Left', 'mTheme' ) => 'left',
								 								__( 'Right', 'mTheme' ) => 'right'
								 						),
				 						'dependency' 	=> array(
								 								'element' 	=> 'product_styles',
										 						'value' 	=> 'style-v2'
								 						),
				 						'description' 	=> __( 'Select Product Banner alignment.', 'mTheme' )
				 				),
				 				array(
				 						'type' 				=> 'dropdown',
				 						'heading' 			=> __( 'Group Products', 'mTheme' ),
				 						'param_name' 		=> 'product_group',
				 						'description' 		=> __( '', 'mTheme' ),
				 						'value' 			=> array(
									 								__( 'Products Categories', 'mTheme' ) 	=> 'products_categories',
									 								__( 'Recent Products', 'mTheme' ) 		=> 'recent_products',
									 								__( 'Featured Products', 'mTheme' ) 	=> 'featured_products',
									 								__( 'Sale Products', 'mTheme' ) 		=> 'sale_products',
									 								__( 'Best Selling Products', 'mTheme' )	=> 'best_selling_products',
									 								__( 'Top Rated Products', 'mTheme' ) 	=> 'top_rated_products',
									 								__( 'Custom Products', 'mTheme' ) 		=> 'custom_products',
									 						),
				 						'dependency' 		=> array(
									 								'element' 	=> 'source',
									 								'value' 	=> 'product'
									 						),
				 				),
				 				array(
				 						'type' 				=> 'autocomplete',
				 						'heading' 			=> __( 'Categories', 'mTheme' ),
				 						'param_name' 		=> 'product_cat_ids',
				 						'dependency' 		=> array(
									 								'element'	=> 'product_group',
									 								'value' 	=> 'products_categories'
									 						),
				 						'settings' 			=> array(
									 								'multiple' => true,
									 								'sortable' => true,
									 						),
				 						'save_always' 		=> true,
				 						'description' 		=> __( 'List of product categories', 'mTheme' ),
				 				),
				 				array(
				 						'type' 				=> 'autocomplete',
				 						'heading' 			=> __( 'Products', 'mTheme' ),
				 						'param_name' 		=> 'product_ids',
				 						'dependency' 		=> array(
									 								'element'	=> 'product_group',
									 								'value' 	=> 'custom_products'
									 						),
				 						'settings' 			=> array(
									 								'multiple' => true,
									 								'sortable' => true,
									 								'unique_values' => true,
									 								// In UI show results except selected. NB! You should manually check values in backend
									 						),
				 						'save_always' 		=> true,
				 						'description' 		=> __( 'Enter List of Products', 'mTheme' ),
				 				),
				 				array(
				 						'type' 				=> 'hidden',
				 						'param_name' 		=> 'product_skus',
				 				),
				 				array(
				 						'type' 				=> 'dropdown',
				 						'heading' 			=> __( 'Order by', 'mTheme' ),
				 						'param_name' 		=> 'product_orderby',
				 						'value' 			=> $order_by_values,
				 						'dependency' 		=> array(
									 								'element'	=> 'product_group',
									 								'value' 	=> array('products_categories', 'recent_products', 'featured_products', 'sale_products', 'top_rated_products')
									 						),
				 						'save_always' 		=> true,
				 						'description'		=> sprintf( __( 'Select how to sort retrieved products. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				 				),
				 				array(
				 						'type' 				=> 'dropdown',
				 						'heading' 			=> __( 'Sort order', 'mTheme' ),
				 						'param_name' 		=> 'product_order',
				 						'value' 			=> $order_way_values,
				 						'dependency' 		=> array(
									 								'element'	=> 'product_group',
									 								'value' 	=> array('products_categories', 'recent_products', 'featured_products', 'sale_products', 'top_rated_products')
									 						),
				 						'save_always' 		=> true,
				 						'description' 		=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				 				)
				 		)
		 		);
		
		
		
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		//add_filter( 'vc_autocomplete_mTheme_posttypes_product_cat_ids_callback', array( 'Vc_Vendor_Woocommerce', 'productCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		//add_filter( 'vc_autocomplete_mTheme_posttypes_product_cat_ids_render', array( 'Vc_Vendor_Woocommerce', 'productCategoryCategoryRenderByIdExact', ), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		//add_filter( 'vc_autocomplete_mTheme_posttypes_product_ids_callback', array( 'Vc_Vendor_Woocommerce','productIdAutocompleteSuggester',), 10, 1 ); // Get suggestion(find). Must return an array
		//add_filter( 'vc_autocomplete_mTheme_posttypes_product_ids_render', array( 'Vc_Vendor_Woocommerce', 'productIdAutocompleteRender', ), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		//add_filter( 'vc_form_fields_render_field_mTheme_posttypes_product_ids_param_value', array( 'Vc_Vendor_Woocommerce', 'productsIdsDefaultValue', ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
		
		// End Product
		
		
		$parems[] = array(
							'type' 				=> 'textfield',
							'heading' 			=> __( 'Total items', 'mTheme' ),
							'param_name' 		=> 'max_items',
							'description' 		=> __( 'Set max limit for items in grid or enter -1 to display all.', 'mTheme' ),
							'dependency' 		=> array(
														'element' 	=> 'source',
														'value' 	=> array('product')
												),
							'std' 				=> '10',
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