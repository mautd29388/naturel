<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div class="blog-inner">
	<div class="row">
	
		<?php
		while ( $query->have_posts () ) : $query->the_post ();
		
			$css_classes = $item_class;
			?>
			<div class="blog-item <?php echo implode(' ', $css_classes); ?>">
				<div class="blog-item-inner">
					<?php if ( has_post_thumbnail() ) { ?>
					<figure class="blog-thumbnail">
						<a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo wp_get_attachment_image(get_post_thumbnail_id(), $atts['img_size']); ?></a>
						<div class="blog-date"><span class="date"><?php echo get_the_date('d'); ?></span><span class="month"><?php echo get_the_date('F'); ?></span></div>
					</figure>
					<?php } ?>
					<div class="blog-content">
						<h4 class="blog-content-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo get_the_title(); ?></a></h4>
						<div class="blog-content-excerpt"><?php echo m_wedding_trim(get_the_excerpt(), 15); ?></div>
						<div class="readmore"><a href="<?php echo get_permalink(get_the_ID()); ?>">readmore<i class="icon-arrow-right"></i></a></div>
					</div>
				</div>
			</div>
		<?php 	
		endwhile;
		
		wp_reset_postdata(); ?>
		
	</div>
</div>
	