<?php 

global $post, $product;
				
?>
<!-- Post -->
<div class="col-sm-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<figure class="product-thumbnail">
			<a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo woocommerce_get_product_thumbnail(); ?></a>
			<div class="buttons">
				<?php do_action( 'mtheme_woocommerce_add_quick_view' );?>
			</div>
		</figure>
		<div class="entry-body">
			<h4 class="entry-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo get_the_title(); ?></a></h4>
			<?php
				do_action( 'mtheme_woocommerce_rating' );
				do_action( 'mtheme_woocommerce_price' );
			?>
			<div class="product-excerpt">
				<?php the_excerpt(); ?>
			</div>
			<div class="buttons">
				<?php do_action( 'mtheme_woocommerce_add_to_cart' );?>
				<?php do_action( 'mtheme_woocommerce_add_to_wishlist' );?>
				<?php do_action( 'mtheme_woocommerce_add_to_compare' );?>
			</div>
		</div>
	</article>
</div>
<!-- End Post -->