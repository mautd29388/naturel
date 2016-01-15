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
	
	<div class="gallery-inner">
		<div class="row">
		<?php if ( $atts['source'] == 'media_library' && !empty($atts['images']) ) {
			
			$ids = explode(',', $atts['images']);
			$i = 0;
			foreach ( $ids as $id ) { 
				$i++;
				$img = wp_get_attachment_image($id, $atts['img_size']);
				 
				?>
			<div class="gallery-item <?php echo implode(' ', $css_classes); ?>">
				<figure class="gallery-thumbnail">
					<a href="#" data-toggle="modal" data-target=".gallery-modal-<?php echo esc_attr($i); ?>"><?php echo apply_filters('mTheme_image', $img); ?></a>
				</figure>
			</div>
			<div class="modal fade gallery-modal-<?php echo esc_attr($i); ?>" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="buttons">
							<button type="button" class="close button" data-dismiss="modal" aria-label="Close"><i class="icon-cross"></i></button>
						</div>
						<img alt="" src="<?php echo wp_get_attachment_image_url($id, 'fullsize'); ?>">
					</div>
				</div>
			</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
	<?php 
	if ( !empty($contents) ) {
		echo '<div class="after_content">'. $contents .'</div>';
	}
	?>
</div>