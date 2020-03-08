<?php
/**
 * class-woocommerce-volume-discount-coupons.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package woocommerce-volume-discount-coupons
 * @since woocommerce-volume-discount-coupons 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boots.
 */
class WooCommerce_Volume_Discount_Coupons {

	private static $admin_messages = array();

	/**
	 * Put hooks in place and activate.
	 */
	public static function init() {
		//register_activation_hook( WOO_VOLDISC_FILE, array( __CLASS__, 'activate' ) );
		//register_deactivation_hook( WOO_VOLDISC_FILE, array( __CLASS__, 'deactivate' ) );
		//register_uninstall_hook( WOO_VOLDISC_FILE, array( __CLASS__, 'uninstall' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		include_once WOO_VOLDISC_CORE_LIB . '/class-woocommerce-volume-discount-coupons-update.php';
		if ( self::check_dependencies() ) {
			require_once( WOO_VOLDISC_CORE_LIB . '/class-woocommerce-volume-discount-coupons-coupon.php' );
			require_once( WOO_VOLDISC_VIEWS_LIB . '/class-woocommerce-volume-discount-coupons-shortcodes.php' );
			if ( !is_admin() ) {
				require_once( WOO_VOLDISC_VIEWS_LIB . '/class-woocommerce-volume-discount-coupons-product.php' );
			} else {
				require_once( WOO_VOLDISC_ADMIN_LIB . '/class-woocommerce-volume-discount-coupons-admin.php' );
			}
		}
	}
	
	/**
	 * Loads translations.
	 */
	public static function wp_init() {
		load_plugin_textdomain( WOO_VOLDISC_PLUGIN_DOMAIN, null, 'woocommerce-volume-discount-coupons/languages' );
	}

	/**
	 * Activate plugin.
	 * Reschedules pending tasks.
	 * @param boolean $network_wide
	 */
	public static function activate( $network_wide = false ) {
	}

	/**
	 * Deactivate plugin.
	 * @param boolean $network_wide
	 */
	public static function deactivate( $network_wide = false ) {
	}

	/**
	 * Uninstall plugin.
	 */
	public static function uninstall() {
	}

	/**
	 * Prints admin notices.
	 */
	public static function admin_notices() {
		if ( !empty( self::$admin_messages ) ) {
			foreach ( self::$admin_messages as $msg ) {
				echo $msg;
			}
		}
	}

	/**
	 * Check plugin dependencies and nag if they are not met.
	 * @param boolean $disable disable the plugin if true, defaults to false
	 */
	public static function check_dependencies( $disable = false ) {
		$result = true;
		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}
		$woocommerce_is_active = in_array( 'woocommerce/woocommerce.php', $active_plugins );
		if ( !$woocommerce_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( '<em>WooCommerce Volume Discount Coupons</em> needs the <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> plugin. Please install and activate it.', WOO_VOLDISC_PLUGIN_DOMAIN ) . "</div>";
		}
		if ( !$woocommerce_is_active ) {
			if ( $disable ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				deactivate_plugins( array( __FILE__ ) );
			}
			$result = false;
		}
		return $result;
	}
}
WooCommerce_Volume_Discount_Coupons::init();
