<?php

function m_wedding_widgets_init() {
	register_sidebar( array(
			'name' => __ ( 'Widget Area', 'mTheme' ),
			'id' => 'widget-area',
			'description' => __ ( '', 'mTheme' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' => '</div></aside>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>' 
	) );
	
	$sidebar = m_wedding_get_options('sidebar');
	
	if ( isset($sidebar) && is_array($sidebar) && count($sidebar) > 0 ) {
		foreach ( $sidebar as $side ) {
			
			register_sidebar( array(
					'name' => $side['name'],
					'id' => sanitize_title($side['name']),
					'description' => __ ( '', 'mTheme' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></aside>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>'
			) );
		}
	}
}
add_action( 'widgets_init', 'm_wedding_widgets_init' );


/**
 * Register Widget
 */ 
function m_wedding_register_widget() {
	register_widget( 'm_wedding_Logo_Widget' );
	register_widget( 'm_wedding_Menu_Widget' );
	register_widget( 'm_wedding_MiniCart_Widget' );
}
add_action( 'widgets_init', 'm_wedding_register_widget' );


/**
 * mTheme Logo Widget.
 */
class m_wedding_Logo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-logo', 'description' => __( 'Show Logo', 'mTheme' ) );
		$control_ops = array();
		parent::__construct('mTheme-logo', __( 'mTheme Logo', 'mTheme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {
		
		$logo		= m_wedding_get_options('logo');
		
		echo $args['before_widget'];
		?>
		<!-- Logo -->
		<div class="logo">
			<a href="<?php echo esc_url( home_url() ); ?>">
				<?php if ( isset($logo) && !empty($logo) ) { ?>
					<img alt="" src="<?php echo $logo; ?>">
				<?php } else echo bloginfo('name'); ?>
			</a>
		</div>
		<?php 
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Logo', 'mTheme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mTheme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}


/**
 * mTheme Menu Widget.
 */
class m_wedding_Menu_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-menu', 'description' => __( 'Show Menu', 'mTheme' ) );
		$control_ops = array();
		parent::__construct('mTheme-menu', __( 'mTheme Menu', 'mTheme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {

		$location	= ! empty( $instance['location'] ) ? $instance['location'] : '';

		if ( empty($location) )
			return false;
		
		echo $args['before_widget'];
		?>
		<!-- Main Menu -->
		<nav class="navbar" role="navigation">
			<div class="navbar-inner">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed"
						data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
					<h3 class="navbar-brand">Menu</h3>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<?php 
					wp_nav_menu ( 
						array ( 
							'theme_location' => $location,
							'container' => '',
							'menu_class' => 'nav navbar-nav',
							'walker' => new mTheme_nav_walker
						) 
					); ?>
				</div>
				<!--/.navbar-collapse -->
			</div>
		</nav>
		<?php 
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		global $_wp_registered_nav_menus;
		
		$locations = $_wp_registered_nav_menus;
		
		
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Menu', 'mTheme' );
		$location	= ! empty( $instance['location'] ) ? $instance['location'] : '';
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mTheme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php echo __( 'Theme locations:', 'mTheme' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>">
			<?php 
			if ( is_array($locations) && count($locations) > 0 ) {
				foreach ( $locations as $key => $val ) {
					echo "<option value='". $key ."' ". selected($key, $location, false) ." >$val</option>";
				}
			}
			?>
		</select></p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] 		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['location'] 	= ( ! empty( $new_instance['location'] ) ) ? strip_tags( $new_instance['location'] ) : '';

		return $instance;
	}

}


/**
 * mTheme MiniCart Widget.
 */
class m_wedding_MiniCart_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-minicart', 'description' => __( 'Show Mini Cart', 'mTheme' ) );
		$control_ops = array();
		parent::__construct('mTheme-minicart', __( 'mTheme Cart', 'mTheme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		
		echo m_wedding_minicart();
		
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Cart', 'mTheme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mTheme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}