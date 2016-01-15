<?php
/**
 * Initialize the custom Theme Options.
 */
add_action ( 'init', 'm_wedding_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return void
 * @since 2.3.0
 */
function m_wedding_options() {
	
	/* OptionTree is not loaded yet, or this is not an admin request */
	if (! function_exists ( 'ot_settings_id' ) || ! is_admin ())
		return false;
	
	/**
	 * Get a copy of the saved settings array.
	 */
	$saved_settings = get_option ( ot_settings_id (), array () );
	
	/**
	 * Custom settings array that will eventually be
	 * passes to the OptionTree Settings API Class.
	 */
	$custom_settings = array (
			
			'sections' => array (
					array (
							'id' => 'general',
							'title' => __ ( 'General', 'mTheme' )
					),
					array (
							'id' => 'header',
							'title' => __ ( 'Header', 'mTheme' )
					),
					array (
							'id' => 'shop',
							'title' => __ ( 'Shop', 'mTheme' )
					),
					array (
							'id' => 'blog',
							'title' => __ ( 'Blog', 'mTheme' )
					),
					array (
							'id' => 'footer',
							'title' => __ ( 'Footer', 'mTheme' )
					),
					array (
							'id' => 'typography',
							'title' => __ ( 'Typography', 'mTheme' )
					),
			),
			'settings' => array (
					
					/**
					 * General
					 */ 
					array (
							'id' => 'logo',
							'label' => __ ( 'Logo', 'mTheme' ),
							'desc' => __ ( 'Select an image file for your logo.', 'mTheme' ),
							'std' => trailingslashit(get_template_directory_uri()) . 'assets/imgs/logo.png',
							'type' => 'upload',
							'section' => 'general',
					),
					/*
					array(
							'id'          => 'main_styles',
							'label'       => __( 'Select a style for Theme ', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'std'         => 'style-v1',
							'type'        => 'select',
							'section'     => 'general',
							'choices'     => array(
									array(
											'value'       => '',
											'label'       => __( '-- Choose One --', 'mTheme' ),
									),
									array(
											'value'       => 'style-v1',
											'label'       => __( 'Style v1', 'mTheme' ),
									),
									array(
											'value'       => 'style-v2',
											'label'       => __( 'Style v2', 'mTheme' ),
									),
							)
					),*/
					array(
							'id'          => 'main_layout',
							'label'          => 'Layout',
							'desc'        => __( 'Select a layout for your theme', 'mTheme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/full-width.png'
									),
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/right-sidebar.png'
									)
							),
							'section' => 'general'
					),
					array(
							'id'          => 'main_sidebar',
							'label'          => 'Sidebar Select',
							'type'        => 'sidebar-select',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_width',
							'label'       => __( 'Sidebar Width', 'mTheme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'mTheme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'mTheme' ),
							'type'        => 'text',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_boxed',
							'label'          => 'Boxed',
							'desc'        => __( 'Check this box to use Boxed. If left unchecked then full width is used.', 'mTheme' ),
							'type'        => 'on-off',
							'std'			=> 'off',
							'section' => 'general'
					),
					array(
							'id'          => 'background_body',
							'label'       => __( 'Background for Body', 'mTheme' ),
							'desc'        => __ ( 'Background used for the Body', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					),
					array(
							'id'          => 'background_boxed',
							'label'       => __( 'Background for Boxed', 'mTheme' ),
							'desc'        => __ ( 'Background used for the Boxed', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
							'condition'   => 'main_boxed:is(on)',
					),
					array(
							'id'          => 'background_main',
							'label'       => __( 'Background for Main Content', 'mTheme' ),
							'desc'        => __ ( 'Background used for the Main Content', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					),
					array(
							'id'          => 'main_container',
							'label'          => 'Containers',
							'desc'        => __( 'Use <code>.container-fluid</code> for a full width container, spanning the entire width of your viewport. If left unchecked then use <code>.container</code> for a responsive fixed width container.', 'mTheme' ),
							'type'        => 'on-off',
							'std'			=> 'off',
							'section' => 'general'
					),
					array (
							'label' => __ ( 'Add Sidebar', 'mTheme' ),
							'id' => 'sidebar',
							'type' => 'list-item',
							'desc' => '',
							'settings' => array (
									array (
											'label' => 'Sidebar Name',
											'id' => 'name',
											'type' => 'text',
											'desc' => '',
									)
							),
							'std' => '',
							'section' => 'general'
					),
					array(
					        'id'          => 'custom_css',
					        'label'       => __( 'Custom CSS', 'mTheme' ),
							'desc'        => __( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', 'mTheme' ),
					        'std'         => '',
					        'type'        => 'css',
							'rows'        => '20',
					        'section'     => 'general',
					),//End General
					
					
					/**
					 * Header 
					 */
					array(
							'id'          => 'background_header',
							'label'       => __( 'Background for Header', 'mTheme' ),
							'desc'        => __ ( 'Background used for Page Header', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
							'id'          => 'header_styles',
							'label'       => __( 'Select a style for Header', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'std'         => 'style-v1',
							'type'        => 'select',
							'section'     => 'header',
							'choices'     => array(
									array(
											'value'       => '',
											'label'       => __( '-- Choose One --', 'mTheme' ),
									),
									array(
											'value'       => 'style-v1',
											'label'       => __( 'Style v1', 'mTheme' ),
									),
									array(
											'value'       => 'style-v2',
											'label'       => __( 'Style v2', 'mTheme' ),
									),
									array(
											'value'       => 'style-v3',
											'label'       => __( 'Style v3', 'mTheme' ),
									),
									array(
											'value'       => 'style-v4',
											'label'       => __( 'Style v4', 'mTheme' ),
									),
									array(
											'value'       => 'style-v5',
											'label'       => __( 'Style v5', 'mTheme' ),
									),
									array(
											'value'       => 'style-v6',
											'label'       => __( 'Style v6', 'mTheme' ),
									),
									array(
											'value'       => 'style-v7',
											'label'       => __( 'Style v7', 'mTheme' ),
									),
							)
					),
					array(
							'id'          => 'background_header_top',
							'label'       => __( 'Background for Header Top', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
							'id'          => 'header_top_sidebar',
							'label'       => __( 'Add Sidebar for Header Top', 'mTheme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'mTheme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'mTheme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'mTheme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
											'type'        => 'text',
									)
							)
					),
					array(
							'id'          => 'background_header_middle',
							'label'       => __( 'Background for Header Middle', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
							'id'          => 'header_middle_sidebar',
							'label'       => __( 'Add Sidebar for Header Middle', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'mTheme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'mTheme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'mTheme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
											'type'        => 'text',
									)
							)
					),
					array(
							'id'          => 'background_header_bottom',
							'label'       => __( 'Background for Header Bottom', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
							'id'          => 'header_bottom_sidebar',
							'label'       => __( 'Add Sidebar for Header Bottom', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'mTheme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'mTheme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'mTheme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
											'type'        => 'text',
									)
							)
					),
					// End Header
					
					
					/**
					 * Shop
					 */
					array(
							'id'          => 'shop_background_title',
							'label'       => __( 'Background for Title', 'mTheme' ),
							'desc'        => __ ( 'Background used for Title', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'shop',
					),
					/*
					array(
							'id'          => 'shop_sidebar_top',
							'label'       => __( 'Sidebar for Top Content', 'mTheme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'section'     => 'shop',
					),*/
					
					array(
							'id'          => 'shop_layout',
							'label'          => 'Shop Layout',
							'desc'        => __( '', 'mTheme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
									),
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => OT_URL . '/assets/images/layout/full-width.png'
									),
							),
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_sidebar',
							'label'       => __( 'Sidebar Select', 'mTheme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_sidebar_width',
							'label'       => __( 'Sidebar Width', 'mTheme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'mTheme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
							'type'        => 'text',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_items',
							'label'       => __( 'Per page', 'mTheme' ),
							'desc'        => __( 'The "per_page" shortcode determines how many products to show on the page.', 'mTheme' ),
							'std'         => '12',
							'type'        => 'text',
							'section'     => 'shop',
					),
					/*
					array(
							'id'          => 'shop_columns',
							'label'       => __( 'Columns', 'mTheme' ),
							'desc'        => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'mTheme' ),
							'std'         => '4',
							'type'        => 'text',
							'section'     => 'shop',
					),*/
					array(
							'id'          => 'shop_single_layout',
							'label'          => 'Single Layout',
							'desc'        => __( '', 'mTheme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
									),
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => OT_URL . '/assets/images/layout/full-width.png'
									),
							),
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_single_sidebar',
							'label'       => __( 'Single Sidebar Select', 'mTheme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_single_sidebar_width',
							'label'       => __( 'Single Sidebar Width', 'mTheme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_single_sidebar_el_class',
							'label'       => __( 'Single Extra class name for Sidebar', 'mTheme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
							'type'        => 'text',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					// End Shop
					
					
					/**
					 * Blog
					 */
					array(
							'id'          => 'blog_background_title',
							'label'       => __( 'Background for Title', 'mTheme' ),
							'desc'        => __ ( 'Background used for Title', 'mTheme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'blog',
					),
					array(
							'id'          => 'blog_layout',
							'label'          => 'Blog Layout',
							'desc'        => __( '', 'mTheme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
									),
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => OT_URL . '/assets/images/layout/full-width.png'
									),
							),
							'section' => 'blog'
					),
					array(
							'id'          => 'blog_sidebar',
							'label'       => __( 'Sidebar Select', 'mTheme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					array(
							'id'          => 'blog_sidebar_width',
							'label'       => __( 'Sidebar Width', 'mTheme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					array(
							'id'          => 'blog_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'mTheme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
							'type'        => 'text',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					// End Blog
					
					/**
					 * Footer 
					 */
					array(
							'id'          => 'background_footer',
							'label'       => __( 'Background for Footer', 'mTheme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
							'id'          => 'background_footer_top',
							'label'       => __( 'Background for Footer Top', 'mTheme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
							'id'          => 'sidebar_footer_top',
							'label'       => __( 'Add Sidebar for Footer Top', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'type'        => 'list-item',
							'section'     => 'footer',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'mTheme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'mTheme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'mTheme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
											'type'        => 'text',
									)
							)
					),
					array(
							'id'          => 'background_footer_middle',
							'label'       => __( 'Background for Footer Middle', 'mTheme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
							'id'          => 'sidebar_footer',
							'label'       => __( 'Add Sidebar for Footer Middle', 'mTheme' ),
							'desc'        => __( '', 'mTheme' ),
							'type'        => 'list-item',
							'section'     => 'footer',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'mTheme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'mTheme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'mTheme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'mTheme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'mTheme' ),
											'type'        => 'text',
									)
							)
					),
					array (
							'id' => 'copyright',
							'label' => __ ( 'Copyright', 'mTheme' ),
							'desc' => __ ( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'mTheme' ),
							'type' => 'textarea',
							'section' => 'footer',
							'rows' => '10',
					),
					/* End Footer */
					
					/**
					 * Typography
					 */
					array (
							'id' => 'google_fonts',
							'label' => __ ( 'Google Fonts', 'mTheme' ),
							'desc' => sprintf ( __ ( 'The Google Fonts option type will dynamically enqueue any number of Google Web Fonts into the document %1$s. As well, once the option has been saved each font family will automatically be inserted into the %2$s array for the Typography option type. You can further modify the font stack by using the %3$s filter, which is passed the %4$s, %5$s, and %6$s parameters. The %6$s parameter is being passed from %7$s, so it will be the ID of a Typography option type. This will allow you to add additional web safe fonts to individual font families on an as-need basis.', 'mTheme' ), '<code>HEAD</code>', '<code>font-family</code>', '<code>ot_google_font_stack</code>', '<code>$font_stack</code>', '<code>$family</code>', '<code>$field_id</code>', '<code>ot_recognized_font_families</code>' ),
							'std' => '',
							'type' => 'google-fonts',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'typography_body',
							'label' => __ ( 'Typography Body', 'mTheme' ),
							'desc' => __ ( 'These options will be added to <code>body</code>', 'mTheme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'typography_heading',
							'label' => __ ( 'Typography Heading', 'mTheme' ),
							'desc' => __ ( 'These options will be added to <code>H1, H2, H3, H4, H5, H6</code>', 'mTheme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'featured_color',
							'label' => __ ( 'Featured Color', 'mTheme' ),
							'desc' => __ ( 'Choose featured color for the theme.', 'mTheme' ),
							'std' => '',
							'type' => 'colorpicker',
							'section' => 'typography',
							'operator' => 'and'
					)
					/* End Typography */
			) 
	);
	
	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters ( ot_settings_id () . '_args', $custom_settings );
	
	/* settings are not the same update the DB */
	if ($saved_settings !== $custom_settings) {
		update_option ( ot_settings_id (), $custom_settings );
	}
	
	/* Lets OptionTree know the UI Builder is being overridden */
	global $ot_has_customTheme_options;
	$ot_has_customTheme_options = true;
}