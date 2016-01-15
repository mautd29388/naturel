<?php
class mTheme_Post_Type {
	public function __construct() {
		
		add_action ( 'init', array ( $this, 'mTheme_post_type_menus' ) );
		add_action ( 'init', array ( $this, 'mTheme_post_type_galleries' ) );
		add_action ( 'init', array ( $this, 'mTheme_post_type_testimonial' ) );
	}
	
	/**
	 * Menus
	 */
	public function mTheme_post_type_menus() {
		$labels = array (
				'name' => __ ( 'Member', 'mTheme' ),
				'singular_name' => __ ( 'Member', 'mTheme' ),
				'add_new' => __ ( 'Add New', 'mTheme' ),
				'add_new_item' => __ ( 'Add New', 'mTheme' ),
				'edit_item' => __ ( 'Edit', 'mTheme' ),
				'new_item' => __ ( 'New', 'mTheme' ),
				'view_item' => __ ( 'View', 'mTheme' ),
				'search_items' => __ ( 'Search', 'mTheme' ),
				'not_found' => __ ( 'No post found', 'mTheme' ),
				'not_found_in_trash' => __ ( 'No post found in Trash', 'mTheme' ),
				'parent_item_colon' => '',
				'menu_name' => _x ( 'Our Members', 'Admin menu name', 'mTheme' ) 
		);
		
		$args = array (
				'labels' => $labels,
				'public' => true,
				'exclude_from_search' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'query_var' => true,
				'rewrite' => array (
						'slug' => 'type-member' 
				),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => 'dashicons-groups',
				'supports' => array (
						'title',
						'editor',
						//'author',
						//'excerpt',
						'thumbnail',
						//'page-attributes'
				) 
		);
		
		register_post_type ( 'mmember', $args );

		// Initialize Category Taxonomy Labels
		$labels = array (
				'name' => __ ( 'Team', 'mTheme' ),
				'singular_name' => __ ( 'Team', 'mTheme' ),
				'search_items' => __ ( 'Search Types', 'mTheme' ),
				'all_items' => __ ( 'Our Teams', 'mTheme' ),
				'parent_item' => __ ( 'Parent Team', 'mTheme' ),
				'parent_item_colon' => __ ( 'Parent Team:', 'mTheme' ),
				'edit_item' => __ ( 'Edit Team', 'mTheme' ),
				'update_item' => __ ( 'Update Team', 'mTheme' ),
				'add_new_item' => __ ( 'Add New Team', 'mTheme' ),
				'new_item_name' => __ ( 'New Team Name', 'mTheme' ),
				'menu_name' => _x ( 'Our Teams', 'Admin menu name', 'mTheme' )
		);
		
		register_taxonomy ( 'mteams', array (
				'mmember'
		), array (
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'query_var' => true,
				'rewrite' => array (
						'slug' => 'our-teams'
				)
		) ); // End Category
		
		
	} // End Menus
	
	
	/**
	 * Galleries
	 */
	public function mTheme_post_type_galleries() {
		$labels = array (
				'name' => __ ( 'Gallery', 'mTheme' ),
				'singular_name' => __ ( 'Gallery', 'mTheme' ),
				'add_new' => __ ( 'Add New', 'mTheme' ),
				'add_new_item' => __ ( 'Add New', 'mTheme' ),
				'edit_item' => __ ( 'Edit', 'mTheme' ),
				'new_item' => __ ( 'New', 'mTheme' ),
				'view_item' => __ ( 'View', 'mTheme' ),
				'search_items' => __ ( 'Search', 'mTheme' ),
				'not_found' => __ ( 'No post found', 'mTheme' ),
				'not_found_in_trash' => __ ( 'No post found in Trash', 'mTheme' ),
				'parent_item_colon' => '',
				'menu_name' => _x ( 'Galleries', 'Admin menu name', 'mTheme' )
		);
	
		$args = array (
				'labels' => $labels,
				'public' => true,
				'exclude_from_search' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'query_var' => true,
				'rewrite' => array (
						'slug' => 'type-galleries'
				),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => 'dashicons-images-alt2',
				'supports' => array (
						'title',
						'editor',
						//'author',
						//'excerpt',
						'thumbnail'
				)
		);
	
		register_post_type ( 'mgallery', $args );
		
		// Initialize Category Taxonomy Labels
		$labels = array (
				'name' => __ ( 'Gallery Categories', 'mTheme' ),
				'singular_name' => __ ( 'Category', 'mTheme' ),
				'search_items' => __ ( 'Search Types', 'mTheme' ),
				'all_items' => __ ( 'All Categories', 'mTheme' ),
				'parent_item' => __ ( 'Parent Category', 'mTheme' ),
				'parent_item_colon' => __ ( 'Parent Category:', 'mTheme' ),
				'edit_item' => __ ( 'Edit Category', 'mTheme' ),
				'update_item' => __ ( 'Update Category', 'mTheme' ),
				'add_new_item' => __ ( 'Add New Category', 'mTheme' ),
				'new_item_name' => __ ( 'New Category Name', 'mTheme' ),
				'menu_name' => _x ( 'Categories', 'Admin menu name', 'mTheme' )
		);
		
		register_taxonomy ( 'mgallery_cat', array (
				'mgallery'
		), array (
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'query_var' => true,
				'rewrite' => array (
						'slug' => 'gallery-cat'
				)
		) ); // End Category
	
	} // End Galleries
	
	
	/**
	 * Testimonial
	 */
	public function mTheme_post_type_testimonial() {
		$labels = array (
				'name' => __ ( 'Testimonial', 'mTheme' ),
				'singular_name' => __ ( 'Testimonial', 'mTheme' ),
				'add_new' => __ ( 'Add New', 'mTheme' ),
				'add_new_item' => __ ( 'Add New', 'mTheme' ),
				'edit_item' => __ ( 'Edit', 'mTheme' ),
				'new_item' => __ ( 'New', 'mTheme' ),
				'view_item' => __ ( 'View', 'mTheme' ),
				'search_items' => __ ( 'Search', 'mTheme' ),
				'not_found' => __ ( 'No post found', 'mTheme' ),
				'not_found_in_trash' => __ ( 'No post found in Trash', 'mTheme' ),
				'parent_item_colon' => '',
				'menu_name' => _x ( 'Testimonial', 'Admin menu name', 'mTheme' )
		);
	
		$args = array (
				'labels' => $labels,
				'public' => true,
				'exclude_from_search' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'query_var' => true,
				'rewrite' => array (
						'slug' => 'type-testimonial'
				),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => 'dashicons-format-quote',
				'supports' => array (
						'title',
						'editor',
						//'author',
						//'excerpt',
						//'thumbnail'
				)
		);
	
		register_post_type ( 'mtestimonial', $args );
	
	} // End Testimonial
}

new mTheme_Post_Type ();