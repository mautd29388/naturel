<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div class="row">
	<?php
	if ( !empty($atts['product_banner']) ) {
		$banner_class= array();
		$banner_class[] = 'col-sm-6';
		if ( $atts['product_banner_align'] == 'center' ) {
			$banner_class[] = 'col-sm-push-3';
		
		} elseif ( $atts['product_banner_align'] == 'right' ) {
			$banner_class[] = 'col-sm-push-6';
		}
		
		$columns = 2;
	?>
	<div class="<?php echo join(' ', $banner_class); ?>">
		<div class="mpt-item-banner">
			<?php echo wp_get_attachment_image($atts['product_banner'], $atts['img_size']); ?>
		</div>
	</div>
	<?php 
	}
	
	$i = 0;
	while ( $query->have_posts () ) : $query->the_post ();
	
		global $post, $product;
		
		$i++;
		
		$img = wp_get_attachment_image(get_post_thumbnail_id(), $atts['img_size']);
		
		$css_classes = $item_class;
		if ( !empty($atts['product_banner']) ) {
			if ( $atts['product_banner_align'] == 'center' && $i % 2 == 1 ) {
				$css_classes[] = 'col-sm-pull-6';
					
			} elseif ( $atts['product_banner_align'] == 'right' )
				$css_classes[] = 'col-sm-pull-6';
		}
		
		if ( $i%$columns == 1 ) {
			$css_classes[] = 'product-first';
		
		} elseif ( $i%$columns == 0 ) {
			$css_classes[] = 'product-last';
		}
		?>
		<div class="product <?php echo implode(' ', $css_classes); ?>">
			<div class="product-entry">
				<?php if ( has_post_thumbnail() ) { ?>
				<figure class="entry-thumbnail">
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
				<div class="entry-body">
					<h4 class="entry-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo get_the_title(); ?></a></h4>
					<?php if ( $post->post_type == 'product' ) {
						//do_action( 'mtheme_woocommerce_rating' );
						do_action( 'mtheme_woocommerce_price' );
					} ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>
