<?php

get_header(); 

$container 						= m_wedding_container();
$page_layout					= get_post_meta(get_the_ID(), '__layout', true);
$page_sidebar					= get_post_meta(get_the_ID(), '__sidebar', true);
$page_sidebar_width				= get_post_meta(get_the_ID(), '__width', true);
$page_sidebar_el_class			= get_post_meta(get_the_ID(), '__el_class', true);

$col_content = $col_sidebar = array();
if ( $page_layout == 'full-width' ) {
	$col_content[] = 'col-sm-12';
	
} else {
	$col_content[] = 'col-sm-' . (12 - $page_sidebar_width);
	$col_sidebar[] = 'col-sm-' . $page_sidebar_width;
	$col_sidebar[] = $page_sidebar_el_class;
	
	if ( $page_layout == 'left-sidebar' ) {
		$col_content[] = 'col-sm-push-' . $page_sidebar_width;
		$col_sidebar[] = 'col-sm-pull-' . (12 - $page_sidebar_width);
	}
}
?>

<?php if ( !is_front_page() ) {?>
<div class="page-header">
	<h1 class="page-title"><?php the_title(); ?></h1>
	<?php woocommerce_breadcrumb(); ?>
</div>
<?php } ?>

<div class="page-content">
	<div class="<?php echo apply_filters('container', $container); ?>">
		<div class="row">
		
			<!-- Add Content -->
			<div class="<?php echo join(' ', $col_content); ?>">
				<div class="contents">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="page-entry"><?php the_content(); ?></div>
						<?php 
						wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mTheme' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'mTheme' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
						) );
						?>
					<?php endwhile; // end of the loop. ?>
				</div>
			</div> <!-- End Content -->
			
			<!-- Add Sidebar -->
			<?php if ( $page_layout != 'full-width' && is_active_sidebar($page_sidebar) ) { ?>
			<div class="<?php echo join(' ', $col_sidebar); ?>">
				<div id="sidebar-page" class="sidebar-page sidebar">
      				<?php dynamic_sidebar($page_sidebar); ?>
      			</div>
			</div>
			<?php } ?> <!-- End Sidebar -->
			
		</div>
	</div>
</div>
	
<?php get_footer(); ?>
