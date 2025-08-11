<?php

function iqonic_departments_menu_widgets() {
	register_widget( 'iq_departments_menu' );
}
add_action( 'widgets_init', 'iqonic_departments_menu_widgets' );

/*-------------------------------------------
		Contact Information widget 
--------------------------------------------*/
class iq_departments_menu extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_departments_menu', 
			
			// Widget name will appear in UI
			esc_html('Iqonic Departments Menu', 'iqonic'), 
 
			// Widget description
			array( 'description' => esc_html( 'Iqonic Departments menu. ', 'iqonic' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : false;
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base ); ?>
         <div class="iq-main-departments"> <?php
			if ( $title ) {
				echo ($args['before_title'] . $title . $args['after_title']);
			}

			/* here add extra display item  */ 
			if ( has_nav_menu( 'kivi-departments-menu' ) ) : ?> <?php
				wp_nav_menu( array(
					'theme_location'   => 'kivi-departments-menu',
					'menu_class'       => 'navbar-nav ml-auto',
					'menu_id'          => 'departments-menu',
					'container_class'  => 'kivi-departments-menu',
					'container_id'     => 'iq-menu-departments',
				) ); ?> <?php 
			endif; ?>
		</div>	 <?php
	}
         
	// Widget Backend 
	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';	 ?>
		<p>
		    <label for="<?php echo esc_html($this->get_field_id( 'title','iqonic' )); ?>">
			    <?php esc_html_e( 'Title:','iqonic' ); ?>
			</label>
		    <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','iqonic')); ?>" type="text" value="<?php echo esc_html($title,'iqonic'); ?>" />
		</p> <?php 
							
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/
