<?php

/**
 * Plugin Name: WooCommerce Ultimate Multi Currency Suite
 * Version: 1.7
 * Plugin URI: http://dev49.net
 * Description: Multi currency e-commerce plugin for WordPress-WooCommerce systems.
 * Tags: woocommerce, currency, multi currency, multi-currency, woocommerce multi currency, woocommerce currency, multiple currencies, currency switcher, currency converter
 * Author: Dev49.net
 * Author URI: http://dev49.net
 * Requires at least: 4.5
 * Tested up to: 4.5.3
 * WC requires at least: 2.5.0
 * WC tested up to: 2.6.2
 */


/** WooCommerce Ultimate Multi Currency Suite **/


// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}


//define('WCUMCS_DEBUG', true);


// Require all classes and scripts:
require('inc/class-wcumcs-main.php'); // main plugin class (kind of a wrapper)
require('inc/class-wcumcs-frontend.php'); // frontend plugin class (for website visitors)
require('inc/class-wcumcs-admin.php'); // back-end plugin class (for site admin)
require('inc/class-wcumcs-callbacks.php'); // callbacks (updating rates, restoring settings / ajax functionality)
require('inc/class-wcumcs-settings.php'); // settings class (for loading/verifying data)
require('inc/class-wcumcs-widget.php'); // currency switcher widget class
require('inc/class-wcumcs-update-notifier.php'); // update notifier class
require('inc/wcumcs-shortcodes.php'); // shortcodes, including currency switcher display
require('inc/wcumcs-switcher-themes.php'); // currency switcher themes
require('inc/wcumcs-cron.php'); // cron job


if (empty($woocommerce_ultimate_multi_currency_suite)){
    $woocommerce_ultimate_multi_currency_suite = new WooCommerce_Ultimate_Multi_Currency_Suite_Main(__FILE__); // Initiate the plugin by instantiating main class (we're passing the plugin root path)
}