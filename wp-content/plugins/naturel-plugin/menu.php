<?php


add_filter( 'wp_edit_nav_menu_walker', 'mTheme_menu_item', 99 );
function mTheme_menu_item( $walker ) {
	$walker = 'mTheme_Menu_Item';
	
	if ( ! class_exists( $walker ) ) {
		require_once dirname( __FILE__ ) . '/inc/menu-item.php';
	}

	return $walker;
}


/**
 * Custom Fields
 * */
class mTheme_Menu_Item_Fields {
	
	/**
	 * Holds our custom fields
	 *
	 * @var array
	 * @access protected
	 */
	protected static $fields = array ();
	
	/**
	 * Initialize plugin
	 */
	public static function init() {
		add_action ( 'mTheme_menu_item_fields', array ( __CLASS__, '_fields' ), 10, 4 );
		add_action ( 'wp_update_nav_menu_item', array ( __CLASS__, '_save' ), 10, 3 );
		add_filter ( 'manage_nav-menus_columns', array ( __CLASS__, '_columns' ), 99 );
		
		self::$fields = array (
				'icon'				=> __ ( "Font Awesome Icon Class", 'mTheme' ),
				'nolink'			=> __ ( "Don't link", 'mTheme' ),
				'hidelink'				=> __ ( "Don't show a link", 'mTheme' ),
				'menu_type' 		=> __ ( 'Menu Type', 'mTheme' ),
				'menu_position' 	=> __ ( 'Mega Position', 'mTheme' ),
				'mega_width' 		=> __ ( 'Mega Width (only Mega)', 'mTheme' ),
				'cols' 				=> __ ( 'Width (only Mega full width)', 'mTheme' ),
				'mega_bg_image' 	=> __ ( 'Background Image (only Mega)', 'mTheme' ),
				'mega_style' 		=> __ ( 'Custom Styles (only Mega)', 'mTheme' ),
				//'tip_label' 		=> __ ( 'Tip Label', 'mTheme' ),
				//'tip_color' 		=> __ ( 'Tip Text Color', 'mTheme' ),
				//'tip_bg' 			=> __ ( 'Tip BG Color', 'mTheme' ),
		);
		
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array ( __CLASS__, 'add_custom_nav_fields') );
	}
	
	public static function add_custom_nav_fields( $menu_item ) {
		
		if ( is_array(self::$fields) ) {
			foreach ( self::$fields as $_key => $label ) {
				
				$key = sprintf ( 'menu-item-%s', $_key );
				$value = get_post_meta ( $menu_item->ID, $key, true );
				
				$menu_item->$_key = $value;
			}
		}
		
	    return $menu_item;
	}
	
	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int $menu_id
	 *        	Nav menu ID
	 * @param int $menu_item_db_id
	 *        	Menu item ID
	 * @param array $menu_item_args
	 *        	Menu item data
	 */
	public static function _save($menu_id, $menu_item_db_id, $menu_item_args) {
		if (defined ( 'DOING_AJAX' ) && DOING_AJAX) {
			return;
		}
		
		check_admin_referer ( 'update-nav_menu', 'update-nav-menu-nonce' );
		
		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf ( 'menu-item-%s', $_key );
			
			// Sanitize
			if (! empty ( $_POST [$key] [$menu_item_db_id] )) {
				// Do some checks here...
				$value = $_POST [$key] [$menu_item_db_id];
			} else {
				$value = null;
			}
			
			// Update
			if (! is_null ( $value )) {
				update_post_meta ( $menu_item_db_id, $key, $value );
			} else {
				delete_post_meta ( $menu_item_db_id, $key );
			}
		}
	}
	
	/**
	 * Print field
	 *
	 * @param object $item
	 *        	Menu item data object.
	 * @param int $depth
	 *        	Depth of menu item. Used for padding.
	 * @param array $args
	 *        	Menu item args.
	 * @param int $id
	 *        	Nav menu ID.
	 *        	
	 * @return string Form fields
	 */
	public static function _fields($id, $item, $depth, $args) {
		foreach ( self::$fields as $_key => $label ) :
			$key = sprintf ( 'menu-item-%s', $_key );
			$id = sprintf ( 'edit-%s-%s', $key, $item->ID );
			$name = sprintf ( '%s[%s]', $key, $item->ID );
			$value = get_post_meta ( $item->ID, $key, true );
			$class = sprintf ( 'field-%s', $_key );
			?>
			
			<?php if ( $_key == 'icon' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					) ?>
		        
		        <?php printf(
						'<input type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s" value="%4$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
		            <span><?php echo __('Input font awesome icon or icon class. You can see <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome Icons in here</a>.', 'mTheme') ?></span>
		        </label>
		    </p>
		    
    		<?php } elseif ( $_key == 'nolink' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">',
						esc_attr( $id )
					) ?>
		        
		        <?php printf(
						'<input type="checkbox" id="%1$s" class="code %1$s" name="%3$s" data-name="%3$s" value="nolink"',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					); 
					checked( $value, 'nolink' );
					echo '/> ' . esc_html( $label );  ?>
		        </label>
		    </p>
		    
    		<?php } elseif ( $_key == 'hidelink' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">',
						esc_attr( $id )
					) ?>
		        
		        <?php printf(
						'<input type="checkbox" id="%1$s" class="code %1$s" name="%3$s" data-name="%3$s" value="hide"',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					); 
					checked( $value, 'hide' );
					echo '/> ' . esc_html( $label );  ?>
		        </label>
		    </p>
		    
    		<?php } elseif ( $_key == 'menu_type' ) { ?>
			<p class="description description-thin <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 0 ? 'display:block;' : 'display:none;'; ?>">
				<?php 
				printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					);
		        
		        printf(
						'<select id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					); 
		        
		        $options = array();
		        $options['normal'] = 'Normal';
		        $options['mega'] = 'Mega';
		        
		        foreach ( $options as $k => $v ) {
		        	printf(
		        			'<option value="%1$s" %2$s>%3$s</option>',
		        			esc_attr( $k ),
		        			selected($value, $k, false),
		        			esc_attr( $v )
		        	);
		        }
		        ?> 
		        </select></label>
		    </p>
		    
    		<?php } elseif ( $_key == 'menu_position' ) { ?>
			<p class="description description-thin <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 0 ? 'display:block;' : 'display:none;'; ?>">
				<?php 
				printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					);
		        
		        printf(
						'<select id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					);
		        
		        $options = array();
		        $options['pos-right'] = 'Right';
		        $options['pos-left'] = 'Left';
		        $options['pos-center'] = 'Center (only Mega)';
		        
		        foreach ( $options as $k => $v ) {
		        	printf(
		        			'<option value="%1$s" %2$s>%3$s</option>',
		        			esc_attr( $k ),
		        			selected($value, $k, false),
		        			esc_attr( $v )
		        	);
		        }
		        ?>
		        </select></label>
		    </p>
		    
		    <?php } elseif ( $_key == 'mega_width' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 0 ? 'display:block;' : 'display:none;'; ?>">
				<?php 
				printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					);
		        
		        printf(
						'<select id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					);
		        
		        $options = array();
		        $options['normal'] = 'Normal';
		        $options['fullwidth'] = 'Full Width';
		        
		        foreach ( $options as $k => $v ) {
		        	printf(
		        			'<option value="%1$s" %2$s>%3$s</option>',
		        			esc_attr( $k ),
		        			selected($value, $k, false),
		        			esc_attr( $v )
		        	);
		        }
		        ?>
		        </select></label>
		    </p>
		    
		    
    		<?php } else if ( $_key == 'cols' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 1 ? 'display:block;' : 'display:none;'; ?>">
				<?php 
				printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					); 
		        
				if ( !isset($value) || empty($value) ) {
					$value = 'col-sm-3';
				}
				
				printf(
						'<select id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					); 
				
				$options = array();
				$options['col-sm-1'] = '1 Column 1/12';
				$options['col-sm-2'] = '2 Columns 2/12';
				$options['col-sm-3'] = '3 Columns 3/12';
				$options['col-sm-4'] = '4 Columns 4/12';
				$options['col-sm-5'] = '5 Columns 5/12';
				$options['col-sm-6'] = '6 Columns 6/12';
				$options['col-sm-7'] = '7 Columns 7/12';
				$options['col-sm-8'] = '8 Columns 8/12';
				$options['col-sm-9'] = '9 Columns 9/12';
				$options['col-sm-10'] = '10 Columns 10/12';
				$options['col-sm-11'] = '11 Columns 11/12';
				$options['col-sm-12'] = '12 Columns 12/12';
				
				foreach ( $options as $k => $v ) {
					printf(
							'<option value="%1$s" %2$s>%3$s</option>',
							esc_attr( $k ), 
							selected($value, $k, false),
							esc_attr( $v )
					);
				}
				?>
		        </select></label>
		    </p>
		    
		    <?php } else if ( $_key == 'mega_bg_image' ) { ?>
		    <div class="description description-wide <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 0 || $depth == 1 ? 'display:block;' : 'display:none;'; ?>">
			    <p class="description" >
					<?php printf(
							'<label for="%1$s">%2$s<br />',
							esc_attr( $id ),
							esc_html( $label )
						) ?>
			        
			        <?php printf(
							'<input type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s" value="%4$s"/>',
							esc_attr( $id ),
							esc_html( $label ),
							esc_attr( $name ),
							esc_attr( $value )
						) ?>
			        </label>
			    </p>
			    <p class="description">
		   			<?php printf(
						'<input class="button_upload_image button" data-id="%1$s" type="button" value="Upload Image" />&nbsp;',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
					
					<?php printf(
						'<input class="button_remove_image button" data-id="%1$s" type="button" value="Remove Image" />',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
			    </p>
		    </div>
    		<?php } else if ( $_key == 'mega_style' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>" style="<?php echo $depth == 0 || $depth == 1 ? 'display:block;' : 'display:none;'; ?>">
				<?php printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					) ?>
		        
		        <?php printf(
						'<textarea type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s"/>%4$s</textarea>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
		        </label>
		    </p>
		    
		    <?php } else if ( $_key == 'tip_label' ) { ?>
			<p class="description description-thin <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					) ?>
		        
		        <?php printf(
						'<input type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s" value="%4$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
		        </label>
		    </p>
		    
		    <?php } else if ( $_key == 'tip_color' ) { ?>
			<p class="description description-thin <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					) ?>
		        
		        <?php printf(
						'<input type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s" value="%4$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
		        </label>
		    </p>
		    
		    <?php } elseif ( $_key == 'tip_bg' ) { ?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>">
				<?php printf(
						'<label for="%1$s">%2$s<br />',
						esc_attr( $id ),
						esc_html( $label )
					) ?>
		        
		        <?php printf(
						'<input type="text" id="%1$s" class="widefat code %1$s" name="%3$s" data-name="%3$s" value="%4$s"/>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
		        </label>
		    </p>
		    
		    <?php } ?>
		    
<?php
		endforeach
		;
	}
	
	/**
	 * Add our fields to the screen options toggle
	 *
	 * @param array $columns
	 *        	Menu item columns
	 * @return array
	 */
	public static function _columns($columns) {
		$columns = array_merge ( $columns, self::$fields );
		
		return $columns;
	}
}
mTheme_Menu_Item_Fields::init ();


/* Top Navigation Menu */
if (!class_exists('mTheme_nav_walker')) {
	class mTheme_nav_walker extends Walker_Nav_Menu {

		// add classes to ul sub menus
		public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add popup class to ul sub-menus
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$out_div = '';
			
			
			if ( $depth == 0 ) {
				
				$classes = "sub-menu-wrap";
				$classes_parent = "";
				$classes_parent .= " ". $args->menu_position;
				if ( $args->menu_type == 'mega' ) {
					
					$mega_style = array();
					$mega_style[] = isset($args->mega_style) ? $args->mega_style : '';
					$mega_style[] = $args->mega_bg_image ? 'background-image:url('.str_replace(array('http://', 'https://'), array('//', '//'), $args->mega_bg_image).');' : '';
						
					$mega_style = join(" ", $mega_style);
					
					$classes_parent .= $args->mega_width != 'normal' ? " full-width container" : " width-normal";
					
					$out_div = '<div class="mega-menu-wrap'. $classes_parent .'"><div class="'. $classes .'" style="'. $mega_style .'">';
					
				} else {
					$out_div = '<div class="dropdown-menu-wrap'. $classes_parent .'"><div class="'. $classes .'">';
				}
				
			} 
			
			$output .= "\n$indent$out_div<ul class=\"sub-menu\">\n";
		}

		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if ( $depth == 0 ) {
				$out_div = '</div></div>';
			} else {
				$out_div = '';
			}
			$output .= "$indent</ul>$out_div\n";
		}

		// add main/sub classes to li's and links
		public function start_el( &$output, $item, $depth = 0, $__args = array(), $id = 0 ) {
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			
			$args = new stdClass();
			if ( is_array($__args) ) {
				$args->has_children = $__args['has_children'];
				$args->before = $__args['before'];
				$args->after = $__args['after'];
				$args->link_before = $__args['link_before'];
				$args->link_after = $__args['link_after'];
				
				$item->title = $item->post_title;
				
			} else 
				$args = $__args;
			
			
			// Classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			if ( $depth == 0 && $args->has_children )
				$classes[] = 'has-sub';
			
			if ( $depth == 1 && $args->has_children )
				$classes[] = 'sub';
			
			if ( $item->current || $item->current_item_ancestor || $item->current_item_parent )
				$classes[] = 'active';
			
			
			// Build output
			if ($depth == 1) {
				
				$sub_mega_style = array();
				$menu_type_parent = get_post_meta($item->menu_item_parent, 'menu-item-menu_type', true);
				$menu_width_parent = get_post_meta($item->menu_item_parent, 'menu-item-mega_width', true);
				if ( $menu_type_parent == 'mega' ) {
					$sub_mega_style[] = isset($item->mega_style) ? $item->mega_style : '';
					$sub_mega_style[] = $item->mega_bg_image ? 'background-image:url('.str_replace(array('http://', 'https://'), array('//', '//'), $item->mega_bg_image).');' : '';
					
					if ( $menu_width_parent != 'normal' ) {
						$classes[] = $item->cols;
					}
				}
				
				$sub_mega_style = join(" ", $sub_mega_style);
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
				
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="'. $class_names .'" style="'. $sub_mega_style .'">';
			
			} else {
				
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
				
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="'. $class_names .'">';
			}
			// End output

			
			// Build item
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			if ( $item->hidelink == "" ) {
				
				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else{
					$item_output .= '<h4>';
				}
				
				$item_output .= $args->link_before;
				$item_output .= $item->icon ? '<i class="fa fa-' . str_replace('fa-', '', $item->icon) . '"></i>' : '';
				$item_output .= '<span>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
				$item_output .= $args->link_after;
				
				if ( $item->nolink == "" ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h4>';
				}
			}
			
			if ( ! empty( $item->description ) ) {
				$item_output .= '<div class="menu-item-description">'. do_shortcode($item->description) .'</div>';
			}
			
			$item_output .= $args->after;
			// End item
			
			
			if ($depth == 0) {
				$args->menu_type		= $item->menu_type;
				$args->menu_position	= $item->menu_position;
				$args->mega_width 		= $item->mega_width;
				$args->mega_bg_image 	= $item->mega_bg_image;
				$args->mega_style 		= $item->mega_style;
			}
			
			// Build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}