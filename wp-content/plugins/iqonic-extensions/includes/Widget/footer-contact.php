<?php

function iqonic_contact_info() {
    register_widget( 'iq_contact' );
}
add_action( 'widgets_init', 'iqonic_contact_info' );

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_contact extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_contact', 
			
			// Widget name will appear in UI
			esc_html('Iqonic Contact', 'iqonic'), 
 
			// Widget description
			array( 'description' => esc_html( 'Iqonic Contact. ', 'iqonic' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {

		global $wp_registered_sidebars;
		global  $kivicare_options;
		
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : false;

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$phone = isset( $instance['phone'] ) ? $instance['phone'] : false;
		$phone1 = isset( $instance['phone1'] ) ? $instance['phone1'] : false;
		$email = isset( $instance['email'] ) ? $instance['email'] : false;
		$address = isset( $instance['address'] ) ? $instance['address'] : false;

		/* here add extra display item  */ 
		?>
		<div class="widget"> <?php

			if ( $title ) {
				?><h4 class="widget-title contact-info"><?php echo esc_html($title); ?></h4><?php
			} ?>

			<div class="row">
				<div class="col-sm-12">
					<ul class="iq-contact"> <?php
						if ( $phone ) : ?>
							<li>
								<a href="tel:<?php echo str_replace(str_split('(),-" '), '',$kivicare_options['phone']); ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none"><mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="27" height="27"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 0.500244H26.1245V26.1246H0.5V0.500244Z" fill="white"></path></mask><g><path fill-rule="evenodd" clip-rule="evenodd" d="M3.44886 4.32583C3.45136 4.32583 3.38886 4.39083 3.31011 4.46833C3.00761 4.76208 2.38136 5.37333 2.37511 6.65208C2.36511 8.44083 3.54136 11.7621 9.2051 17.4246C14.8426 23.0596 18.1589 24.2496 19.9514 24.2496H19.9776C21.2564 24.2433 21.8664 23.6158 22.1614 23.3146C22.2514 23.2221 22.3239 23.1546 22.3751 23.1121C23.6201 21.8596 24.2576 20.9271 24.2514 20.3296C24.2426 19.7196 23.4839 18.9983 22.4351 18.0008C22.1014 17.6833 21.7389 17.3383 21.3564 16.9558C20.3651 15.9671 19.8739 16.1358 18.7939 16.5158C17.3001 17.0396 15.2501 17.7521 12.0651 14.5658C8.8751 11.3783 9.58885 9.33083 10.1114 7.83708C10.4889 6.75708 10.6614 6.26458 9.66886 5.27208C9.28011 4.88458 8.93136 4.51708 8.61011 4.17958C7.61886 3.13708 6.90386 2.38333 6.29761 2.37458H6.28761C5.68886 2.37458 4.75886 3.01458 3.44261 4.33083C3.44636 4.32708 3.44761 4.32583 3.44886 4.32583ZM19.9526 26.1246C16.8376 26.1246 12.7764 23.6446 7.8801 18.7508C2.96511 13.8371 0.481355 9.76333 0.500105 6.64208C0.511355 4.57958 1.59261 3.52333 1.99886 3.12708C2.02011 3.10083 2.09261 3.02958 2.11761 3.00458C3.9101 1.21083 5.11885 0.485831 6.32135 0.499581C7.7176 0.518331 8.71135 1.56333 9.96885 2.88708C10.2801 3.21458 10.6176 3.57083 10.9939 3.94583C12.8189 5.77083 12.2989 7.25958 11.8814 8.45458C11.4264 9.75833 11.0326 10.8833 13.3901 13.2408C15.7501 15.5983 16.8751 15.2046 18.1739 14.7458C19.3701 14.3283 20.8551 13.8058 22.6826 15.6308C23.0526 16.0008 23.4039 16.3346 23.7276 16.6433C25.0576 17.9071 26.1076 18.9058 26.1251 20.3058C26.1401 21.4996 25.4151 22.7158 23.6251 24.5071L22.8326 23.9696L23.5026 24.6246C23.1064 25.0308 22.0514 26.1133 19.9876 26.1246H19.9526Z" fill="#7093E5"></path></g></svg> <?php
									if($kivicare_options['phone']) { ?>
									    <span><?php echo esc_html($kivicare_options['phone']); ?></span> <?php
									} ?>    
								</a>
							</li> <?php 
						endif; 
						
						if ( $phone1 ) : ?>
						<?php if(isset($kivicare_options['phone1']) && !empty($kivicare_options['phone1'])) { ?>
							<li>
								<a href="tel:<?php echo str_replace(str_split('(),-" '), '',$kivicare_options['phone1']); ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none"><mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="27" height="27"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 0.500244H26.1245V26.1246H0.5V0.500244Z" fill="white"></path></mask><g><path fill-rule="evenodd" clip-rule="evenodd" d="M3.44886 4.32583C3.45136 4.32583 3.38886 4.39083 3.31011 4.46833C3.00761 4.76208 2.38136 5.37333 2.37511 6.65208C2.36511 8.44083 3.54136 11.7621 9.2051 17.4246C14.8426 23.0596 18.1589 24.2496 19.9514 24.2496H19.9776C21.2564 24.2433 21.8664 23.6158 22.1614 23.3146C22.2514 23.2221 22.3239 23.1546 22.3751 23.1121C23.6201 21.8596 24.2576 20.9271 24.2514 20.3296C24.2426 19.7196 23.4839 18.9983 22.4351 18.0008C22.1014 17.6833 21.7389 17.3383 21.3564 16.9558C20.3651 15.9671 19.8739 16.1358 18.7939 16.5158C17.3001 17.0396 15.2501 17.7521 12.0651 14.5658C8.8751 11.3783 9.58885 9.33083 10.1114 7.83708C10.4889 6.75708 10.6614 6.26458 9.66886 5.27208C9.28011 4.88458 8.93136 4.51708 8.61011 4.17958C7.61886 3.13708 6.90386 2.38333 6.29761 2.37458H6.28761C5.68886 2.37458 4.75886 3.01458 3.44261 4.33083C3.44636 4.32708 3.44761 4.32583 3.44886 4.32583ZM19.9526 26.1246C16.8376 26.1246 12.7764 23.6446 7.8801 18.7508C2.96511 13.8371 0.481355 9.76333 0.500105 6.64208C0.511355 4.57958 1.59261 3.52333 1.99886 3.12708C2.02011 3.10083 2.09261 3.02958 2.11761 3.00458C3.9101 1.21083 5.11885 0.485831 6.32135 0.499581C7.7176 0.518331 8.71135 1.56333 9.96885 2.88708C10.2801 3.21458 10.6176 3.57083 10.9939 3.94583C12.8189 5.77083 12.2989 7.25958 11.8814 8.45458C11.4264 9.75833 11.0326 10.8833 13.3901 13.2408C15.7501 15.5983 16.8751 15.2046 18.1739 14.7458C19.3701 14.3283 20.8551 13.8058 22.6826 15.6308C23.0526 16.0008 23.4039 16.3346 23.7276 16.6433C25.0576 17.9071 26.1076 18.9058 26.1251 20.3058C26.1401 21.4996 25.4151 22.7158 23.6251 24.5071L22.8326 23.9696L23.5026 24.6246C23.1064 25.0308 22.0514 26.1133 19.9876 26.1246H19.9526Z" fill="#7093E5"></path></g></svg> 
									    <span><?php echo esc_html($kivicare_options['phone1']); ?></span> <?php
									} ?>    
								</a>
							</li> <?php 
						endif; 
					  ?>
						<?php
						if ( $email ) :  ?>
							<li>
								<a href="mailto:<?php echo $kivicare_options['email']; ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="28" height="25" viewBox="0 0 28 25" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7217 14.831C12.8854 14.831 12.0516 14.5547 11.3541 14.0022L5.7479 9.48224C5.34415 9.15724 5.28165 8.56599 5.6054 8.16349C5.93165 7.76224 6.52165 7.69849 6.92415 8.02224L12.5254 12.5372C13.2292 13.0947 14.2204 13.0947 14.9291 12.5322L20.4741 8.02474C20.8766 7.69599 21.4667 7.75849 21.7941 8.16099C22.1204 8.56224 22.0592 9.15224 21.6579 9.47974L16.1029 13.9947C15.4004 14.5522 14.5604 14.831 13.7217 14.831Z" fill="#7093E5"></path><mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="25"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.25 0.5H27.1249V24.875H0.25V0.5Z" fill="white"></path></mask><g><path fill-rule="evenodd" clip-rule="evenodd" d="M7.54875 23H19.8237C19.8263 22.9975 19.8363 23 19.8438 23C21.27 23 22.535 22.49 23.505 21.5212C24.6313 20.4 25.25 18.7887 25.25 16.985V8.4C25.25 4.90875 22.9675 2.375 19.8237 2.375H7.55125C4.4075 2.375 2.125 4.90875 2.125 8.4V16.985C2.125 18.7887 2.745 20.4 3.87 21.5212C4.84 22.49 6.10625 23 7.53125 23H7.54875ZM7.5275 24.875C5.59875 24.875 3.87625 24.175 2.54625 22.85C1.065 21.3725 0.25 19.29 0.25 16.985V8.4C0.25 3.89625 3.38875 0.5 7.55125 0.5H19.8238C23.9863 0.5 27.125 3.89625 27.125 8.4V16.985C27.125 19.29 26.31 21.3725 24.8288 22.85C23.5 24.1737 21.7763 24.875 19.8438 24.875H19.8238H7.55125H7.5275Z" fill="#7093E5"></path></g></svg> <?php
									if($kivicare_options['email']) { ?>
									    <span><?php echo esc_html($kivicare_options['email']); ?></span> <?php
									} ?>    
								</a>
							</li> <?php 
						endif; ?> <?php
						if ( $address ) : ?>			
							<li>
								<a>
								<svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" viewBox="0 0 21 25" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3125 8.625C9.10625 8.625 8.125 9.60625 8.125 10.8138C8.125 12.02 9.10625 13 10.3125 13C11.5188 13 12.5 12.02 12.5 10.8138C12.5 9.60625 11.5188 8.625 10.3125 8.625ZM10.3125 14.875C8.0725 14.875 6.25 13.0538 6.25 10.8137C6.25 8.5725 8.0725 6.75 10.3125 6.75C12.5525 6.75 14.375 8.5725 14.375 10.8137C14.375 13.0538 12.5525 14.875 10.3125 14.875Z" fill="#7093E5"></path><mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="25"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5H20.6244V24.875H0V0.5Z" fill="white"></path></mask><g><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3125 2.375C5.66 2.375 1.875 6.19625 1.875 10.8912C1.875 16.865 8.905 22.685 10.3125 22.995C11.72 22.6837 18.75 16.8637 18.75 10.8912C18.75 6.19625 14.965 2.375 10.3125 2.375ZM10.3125 24.875C8.07 24.875 0 17.935 0 10.8912C0 5.16125 4.62625 0.5 10.3125 0.5C15.9987 0.5 20.625 5.16125 20.625 10.8912C20.625 17.935 12.555 24.875 10.3125 24.875Z" fill="#7093E5"></path></g></svg>
									<span><?php $address = $kivicare_options['address']; echo esc_html($address); ?></span>
								</a>
							</li> <?php 
						endif; ?>
					</ul>
				</div>
			</div>
		</div> <?php
	}
         
	// Widget Backend 
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$phone    = isset( $instance['phone'] ) ? (bool) $instance['phone'] : false;
		$phone1 = isset( $instance['phone1'] ) ? $instance['phone1'] : false;
		$email = isset( $instance['email'] ) ? (bool) $instance['email'] : false;
		$address = isset( $instance['address'] ) ? (bool) $instance['address'] : false;	
		?>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','iqonic' )); ?>"><?php esc_html_e( 'Title:','iqonic' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','iqonic')); ?>" type="text" value="<?php echo esc_html($title,'iqonic'); ?>" /></p>
		
		<p><input class="checkbox" type="checkbox"<?php checked( $phone ); ?> id="<?php echo esc_html($this->get_field_id( 'phone','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'phone','iqonic' )); ?>" />
		<label for="<?php echo esc_html($this->get_field_id( 'phone','iqonic' )); ?>"><?php esc_html_e( 'Display Phone Number?','iqonic' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $phone1); ?> id="<?php echo esc_html($this->get_field_id( 'phone1','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'phone1','iqonic' )); ?>" />
		<label for="<?php echo esc_html($this->get_field_id( 'phone1','iqonic' )); ?>"><?php esc_html_e( 'Display Phone Number(2)?','iqonic' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $email ); ?> id="<?php echo esc_html($this->get_field_id( 'email','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'email','iqonic' )); ?>" />
		<label for="<?php echo esc_html($this->get_field_id( 'email','iqonic' )); ?>"><?php esc_html_e( 'Display Email?','iqonic' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $address ); ?> id="<?php echo esc_html($this->get_field_id( 'address','iqonic' )); ?>" name="<?php echo esc_html($this->get_field_name( 'address','iqonic' )); ?>" />
		<label for="<?php echo esc_html($this->get_field_id( 'address','iqonic' )); ?>"><?php esc_html_e( 'Display Address?','iqonic' ); ?></label></p>
		
		<?php 					
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['phone'] = isset( $new_instance['phone'] ) ? (bool) $new_instance['phone'] : false;
		$instance['phone1'] = isset( $new_instance['phone1'] ) ? (bool) $new_instance['phone1'] : false;
		$instance['email'] = isset( $new_instance['email'] ) ? (bool) $new_instance['email'] : false;
		$instance['address'] = isset( $new_instance['address'] ) ? (bool) $new_instance['address'] : false;
		$instance['iq-contact'] = $new_instance['iq-contact'];
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/	
