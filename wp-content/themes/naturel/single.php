<?php

get_header(); 

$header_image = m_wedding_get_options('blog_image', 'http://placehold.it/1920x478/333');
$title = m_wedding_get_options('blog_title', 'News &amp; Events');
?>
<div class="page-header">
	<?php if ( isset($header_image) ) { ?>
	<figure class="post-thumbnail">
		<img alt="" src="<?php echo esc_attr($header_image); ?>">
	</figure>
	<?php } ?>
	<h1 class="title"><span class="line-title"><?php echo esc_html($title); ?><i class="fa">&#xf111;</i></span></h1>
</div>
<div class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-<?php echo is_active_sidebar('widget-area') ? '8' : '12'; ?>">
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
		
				// Include the page content template.
				get_template_part( 'contents/content', 'single' );
		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
		
			// End the loop.
			endwhile;
			?>
			</div>
			<?php if ( is_active_sidebar('widget-area') ) { ?>
			<div class="col-sm-4">
				<div class="sidebar">
					<?php dynamic_sidebar('widget-area'); ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
