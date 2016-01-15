<?php 

global $post, $product;
				
?>
<!-- Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-sm-5">
			<figure class="product-thumbnail">
				<?php
					/**
					 * woocommerce_before_single_product_summary hook
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
				?>
			</figure>
		</div>
		<div class="col-sm-7">
			<div class="entry-body">
				<h3 class="entry-title"><?php echo get_the_title(); ?></h3>
				<?php
					do_action( 'mtheme_woocommerce_single_rating' );
					do_action( 'mtheme_woocommerce_single_price' );
					do_action( 'mtheme_woocommerce_single_excerpt' );
				?>
				<div class="buttons">
					<?php do_action( 'mtheme_woocommerce_single_add_to_cart' );?>
					<?php do_action( 'mtheme_woocommerce_add_to_wishlist' );?>
					<?php do_action( 'mtheme_woocommerce_add_to_compare' );?>
				</div>
				<?php 
					do_action( 'mtheme_woocommerce_single_sharing' );
					do_action( 'mtheme_woocommerce_single_meta' );
				?>
			</div>
		</div>
	</div>
	
	<?php do_action( 'mtheme_woocommerce_after_single_product_data_tabs' ); ?>
	
</article>

<!-- End Post -->