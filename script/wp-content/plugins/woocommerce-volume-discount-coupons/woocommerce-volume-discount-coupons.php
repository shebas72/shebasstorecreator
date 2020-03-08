<?php
/**
 * woocommerce-volume-discount-coupons.php
 *
 * Copyright (c) 2013-2017 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package woocommerce-volume-discount-coupons
 * @since woocommerce-volume-discount-coupons 1.0.0
 *
 * Plugin Name: WooCommerce Volume Discount Coupons
 * Plugin URI: http://www.itthinx.com/plugins/woocommerce-volume-discount-coupons
 * Description: Volume Discount Coupons for WooCommerce <a href="http://www.itthinx.com/documentation/woocommerce-volume-discount-coupons/">Documentation</a> | <a href="http://www.itthinx.com/plugins/woocommerce-volume-discount-coupons/">Plugin page</a>
 * Version: 1.3.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WOO_VOLDISC_PLUGIN_VERSION', '1.3.0' );
define( 'WOO_VOLDISC_PLUGIN_DOMAIN', 'woocommerce-volume-discount-coupons' );
define( 'WOO_VOLDISC_FILE', __FILE__ );
define( 'WOO_VOLDISC_LOG', false );
define( 'WOO_VOLDISC_CORE_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WOO_VOLDISC_PLUGIN_URL', plugins_url( 'woocommerce-volume-discount-coupons' ) );
function woo_voldisc_plugins_loaded() {
	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0' ) >= 0 ) {
		$lib = '/lib';
	} else {
		$lib = '/lib-2';
	}
	define( 'WOO_VOLDISC_CORE_LIB', WOO_VOLDISC_CORE_DIR . $lib . '/core' );
	define( 'WOO_VOLDISC_ADMIN_LIB', WOO_VOLDISC_CORE_DIR . $lib . '/admin' );
	define( 'WOO_VOLDISC_VIEWS_LIB', WOO_VOLDISC_CORE_DIR . $lib . '/views' );

	require_once( WOO_VOLDISC_CORE_LIB . '/class-woocommerce-volume-discount-coupons.php');
}
add_action( 'plugins_loaded', 'woo_voldisc_plugins_loaded' );
