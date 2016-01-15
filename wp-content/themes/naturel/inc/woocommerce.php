<?php

/**
 * mTheme Add to Cart
 * */
add_action( 'mtheme_woocommerce_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
if ( class_exists('YITH_WCWL_Shortcode') ) {
	add_action( 'mtheme_woocommerce_add_to_wishlist', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 15 );
}
if ( class_exists('YITH_Woocompare_Frontend') ) {
	add_action( 'mtheme_woocommerce_add_to_compare', create_function( '', 'echo do_shortcode( "[yith_compare_button]" );' ), 15 );
}
if ( class_exists('YITH_WCQV_Frontend') ) {
	add_action( 'mtheme_woocommerce_add_quick_view', array( YITH_WCQV_Frontend, 'yith_add_quick_view_button' ), 15 );
}
if ( function_exists('toastie_wc_smsb_form_short_code') ) {
	add_action( 'mtheme_woocommerce_single_sharing', create_function( '', 'echo do_shortcode( "[woocommerce_social_media_share_buttons]" );' ), 15 );
}

/**
 * mTheme Add Rating and Price for Products
 * */
add_action( 'mtheme_woocommerce_rating', 'woocommerce_template_loop_rating', 10 );
add_action( 'mtheme_woocommerce_price', 'woocommerce_template_loop_price', 10 );

/**
 * mTheme hook single product
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */
add_action( 'mtheme_woocommerce_single_rating', 'woocommerce_template_single_rating', 10 );
add_action( 'mtheme_woocommerce_single_price', 'woocommerce_template_single_price', 10 );
add_action( 'mtheme_woocommerce_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
add_action( 'mtheme_woocommerce_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'mtheme_woocommerce_single_meta', 'woocommerce_template_single_meta', 40 );
add_action( 'mtheme_woocommerce_single_sharing', 'woocommerce_template_single_sharing', 50 );
 
/**
 * After Single Products Summary Div
 *
 * @see woocommerce_output_product_data_tabs()
 * @see woocommerce_upsell_display()
 * @see woocommerce_output_related_products()
 */
add_action( 'mtheme_woocommerce_after_single_product_data_tabs', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'mtheme_woocommerce_after_single_upsell_display', 'woocommerce_upsell_display', 15 );
add_action( 'mtheme_woocommerce_after_single_related_products', 'woocommerce_output_related_products', 20 );

// Show Ratings with $rating = 0;
add_filter('woocommerce_product_get_rating_html', 'm_wedding_woocommerce_product_get_rating_html', 20, 2);
function m_wedding_woocommerce_product_get_rating_html( $rating_html, $rating ) {
	
	if ( $rating > 0 ) {
		return $rating_html;
		
	}
	
	return '<div class="star-rating" title="' . __( 'No ratings', 'mTheme' ) . '"></div>';
}

/**
 * Define image sizes
 */
add_action( 'after_switch_theme', 'm_wedding_woocommerce_image_dimensions', 1 );
function m_wedding_woocommerce_image_dimensions() {
	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

	$catalog = array(
			'width' 	=> '400',	// px
			'height'	=> '500',	// px
			'crop'		=> 1 		// true
	);

	$single = array(
			'width' 	=> '600',	// px
			'height'	=> '750',	// px
			'crop'		=> 1 		// true
	);

	$thumbnail = array(
			'width' 	=> '180',	// px
			'height'	=> '200',	// px
			'crop'		=> 1 		// false 
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 				// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 				// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 			// Image gallery thumbs
	update_option( 'woocommerce_enable_myaccount_registration', 1 ); 	// Enable registration on the "My Account" page 
}

add_filter('loop_shop_per_page', 'm_wedding_loop_shop_per_page', 20);
function m_wedding_loop_shop_per_page( $posts_per_page ) {

	return m_wedding_get_options('shop_items', $posts_per_page);
}

add_filter('loop_shop_columns', 'm_wedding_loop_shop_columns', 10, 2);
function m_wedding_loop_shop_columns($columns){

	return m_wedding_get_options('shop_columns', '3');
}

add_filter('woocommerce_product_thumbnails_columns', 'm_wedding_woocommerce_product_thumbnails_columns', 10, 2);
function m_wedding_woocommerce_product_thumbnails_columns($columns){

	$columns = 4;
	
	return $columns;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'm_wedding_pagination', 20 );

add_filter('woocommerce_breadcrumb_defaults', 'm_wedding_woocommerce_breadcrumb_defaults', 10, 2);
function m_wedding_woocommerce_breadcrumb_defaults($breadcrumb){

	return array(
			'delimiter'   => '<i class="fa fa-angle-right"></i>',
			'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
			'wrap_after'  => '</nav>',
			'before'      => '',
			'after'       => '',
			'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' )
	);
}

add_filter('woocommerce_sale_flash', 'm_wedding_woocommerce_sale_flash', 10, 2);
function m_wedding_woocommerce_sale_flash() {
	echo '<span class="onsale">' . __( 'Sale', 'mTheme' ) . '</span>';
}

add_action( 'woocommerce_before_shop_loop', 'm_wedding_woocommerce_set_layout', 9 );
function m_wedding_woocommerce_set_layout() { 

	// Base Link decided by current page
	if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
		$link = home_url();
	} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
		$link = get_post_type_archive_link( 'product' );
	} else {
		$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
	}
	
	$args = $_GET;
	
	if ( isset($args['view']) )
		unset($args['view']);
	
	foreach ( $args as $k => $v ) {
		$link = add_query_arg( $k, $v, $link );
	}

	?>
	<div class="view-mode">
		<a data-view="grid" href="<?php echo esc_url(add_query_arg( 'view', 'grid', $link )); ?>" class="grid<?php echo !isset($_GET['view']) || (isset($_GET['view']) && $_GET['view'] == 'grid') ? ' active' : ''; ?>"><span>Grid</span><i class="fa fa-th"></i></a>
		<a data-view="list" href="<?php echo esc_url(add_query_arg( 'view', 'list', $link )); ?>" class="list<?php echo isset($_GET['view']) && $_GET['view'] == 'list' ? ' active' : ''; ?>"><span>List</span><i class="fa fa-th-list"></i></a>
	</div>
	<?php 
}

/**
 * Custom Link Filter
 * */
add_filter('woocommerce_layered_nav_link', 'm_wedding_woocommerce_layered_nav_link');
function m_wedding_woocommerce_layered_nav_link($link) {
	
	if ( isset($_GET['view']) ) {
		$link = add_query_arg( 'view', $_GET['view'], $link );
	}
	
	return $link;
}
// End Woocommerce


/* Mini Cart */
function m_wedding_minicart() {
	global $woocommerce;

	ob_start();
	if ( class_exists( 'WooCommerce' ) ) :
	$_cartQty = $woocommerce->cart->cart_contents_count;
	?>
        <div id="mini-cart" class="mTheme-mini-cart woocommerce">
            <div class="mini-cart-inner">
                <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="View contents of your shopping cart">
                    <!-- <i class="fa fa-shopping-cart"></i>-->
                    <i class="cart-icon icon-bag"></i>
                    <span class="cart-count"><?php echo $_cartQty > 0 ? $_cartQty : '0'; ?></span>
                    <span class="cart-title"><?php echo $_cartQty > 1 ? 'items' : 'item'; ?></span>
                </a>
                <?php //if ( $_cartQty > 0 ) { ?>
                <div class="dropdown-cart widget_shopping_cart hide_cart_widget_if_empty">
                    <div class="widget_shopping_cart_content">
                        <div class="cart-loading"></div>
                    </div>
                </div>
                <?php //} ?>
            </div>
        </div>
    <?php
    endif;

    return ob_get_clean();
}

add_filter('add_to_cart_fragments', 'm_wedding_woocommerce_header_add_to_cart_fragment');
function m_wedding_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $porto_settings;

	$_cartQty = WC()->cart->cart_contents_count;
	
	 $count = $_cartQty > 0 ? $_cartQty : '0';
	 $title = $_cartQty > 1 ? 'items' : 'item';
	
	$fragments['#mini-cart .cart-count'] = '<span class="cart-count">'. $count .'</span>';
	$fragments['#mini-cart .cart-title'] = '<span class="cart-title">'. $title .'</span>';

	return $fragments;
}


add_filter('get_product_search_form', 'm_wedding_get_product_search_form');
function m_wedding_get_product_search_form($form) {
ob_start();
?>
<div class="header-search"><a class="button-search" href="#" data-toggle="modal" data-target=".woocommerce-product-search-modal"><span>Search</span><i class="fa fa-search"></i></a></div>
<div class="modal woocommerce-product-search-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
			<button><i class="fa fa-search"></i></button>
			<!-- <input type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" />-->
			<input type="hidden" name="post_type" value="product" />
		</form>
	</div>
</div>
<?php 
	return ob_get_clean();
}