<?php 
$sidebar_footer_top 	= m_wedding_get_options('sidebar_footer_top');
$sidebar_footer 		= m_wedding_get_options('sidebar_footer');
$copyright 				= m_wedding_get_options('copyright', '');
$container				= m_wedding_container();
?>		
		</div> <!-- End Main Content -->
		
		<!-- Footer -->
		<footer id="footer" class="footer">
		
			<?php if ( isset($sidebar_footer_top) && is_array($sidebar_footer_top) && count($sidebar_footer_top) > 0 ) { ?>
      		<div class="footer-top">
				<div class="<?php echo apply_filters('container', $container); ?>">
					<div class="row">
      				<?php foreach ( $sidebar_footer_top as $sidebar ) { ?>
	      				<?php if ( is_active_sidebar($sidebar['sidebar']) ) { ?>
	      				<div class="col-sm-<?php echo $sidebar['width']; ?> <?php echo apply_filters('sidebar_footer_top_el_class', $sidebar['el_class']); ?>">
	      					<div class="sidebar-inner">
	      						<?php dynamic_sidebar($sidebar['sidebar']); ?>
	      					</div>
	      				</div>
	      				<?php } ?>
      				<?php } ?>
      				</div>
      			</div>
      		</div>
      		<?php } ?>
      		
      		<?php if ( isset($sidebar_footer) && is_array($sidebar_footer) && count($sidebar_footer) > 0 ) { ?>
      		<div class="footer-info">
				<div class="<?php echo apply_filters('container', $container); ?>">
					<div class="row">
      				<?php foreach ( $sidebar_footer as $sidebar ) { ?>
	      				<?php if ( is_active_sidebar($sidebar['sidebar']) ) { ?>
	      				<div class="col-sm-<?php echo $sidebar['width']; ?> <?php echo apply_filters('sidebar_footer_info_el_class', $sidebar['el_class']); ?>">
	      					<div class="sidebar-inner">
	      						<?php dynamic_sidebar($sidebar['sidebar']); ?>
	      					</div>
	      				</div>
	      				<?php } ?>
      				<?php } ?>
      				</div>
      			</div>
      		</div>
      		<?php } ?>
	      	
	      	<div class="copyright">
				<div class="<?php echo apply_filters('container', $container); ?>">
					<?php echo apply_filters('copyright', $copyright); ?>
				</div>
			</div>
	    </footer>
			
	</div> <!-- End Wrapt -->

<?php wp_footer(); ?>

</body>
</html>
