<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$width = $css = '';
$width = wpb_translateColumnWidthToSpan( $atts['width'] );
$width = vc_column_offset_class_merge( $atts['offset'], $width );
$__width = array();
$__width = explode(' ', $width);
$parent_class = array();
$item_class = array();
if ( is_array($__width) ) {
	foreach ( $__width as $__class ) {
		if ( strpos($__class, 'hidden') > 0 ) {
			$parent_class[] = $__class;
		} else {
			$item_class[] = $__class;
		}
	}
	
	$width = implode($item_class, ' ');
}

$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
$parent_class[] = 'mtheme-post-type-' . $atts['styles'];
if ( !empty($atts['el_class']) ) {
	$parent_class[] = $atts['el_class'];
}

$css_classes = array(
		//'wpb_column',
		//'vc_column_container',
		$width
);
?>
<div class="mtheme-post-type <?php echo join($parent_class, ' '); ?>">
	<?php 
	if ( !empty($atts['title']) ) {
		echo wpb_widget_title( array( 'title' => $atts['title'], 'extraclass' => 'wpb_singleimage_heading' ) );
	} 
	if ( !empty($atts['before_content']) ) {
		echo '<div class="before-content">'. $atts['before_content'] .'</div>';
	}
	?>
	
	<div class="mtheme-post-type-inner">
		<?php 
		if ( $atts['source'] == 'product' ) { 
			
			$args = array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'posts_per_page'      => $atts['max_items'],
			);
			
			if ( $atts['product_group'] == 'recent_products' ) {
				
				$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['product_orderby'],
					'order'               => $atts['product_order'],
					'meta_query'          => WC()->query->get_meta_query()
				));
				
			} elseif ( $atts['product_group'] == 'featured_products' ) {
				
				$meta_query   = WC()->query->get_meta_query();
				$meta_query[] = array(
						'key'   => '_featured',
						'value' => 'yes'
				);
				
				$args = array_merge($args, array(
						'ignore_sticky_posts' => 1,
						'orderby'             => $atts['product_orderby'],
						'order'               => $atts['product_order'],
						'meta_query'          => $meta_query
				));
				
			} elseif ( $atts['product_group'] == 'sale_products' ) {
				
				$args = array_merge($args, array(
						'no_found_rows' 	=> 1,
						'orderby'           => $atts['product_orderby'],
						'order'             => $atts['product_order'],
						'meta_query'        => WC()->query->get_meta_query(),
						'post__in'			=> array_merge( array( 0 ), wc_get_product_ids_on_sale() )
				));
				
			} elseif ( $atts['product_group'] == 'best_selling_products' ) {
				
				$args = array_merge($args, array(
						'ignore_sticky_posts' => 1,
						'meta_key'            => 'total_sales',
						'orderby'             => 'meta_value_num',
						'meta_query'          => WC()->query->get_meta_query()
				));
				
			} elseif ( $atts['product_group'] == 'top_rated_products' ) {
				
				$args = array_merge($args, array(
						'ignore_sticky_posts' => 1,
						'orderby'             => $atts['product_orderby'],
						'order'               => $atts['product_order'],
						'meta_query'          => WC()->query->get_meta_query(),
				));
				
				add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
				
			}  elseif ( $atts['product_group'] == 'products_categories' ) {
				
				if ( isset( $atts['product_cat_ids'] ) ) {
					$term_ids = explode( ',', $atts['product_cat_ids'] );
					$term_ids = array_map( 'trim', $term_ids );
				} else {
					$term_ids = array();
				}
				
				$args = array_merge($args, array(
						'ignore_sticky_posts' => 1,
						'orderby'             => $atts['product_orderby'],
						'order'               => $atts['product_order'],
						'meta_query'          => WC()->query->get_meta_query(),
						'tax_query' 			=> array(
								array(
										'taxonomy' 		=> 'product_cat',
										'terms' 		=> $term_ids,
										'field' 		=> 'term_id',
								)
						)
				));
				
			} else {
				
				$post__in = '';
				if ( ! empty( $atts['ids'] ) ) {
					$post__in = array_map( 'trim', explode( ',', $atts['ids'] ) );
				}
				
				$args = array_merge($args, array(
						'ignore_sticky_posts' 	=> 1,
						'meta_query'          	=> WC()->query->get_meta_query(),
						'post__in'				=> 	$post__in
				));
				
				if ( ! empty( $atts['skus'] ) ) {
					$args['meta_query'][] = array(
							'key'     => '_sku',
							'value'   => array_map( 'trim', explode( ',', $atts['skus'] ) ),
							'compare' => 'IN'
					);
				}
			}
			
			$query = new WP_Query( $args );
			
			while ( $query->have_posts () ) : $query->the_post ();
			
				global $post, $product;
				
				
				$img = wp_get_attachment_image(get_post_thumbnail_id(), $atts['img_size']);
			 
				if ( $post->post_type == 'product' ){
					$css_classes[] = 'woocommerce';
				}
				?>
				<div class="mpt-item <?php echo implode(' ', $css_classes); ?>">
					<div class="mpt-item-inner">
						<?php if ( has_post_thumbnail() ) { ?>
						<figure class="mpt-item-thumbnail">
							<a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo apply_filters('mTheme_image', $img); ?></a>
							<?php if ( $post->post_type == 'product' ) { ?>
							<div class="buttons">
								<?php do_action( 'mtheme_woocommerce_add_to_cart' );?>
								<?php do_action( 'mtheme_woocommerce_add_to_wishlist' );?>
								<?php do_action( 'mtheme_woocommerce_add_to_compare' );?>
								<?php do_action( 'mtheme_woocommerce_add_quick_view' );?>
							</div>
							<?php } ?>
						</figure>
						<?php } ?>
						<div class="mpt-item-body">
							<h4 class="mpt-item-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo get_the_title(); ?></a></h4>
							<?php if ( $post->post_type == 'product' ) {
								do_action( 'mtheme_woocommerce_rating' );
								do_action( 'mtheme_woocommerce_price' );
							} ?>
						</div>
					</div>
				</div>
			<?php endwhile;
			
			wp_reset_postdata(); 
			
			if ( $atts['product_group'] == 'top_rated_products' )
				remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
			?>
			
		<?php } else {
			echo __ ( 'Not empty', 'mTheme' );
		} ?>
	</div>
	<?php 
	if ( !empty($contents) ) {
		echo '<div class="after-content">'. $contents .'</div>';
	}
	?>
</div>