<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<?php 
	$boxed							= m_wedding_get_options('main_boxed', 'off');
	$container 						= m_wedding_container();
	$style		 					= m_wedding_get_options('header_styles');
	$header_top_sidebar				= m_wedding_get_options('header_top_sidebar');
	$header_middle_sidebar			= m_wedding_get_options('header_middle_sidebar');
	$header_bottom_sidebar			= m_wedding_get_options('header_bottom_sidebar');
	
	/*
	if ( $style == 'style-v2' ) {
		$container = 'container-fluid';
	}*/
?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php $wrap = $boxed == 'off' ? '' : 'wrap-boxed'; ?>
	<div id="wrap" class="<?php echo apply_filters('wrap_boxed', $wrap); ?>">

		<!-- Header -->
		<header id="header" class="header <?php echo isset($style) ? $style : ''; ?>">
			<div class="header-inner">
	      		
	      		<!-- Header Top -->
	      		<?php 
	      		if ( isset($header_top_sidebar) && is_array($header_top_sidebar) && count($header_top_sidebar) > 0 ) {
	      			
	      			$i = $j = 0;
      				foreach ( $header_top_sidebar as $sidebar ) {
      					
      					$i++;
	      				if ( is_active_sidebar($sidebar['sidebar']) ) { 
	      					
	      					$j++;
	      					
	      					if ( $j == 1 ) { ?>
		      				<div class="header-top"><div class="header-top-inner"><div class="<?php echo apply_filters('container', $container); ?>"><div class="row">
							<?php } ?>
							
		      					<div class="col-sm-<?php echo esc_attr($sidebar['width']); ?> <?php echo apply_filters('sidebar_header_top_el_class', $sidebar['el_class']); ?>">
		      						<div class="sidebar-inner">
		      							<?php dynamic_sidebar($sidebar['sidebar']); ?>
		      						</div>
		      					</div>
		      			<?php 		
	      				}
	      				if ( $i == count($header_top_sidebar) && $j > 0 ) { ?>
      						</div></div></div></div>
      					<?php }
      				}
	      		} 
	      		?>
	      		
	      		
	      		<!-- Header Middle -->
	      		<?php 
	      		if ( isset($header_middle_sidebar) && is_array($header_middle_sidebar) && count($header_middle_sidebar) > 0 ) {
	      			
	      			$i = $j = 0;
      				foreach ( $header_middle_sidebar as $sidebar ) {
      					
      					$i++;
	      				if ( is_active_sidebar($sidebar['sidebar']) ) { 
	      					
	      					$j++;
	      					
	      					if ( $j == 1 ) { ?>
		      				<div class="header-middle"><div class="header-middle-inner"><div class="<?php echo apply_filters('container', $container); ?>"><div class="row">
							<?php } ?>
							
		      					<div class="col-sm-<?php echo esc_attr($sidebar['width']); ?> <?php echo apply_filters('sidebar_header_middle_el_class', $sidebar['el_class']); ?>">
		      						<div class="sidebar-inner">
		      							<?php dynamic_sidebar($sidebar['sidebar']); ?>
		      						</div>
		      					</div>
	      				<?php 
	      				}
	      				
	      				if ( $i == count($header_middle_sidebar) && $j > 0 ) { ?>
				      	</div></div></div></div>
			      		<?php }
      				}
	      		} 
	      		?>
	      		
	      		
	      		<!-- Header Bottom -->
	      		<?php 
	      		if ( isset($header_bottom_sidebar) && is_array($header_bottom_sidebar) && count($header_bottom_sidebar) > 0 ) {
	      			
	      			$i = $j = 0;
      				foreach ( $header_bottom_sidebar as $sidebar ) {
      					
      					$i++;
	      				if ( is_active_sidebar($sidebar['sidebar']) ) {
	      					
	      					$j++;
	      					
	      					if ( $j == 1 ) { ?>
		      				<div class="header-bottom"><div class="header-bottom-inner"><div class="<?php echo apply_filters('container', $container); ?>"><div class="row">
							<?php } ?>
							
		      					<div class="col-sm-<?php echo esc_attr($sidebar['width']); ?> <?php echo apply_filters('sidebar_header_bottom_el_class', $sidebar['el_class']); ?>">
		      						<div class="sidebar-inner">
		      							<?php dynamic_sidebar($sidebar['sidebar']); ?>
		      						</div>
		      					</div>
				      	<?php 	
	      				}
	      				if ( $i == count($header_bottom_sidebar) && $j > 0 ) { ?>
      						</div></div></div></div>
      					<?php }
      				}
	      		} 
	      		?>
	      		
			</div>
			
		</header>
		<!-- End Header -->

		<!-- Main Content -->
		<div id="main-content" class="main-content">
