<?php


/**
 * 
 * Plugin: WooCommerce Ultimate Multi Currency Suite
 * Author: http://dev49.net
 *
 * WooCommerce_Ultimate_Multi_Currency_Suite_Callbacks class is a class for handling callbacks/ajax.
 *
 * This class is responsible for receiving and executing actions called by ajax requests or from cron or from other classes.
 *
 */

// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}

class WooCommerce_Ultimate_Multi_Currency_Suite_Callbacks {
	
	
	private $settings; // we're going to assign Settings object to this property
	
	
	/**
	 * Initiate object: add appropriate WP filters, register callbacks
	 */
	public function __construct($settings){ // $settings = instance of WooCommerce_Ultimate_Multi_Currency_Suite_Settings
		
		// Assign settings object to class property, so we can easily access it from other methods:
		$this->settings = $settings;
		
		// Add WP hooks:		
		if (is_admin()){
			add_action('wp_ajax_wcumcs_ajax', array($this, 'ajax_request'));
			add_action('wp_ajax_nopriv_wcumcs_ajax', array($this, 'ajax_request'));
		}
		
	}
	
	
	/**
	 * This method receives all callback requests (ajax only)
	 */
	public function ajax_request(){
		
		check_ajax_referer('woocommerce-ultimate-multi-currency-suite-nonce', 'verification', true); // die if nonce incorrect
		
		$action = ''; // action to be performed
		
		// make sure it's our own ajax request:
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// if we got here, it means that the ajax request is valid
			$action = $_POST['execute'];	
		}
		
		$action_data = array();
		
		if (empty($action)){ // die - empty request for some reason
			exit;
		} else if ($action == 'restore_defaults'){ // execute restore defaults
			$action_data['name'] = 'restore_defaults'; 
		} else if ($action == 'update_exchange_rates'){ // update one or more exchange rates
			$action_data['name'] = 'update_exchange_rates';
			$action_data['currency_data'] = $_POST['currency_data'];
		} else if ($action == 'get_currency_hash'){
			$action_data['name'] = 'get_currency_hash';
		} else if ($action == 'set_variations_bulk_prices'){
			$action_data['name'] = 'set_variations_bulk_prices';
			$action_data['data'] = $_POST['action_data'];
		} else {
			exit;
		}
		
		$action_result = $this->execute_action($action_data);
		
		echo $action_result;
		exit;
		
	}
	
	
	/**
	 * This method executes all actions (from cron and ajax)
	 */
	public function execute_action($action_data, $cron_execution = false){
		
		if (empty($action_data)){
		
			exit;
		
		} else if ($action_data['name'] == 'restore_defaults'){
			
			if (!current_user_can('edit_shop_orders')){ // check permissions first
				exit;
			}
			
			if ($this->settings->restore_defaults() == true){ // let's run restore_defaults method in settings class
				// Default restored, let's inform user about it:
				$action_result = __("Default settings have been successfully restored.", 'woocommerce-ultimate-multi-currency-suite');
				return $action_result;		
			} else {
				exit; // true wasn't returned for some reason - let's exit
			}			
			
		} else if ($action_data['name'] == 'update_exchange_rates') {		
			
			if (!current_user_can('edit_shop_orders')){ // check permissions first
				exit;
			}	
			
			$currency_data = $action_data['currency_data']; // assign to an easier to use array name
			$action_result = $this->settings->update_exchange_rates($currency_data, $cron_execution); // execute update and save to $action_result what this method returned (array)
			$action_result_json = json_encode($action_result);
			
			return $action_result_json;
		
		} else if ($action_data['name'] == 'get_currency_hash'){
			
			$currency_hash = $this->settings->get_currency_hash();
			return $currency_hash;
		
		} else if ($action_data['name'] == 'set_variations_bulk_prices'){ // edit multi-currency prices in bulk

			if (!current_user_can('edit_products')){ // check permissions first
				exit;
			}

			$bulk_action = wc_clean($action_data['data']['bulk_action']);
			$product_id = absint($action_data['data']['product_id']);
			$product_type = wc_clean($action_data['data']['product_type']);
			$currency_code = wc_clean($action_data['data']['currency_code']);
			$value = wc_clean($action_data['data']['value']);

			if ($product_type != 'variable'){ // for some reason we are not editing variable product
				exit;
			}

			if (empty($value) && $value !== '0'){ // nothing specified (different than 0)
				exit;
			}

			// now that we know the value is not empty, we should make sure it's a float:
			$value = floatval($value);

			$variations_ids = get_posts(array( // get array of ids (ints) of variations of the product
				'post_parent' => $product_id,
				'posts_per_page' => -1,
				'post_type' => 'product_variation',
				'fields' => 'ids',
				'post_status' => array('publish', 'private')
			));

			if (!empty($variations_ids)){ // if there are some variations, we can proceed with saving variations multi-currency prices
				if ($bulk_action == 'set_variable_regular_price'){
					$meta_key = '_wcumcs_regular_price_' . $currency_code;
				} else if ($bulk_action == 'set_variable_sale_price') {
					$meta_key = '_wcumcs_sale_price_' . $currency_code;
				} else {
					exit;
				}
				$meta_value = esc_attr($value);
				// now we have the meta key and meta value (price), so we can loop through variations and update them:
				foreach ($variations_ids as $variation_id){
					update_post_meta($variation_id, $meta_key, $meta_value); // update data
				}
				return true; // variations update has been successful
			} else { // there are no variations
				exit;
			}

		} else {
		
			exit;
		
		}
		
	}
	
	
}