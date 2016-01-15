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
<div class="mtheme-post-type <?php echo join($parent_class, ' '); ?>" data-options="mtheme_carousel_<?php echo $int ?>">
	<?php 
	if ( !empty($atts['title']) ) {
		echo wpb_widget_title( array( 'title' => $atts['title'], 'extraclass' => 'wpb_singleimage_heading' ) );
	} 
	if ( !empty($atts['before_content']) ) {
		echo '<div class="before-content">'. $atts['before_content'] .'</div>';
	}
	?>
	
	<div class="blog-inner">
		<div class="row">
		<?php if ( $atts['source'] == 'posttypes' && !empty($atts['posttypes']) ) { 
			$posttypes = explode(',', $atts['posttypes']);
			$post__in = array();
			foreach ( $posttypes as $posttype ) {
				if ( isset($atts[$posttype]) && !empty($atts[$posttype]) ) {
					$post__in = explode(',', $atts[$posttype]);
				}
			}
			$args = array(
					'post_type' 		=> $posttypes,
					'post__in' 			=> $post__in,
					'posts_per_page' 	=> '-1',
					'post_status' 		=> 'publish',
					'orderby' 			=> $atts['orderby'],
					'order' 			=> $atts['order'],
			);
			
			$query = new WP_Query( $args );
			
			$i = 0;
			while ( $query->have_posts () ) : $query->the_post ();
			
				global $post, $product;
				
				if ( has_post_thumbnail() ) {
					$i++;
					
					$img = wp_get_attachment_image(get_post_thumbnail_id(), $atts['img_size']);
				 
				?>
				<div class="blog-item <?php echo implode(' ', $css_classes); ?>">
					<div class="blog-item-inner">
						<figure class="blog-thumbnail">
							<a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo apply_filters('mTheme_image', $img); ?></a>
							<div class="blog-date"><span class="date"><?php echo get_the_date('d'); ?></span><span class="month"><?php echo get_the_date('F'); ?></span></div>
						</figure>
						<div class="blog-content">
							<h4 class="blog-content-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo get_the_title(); ?></a></h4>
							<div class="blog-content-excerpt"><?php echo m_wedding_trim(get_the_excerpt(), 15); ?></div>
							<div class="readmore"><a href="<?php echo get_permalink(get_the_ID()); ?>">readmore<i class="icon-arrow-right"></i></a></div>
						</div>
					</div>
				</div>
				<?php 	
				}
				
				if ( $i == $atts['max_items'] ) 
					break;
			
			endwhile;
			
			wp_reset_postdata(); ?>
			
		<?php } ?>
		</div>
	</div>
	<?php 
	if ( !empty($contents) ) {
		echo '<div class="after_content">'. $contents .'</div>';
	}
	?>
</div>