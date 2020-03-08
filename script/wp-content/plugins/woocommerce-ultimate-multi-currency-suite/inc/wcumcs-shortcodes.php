<?php

/**
 * 
 * Plugin: WooCommerce Ultimate Multi Currency Suite
 * Author: http://dev49.net
 *
 * This file contains code responsible for shortcodes
 *
 */

// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}

// Display currency switcher:
function wcumcs_switcher($shortcode_atts = null, $shortcode_content = null){ // parameters only for shortcode
	
	if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){ // if woocommerce not running
		return false; // exit
	}
		
	global $woocommerce_ultimate_multi_currency_suite;
	$default_currency = get_woocommerce_currency();
	
	if (empty($woocommerce_ultimate_multi_currency_suite->settings->session_currency)){ // if no currency stored in session
		$currency = $default_currency;
	} else {
		$currency = $woocommerce_ultimate_multi_currency_suite->settings->session_currency;
	}
	
	$currency_data = $woocommerce_ultimate_multi_currency_suite->settings->get_currency_data(); // get all data on all currencies
	$currency_switcher_text = $woocommerce_ultimate_multi_currency_suite->settings->get_switcher_data('currency_switcher_text'); // get text above currency switcher
	if (function_exists('icl_register_string')){ // register for WPML
		icl_register_string('woocommerce-ultimate-multi-currency-suite', 'Currency switcher text', $currency_switcher_text);
	}
	$currency_switcher_theme = $woocommerce_ultimate_multi_currency_suite->settings->get_switcher_data('currency_switcher_theme'); // get switcher theme
	$currency_switcher_display_template = $woocommerce_ultimate_multi_currency_suite->settings->get_option('currency_switcher_display_template'); // get currency template
	
	$available_currencies = array(); // list of all available currencies
	foreach ($currency_data as $currency_code => $data){ // add all currency codes to this array
		$available_currencies[] = $currency_code;
	}

	$switcher_filter_name = 'wcumcs_currency_switcher_theme_' . $currency_switcher_theme;
	$switcher_filter_default_content = ''; // by default output empty string
	$switcher_filter_parameters = array(
		'theme_id' => $currency_switcher_theme,
		'active_currency' => $currency,
		'available_currencies' => $available_currencies,
		'base_currency' => $default_currency,
		'currencies_data' => $currency_data,
		'currency_switcher_text' => $currency_switcher_text,
		'currency_display_template' => $currency_switcher_display_template
	);

	$currency_switcher_theme_output = apply_filters($switcher_filter_name, $switcher_filter_default_content, $switcher_filter_parameters);

	$currency_switcher_html = apply_filters( // last chance to filter the output (regardless of chosen theme)
		'wcumcs_currency_switcher_html',
		$currency_switcher_theme_output,
		$currency,
		$default_currency,
		$available_currencies,
		$currency_data,
		$currency_switcher_text,
		$currency_switcher_theme
	);
	
	if ($shortcode_atts === null && $shortcode_content === null){ // if function WAS NOT called by a shortcode (arguments not set)...
		echo $currency_switcher_html; // ... just echo the switcher out
		return true; // and end the function
	} else { // if function was called by shortcode (we know this because some arguments were supplied)...
		return $currency_switcher_html; // ... return the switcher instead of echoing it (shortcodes need that)
	}
	
}


// Add conversion shortcode
function wcumcs_convert($shortcode_atts, $shortcode_content = null) { // parameters for shortcode

	if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){ // if woocommerce not running
		return false; // exit
	}

	$base_currency = get_option('woocommerce_currency');
	$active_currency = $base_currency; // temporarily

	// figure out active currency:
	if (!empty($_POST['wcumcs_change_currency_code'])) { // user have manually switched the currency
		$active_currency = $_POST['wcumcs_change_currency_code'];
	} else if (!empty($_COOKIE['wcumcs_user_currency_session'])){
		$active_currency = $_COOKIE['wcumcs_user_currency_session'];
	} else if (!empty($_COOKIE['wcumcs_user_currency_cookie']) && $this->settings->remember_user_currency()){ // user currency from cookie (remember)
		$active_currency = $_COOKIE['wcumcs_user_currency_cookie'];
	} else if ('yes' == get_option('wcumcs_geolocation')){ // if IP geolocation enabled
		$location_info = WC_Geolocation::geolocate_ip(WC_Geolocation::get_ip_address()); // array with country code and state
		$country_code = apply_filters('wcumcs_visitor_country_code', $location_info['country']);
		$country_list = get_option('wcumcs_country_list_data');
		$countries_array = json_decode($country_list, true);
		if (!empty($countries_array[$country_code])){
			$active_currency = $countries_array[$country_code];
		}
	}

	$shortcode_atts = shortcode_atts(
		array(
			'price' => '0',
			'format_price' => 'true', // if false - return just an int/float formatted according to default WC setting (number of decs, dec/thousand seps)
			'round_decimals' => 'false', // this overrides all formatting settings if set to true; if set to false, it is ignored
			'from_currency' => $base_currency,
			'to_currency' => $active_currency
		),
		$shortcode_atts,
		'wcumcs_convert'
	);

	$price = $shortcode_atts['price'];
	$format_price = filter_var($shortcode_atts['format_price'], FILTER_VALIDATE_BOOLEAN); // convert "string booleans" to real booleans
	$round_decimals = filter_var($shortcode_atts['round_decimals'], FILTER_VALIDATE_BOOLEAN); // convert "string booleans" to real booleans
	$from_currency = $shortcode_atts['from_currency'];
	$to_currency = $shortcode_atts['to_currency'];

	// Below is used to create a clean float/int of whatever has been supplied (it figures out the decimal/thousand separators etc.).
	// Solution taken from here: http://php.net/manual/en/function.floatval.php#114486 Thanks!
	$dot_pos = strrpos($price, '.');
	$comma_pos = strrpos($price, ',');
	$sep = (($dot_pos > $comma_pos) && $dot_pos) ? $dot_pos :
		((($comma_pos > $dot_pos) && $comma_pos) ? $comma_pos : false);

	if (!$sep) { // there are no separators in price - let's just make sure it is a correct int/float by removing antything that is not a number
		$price = floatval(preg_replace("/[^0-9]/", "", $price));
	} else { // there is a dot or comma -
		$price = floatval(
			preg_replace("/[^0-9]/", "", substr($price, 0, $sep)) . '.' .
			preg_replace("/[^0-9]/", "", substr($price, $sep + 1, strlen($price)))
		);
	}

	// At this point we have very clean float value in $price, which can be converted later on

	$from_exchange_rate = 1; // assume we are dealing with base currency
	$to_exchange_rate = 1; // assume we are dealing with base currency

	if ($from_currency != $base_currency){ // if not base currency - get exchange rate
		$from_exchange_rate = get_option('wcumcs_exchange_rate_' . $from_currency);
	}

	if ($to_currency != $base_currency){ // if not base currency - get exchange rate
		$to_exchange_rate = get_option('wcumcs_exchange_rate_' . $to_currency);
	}

	$price_base_currency = $price / $from_exchange_rate; // convert price from shortcode attribute to base currency
	$converted_price = $price_base_currency * $to_exchange_rate; // convert the price from base currency to target currency

	$negative = $converted_price < 0;
	$converted_price = floatval($negative ? $converted_price * -1 : $converted_price);

	if ($round_decimals === true){
		$converted_price = round($converted_price);
	}

	$price_to_display = $converted_price;

	$number_of_decimals = wc_get_price_decimals();
	$decimal_separator = wc_get_price_decimal_separator();
	$thousand_separator = wc_get_price_thousand_separator();
	$position = get_option('woocommerce_currency_pos');
	$symbol = get_woocommerce_currency_symbol($to_currency);

	if ($format_price == true){ // we only need currency data if we are formatting the price

		if ($to_currency != $base_currency){ // if target currency is NOT base currency, we need to get its data from plugin settings
			$available_currencies_json = get_option('wcumcs_available_currencies'); // here we have all currencies data EXCEPT exchange rate
			$available_currencies = json_decode($available_currencies_json, true);
			if (empty($available_currencies)){ // something went wrong...
				return false;
			}
			$to_currency_data = $available_currencies[$to_currency];
			$number_of_decimals = $to_currency_data['number_decimals'];
			$decimal_separator = $to_currency_data['decimal_separator'];
			$thousand_separator = $to_currency_data['thousand_separator'];
			$position = $to_currency_data['position'];
			$symbol = $to_currency_data['symbol'];
		}

		// Now we can fully format the price (with currency symbol):
		$format = '%1$s%2$s';
		switch ($position){
			case 'left':
				$format = '%1$s%2$s';
				break;
			case 'right':
				$format = '%2$s%1$s';
				break;
			case 'left_space':
				$format = '%1$s&nbsp;%2$s';
				break;
			case 'right_space':
				$format = '%2$s&nbsp;%1$s';
				break;
		}

		if ($round_decimals === true){
			$number_of_decimals = 0;
		}

		$price_to_display = number_format($converted_price, $number_of_decimals, $decimal_separator, $thousand_separator);
		$price_to_display = ($negative ? '-' : '') . sprintf($format, $symbol, $price_to_display);

	} else {

		if ($round_decimals === true){
			$number_of_decimals = 0;
		}

		$price_to_display = number_format($converted_price, $number_of_decimals, $decimal_separator, $thousand_separator);

	}

	return $price_to_display;

}
