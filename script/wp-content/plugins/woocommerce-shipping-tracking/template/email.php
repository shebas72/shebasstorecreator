<?php 
$shipping_traking_num = $order_meta['_wcst_order_trackno'][0];
$dispatch_date = isset($order_meta['_wcst_order_dispatch_date'][0]) ? $order_meta['_wcst_order_dispatch_date'][0] : __( 'N/A', 'woocommerce' ) ;
$dispatch_date = $wcst_time_model->format_data($dispatch_date);
$custom_text = isset($order_meta['_wcst_custom_text'][0]) ? $order_meta['_wcst_custom_text'][0] : "";
$shipping_company_name;
//$messages = get_option( 'wcst_template_messages');

$messages = $options_model->get_messages( null, $lang );
$order_detail_message = (!isset($messages['wcst_mail_message']) || $messages['wcst_mail_message'] == "") ? nl2br($default_message):nl2br($messages['wcst_mail_message']);
$order_detail_message_additional = "";

$order_detail_message = str_replace("[shipping_company_name]", $shipping_company_name, $order_detail_message);
$order_detail_message = str_replace("[url_track]", $urltrack, $order_detail_message);
//conditional
$order_detail_message = WCST_Shortcodes::check_if_conditional_no_tracking_url_text_has_to_be_removed($order_detail_message, $urltrack == "");
	
$order_detail_message = str_replace("[tracking_number]", $shipping_traking_num, $order_detail_message);
$order_detail_message = str_replace("[dispatch_date]", $dispatch_date, $order_detail_message);
$order_detail_message = str_replace("[custom_text]", $custom_text, $order_detail_message);

//Active email notification
if(!empty($tracking_code_to_show_on_email) && !isset($tracking_code_to_show_on_email["default"]))
	$order_detail_message = "";

if($order_meta_additional_shippings)
{
	foreach($order_meta_additional_shippings as $index => $additional_shipping)
	{
		
		//Active email notification
		if(!empty($tracking_code_to_show_on_email) && !isset($tracking_code_to_show_on_email[$index]))
			continue;
		
		//no code
		if($additional_shipping['_wcst_order_trackurl'] == 'NOTRACK')
			continue;
		
		$order_detail_message_additional .= (!isset($messages['wcst_mail_message_additional_shippings']) || $messages['wcst_mail_message_additional_shippings'] == "") ? nl2br($default_message_additional):nl2br($messages['wcst_mail_message_additional_shippings']);
		
		$urltrack = $additional_shipping['_wcst_order_trackno'];
		$dispatch_date = isset($additional_shipping['_wcst_order_dispatch_date']) ? $additional_shipping['_wcst_order_dispatch_date'] : "" ;
		$dispatch_date = $wcst_time_model->format_data($dispatch_date);
		$shipping_company_name =  $additional_shipping['_wcst_order_trackname'];
		$shipping_traking_num = $additional_shipping['_wcst_order_track_http_url'];
		$custom_text = isset($additional_shipping['_wcst_custom_text']) ? $additional_shipping['_wcst_custom_text'] : "";
		
		$order_detail_message_additional = str_replace("[additional_shipping_company_name]", $shipping_company_name, $order_detail_message_additional);
		$order_detail_message_additional = str_replace("[additional_shipping_tracking_number]", $urltrack, $order_detail_message_additional);
		$order_detail_message_additional = str_replace("[additional_shipping_url_track]", $shipping_traking_num, $order_detail_message_additional);
		//conditional
		$order_detail_message_additional = WCST_Shortcodes::check_if_conditional_no_tracking_url_text_has_to_be_removed($order_detail_message_additional, $shipping_traking_num == "");
		
		$order_detail_message_additional = isset($dispatch_date) && $dispatch_date != "" && !empty($dispatch_date) ? str_replace("[additional_dispatch_date]", $dispatch_date, $order_detail_message_additional): str_replace("[additional_dispatch_date]", __( 'N/A', 'woocommerce-shipping-tracking' ), $order_detail_message_additional);
		$order_detail_message_additional = isset($dispatch_date) && $dispatch_date != "" && !empty($dispatch_date) ? str_replace("[dispatch_date]", $dispatch_date, $order_detail_message_additional): str_replace("[dispatch_date]", __( 'N/A', 'woocommerce-shipping-tracking' ), $order_detail_message_additional);
		$order_detail_message_additional = isset($custom_text) && $custom_text != "" && !empty($custom_text) ? str_replace("[additional_custom_text]", $custom_text, $order_detail_message_additional) : str_replace("[additional_custom_text]", __( 'N/A', 'woocommerce-shipping-tracking' ), $order_detail_message_additional);
	}
}
echo '<div class="tracking-box" style="display:block; margin-bottom:20px;">';
echo $order_detail_message.$order_detail_message_additional;
echo '</div>';
?>
	
				