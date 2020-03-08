<?php 
class WCST_Dashboard
{
	public function __construct()
	{
		
		 add_action( 'wp_dashboard_setup', array( &$this, 'add_server_time_widget' ) );
	}
	public function add_server_time_widget()
	{
		if(current_user_can('manage_woocommerce') || current_user_can('edit_posts'))
			wp_add_dashboard_widget( 'wcst-server-time', __('WooCommerce shipping tracking - Server time', 'woocommerce-shipping-tracking'), array( &$this, 'render_server_time_widget' ));
		 
	}
	function render_server_time_widget()
	{
		$wcst_option_model = new WCST_Option();
		$hour_offset = $wcst_option_model->get_estimations_options('hour_offset', 0);
		//$minute_offset = $wcst_option_model->get_estimations_options('wcst_time_minute_offset', 0);
		
		/* $hour = date("H",strtotime($time_offset.' minutes');
		$minute =  */
		?>
		<p class="form-field">
			<label  style="display: inline;"><?php echo __( 'Current server time with offset (date format: dd/mm/yyyy):', 'woocommerce-shipping-tracking' ); ?></label>
			<span class="wrap">
				<strong style=" font-size: 20px;"><?php echo date("d/m/Y H:i",strtotime($hour_offset.' minutes')); ?></strong>
			</span>
			<br/>
			<!-- <span style="display:block; clear:both;" class="description"><?php _e( sprintf('Sphipping estimations are syncronized with server time. Configure an hour offset going on <a href="%s">Configurator</a>', get_admin_url()."admin.php?page=acf-options-estimated-shipping-configurator"), 'woocommerce-shipping-tracking' ); ?></span>-->
			<span style="display:block; clear:both;" class="description"><?php _e( sprintf('Rule dates are syncronized with server time. Configure a proper <strong>Timezone</strong> in the <a href="%s">Settings -> General</a> option menu', get_admin_url()."options-general.php"), 'woocommerce-shipping-tracking' ); ?></span> 			
		</p>
							
		<?php
	}
	
}
?>