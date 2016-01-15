<?php

get_header(); 

//woocommerce_content()

$container 						= m_wedding_container();

if ( is_singular( 'product' ) ) {
	$shop_layout					= m_wedding_get_options('shop_single_layout',  'full-width');
	$shop_sidebar					= m_wedding_get_options('shop_single_sidebar');
	$shop_sidebar_width				= m_wedding_get_options('shop_single_sidebar_width');
	$shop_sidebar_el_class			= m_wedding_get_options('shop_single_sidebar_el_class');
} else {
	$shop_layout					= m_wedding_get_options('shop_layout',  'full-width');
	$shop_sidebar					= m_wedding_get_options('shop_sidebar');
	$shop_sidebar_width				= m_wedding_get_options('shop_sidebar_width');
	$shop_sidebar_el_class			= m_wedding_get_options('shop_sidebar_el_class');
}

$view 							= isset($_GET['view']) && $_GET['view'] == 'list' ? 'list' : '';

$col_content = $col_sidebar = array();
if ( $shop_layout == 'full-width' ) {
	$col_content[] = 'col-sm-12';
	
} else {
	$col_content[] = 'col-sm-' . (12 - $shop_sidebar_width);
	$col_sidebar[] = 'col-sm-' . $shop_sidebar_width;
	$col_sidebar[] = $shop_sidebar_el_class;
	
	if ( $shop_layout == 'left-sidebar' ) {
		$col_content[] = 'col-sm-push-' . $shop_sidebar_width;
		$col_sidebar[] = 'col-sm-pull-' . (12 - $shop_sidebar_width);
	}
}
?>
	
<div class="page-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

		<h1 class="page-title">
			<?php 
			if ( is_singular( 'product' ) ) {
				echo __('Product', 'mTheme');
				
			} else {
				woocommerce_page_title();
			} ?>
		</h1>
		
	<?php endif; ?>
	<?php woocommerce_breadcrumb(); ?>
	<?php //do_action( 'woocommerce_archive_description' ); ?>
</div>

<div class="page-content">
	<div class="<?php echo apply_filters('container', $container); ?>">
	
		<div class="row">
		
			<!-- Add Content -->
			<div class="<?php echo join(' ', $col_content); ?>">
			
				<?php 
				if ( is_singular( 'product' ) ) { ?>
					<div class="product-emtry">
					<?php 
					while ( have_posts() ) : the_post();
				
					get_template_part( 'contents/content', 'product-single' );
				
					endwhile; ?>
					</div>
				<?php 
				} else { ?>
			
					<div class="products">
						<?php if ( have_posts() ) : ?>
							<div class="woocommerce-before-shop-loop clearfix">
							<?php do_action('woocommerce_before_shop_loop'); ?>
							</div>
							
							<div class="shop-entry <?php echo esc_attr($view); ?>">
								<div class="row">
								<?php woocommerce_product_subcategories(); ?>
					
								<?php while ( have_posts() ) : the_post(); 
								
									if ( $view == 'list' ) {
										get_template_part( 'contents/content', 'product-list' );
									} else {
										get_template_part( 'contents/content', 'product' );
									}
					
								endwhile; // end of the loop. ?>
								</div>
							</div>
					
							<div class="woocommerce-after-shop-loop clearfix">
							<?php do_action('woocommerce_after_shop_loop'); ?>
							</div>
					
						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					
							<?php wc_get_template( 'loop/no-products-found.php' ); ?>
					
						<?php endif; ?>
					</div>
				<?php } ?>
				
			</div> <!-- End Content -->
			
			<!-- Add Sidebar -->
			<?php if ( $shop_layout != 'full-width' && is_active_sidebar($shop_sidebar) ) { ?>
			<div class="<?php echo join(' ', $col_sidebar); ?>">
				<div id="sidebar-shop" class="sidebar-shop sidebar">
      				<?php dynamic_sidebar($shop_sidebar); ?>
      			</div>
			</div>
			<!-- End Sidebar -->
			
		</div>
		<?php } ?>
	</div>
</div>
	
<?php get_footer(); ?>
