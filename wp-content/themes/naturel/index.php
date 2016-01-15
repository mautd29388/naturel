<?php

get_header(); 

$container 						= m_wedding_container();
$blog_layout					= m_wedding_get_options('blog_layout',  'full-width');
$blog_sidebar					= m_wedding_get_options('blog_sidebar');
$blog_sidebar_width				= m_wedding_get_options('blog_sidebar_width');
$blog_sidebar_el_class			= m_wedding_get_options('blog_sidebar_el_class');

$col_content = $col_sidebar = array();
if ( $blog_layout == 'full-width' ) {
	$col_content[] = 'col-sm-12';
	
} else {
	$col_content[] = 'col-sm-' . (12 - $blog_sidebar_width);
	$col_sidebar[] = 'col-sm-' . $blog_sidebar_width;
	$col_sidebar[] = $blog_sidebar_el_class;
	
	if ( $blog_layout == 'left-sidebar' ) {
		$col_content[] = 'col-sm-push-' . $blog_sidebar_width;
		$col_sidebar[] = 'col-sm-pull-' . (12 - $blog_sidebar_width);
	}
}
?>
	
<?php if ( !is_front_page() ) { ?>
<div class="page-header">
	<h1 class="title"><span class="line-title">
		<?php 
		if ( is_singular() || is_home() ) {
			single_post_title();
		} elseif ( is_category() ) {
			single_term_title();
		} else
			the_archive_title();
		?>
	</h1>
	<?php woocommerce_breadcrumb(); ?>
</div>
<?php } ?>

<div class="page-content">
	<div class="<?php echo apply_filters('container', $container); ?>">
		<div class="row">
		
			<!-- Add Content -->
			<div class="<?php echo join(' ', $col_content); ?>">
				<div class="contents">
					<div class="blog-entry">
					<?php 
					while ( have_posts() ) : the_post(); 
						get_template_part( 'contents/content', '' ); 
					endwhile; ?>
					</div>
					
					<?php 
					if ( !is_singular() ) {
						// Previous/next page navigation.
						m_wedding_pagination();
					}
					?>
				</div>
			</div> <!-- End Content -->
			
			<!-- Add Sidebar -->
			<?php if ( $blog_layout != 'full-width' && is_active_sidebar($blog_sidebar) ) { ?>
			<div class="<?php echo join(' ', $col_sidebar); ?>">
				<div id="sidebar-blog" class="sidebar-blog sidebar">
      				<?php dynamic_sidebar($blog_sidebar); ?>
      			</div>
			</div>
			<?php } ?> <!-- End Sidebar -->
			
		</div>
	</div>
</div>
	
<?php get_footer(); ?>

