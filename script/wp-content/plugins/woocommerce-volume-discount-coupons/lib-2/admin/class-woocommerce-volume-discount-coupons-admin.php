<?php
/**
 * class-woocommerce-volume-discount-coupons-admin.php
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
 * Settings.
 */
class WooCommerce_Volume_Discount_Coupons_Admin {

	const NONCE = 'woocommerce-volume-discount-coupons-admin-nonce';
	
	const CSS =
'.coupon.display.description,
.coupon.display.volume-discount {
	background-color: #f7f7f7;
	border: 2px dashed #E0E0E0;
	border-radius: 3px;
	margin-top: 6px;
	padding: 4px;
}
';

	/**
	 * Admin setup.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 40 );
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {
		$admin_page = add_submenu_page(
			'woocommerce',
			__( 'Volume Discount Coupons' ),
			__( 'Volume Discount Coupons' ),
			'manage_woocommerce',
			'woocommerce_volume_discount_coupons',
			array( __CLASS__, 'woocommerce_volume_discount_coupons' )
		);
// 		add_action( 'admin_print_scripts-' . $admin_page, array( __CLASS__, 'admin_print_scripts' ) );
// 		add_action( 'admin_print_styles-' . $admin_page, array( __CLASS__, 'admin_print_styles' ) );
	}

	/**
	 * Renders the admin section.
	 */
	public static function woocommerce_volume_discount_coupons() {

		if ( !current_user_can( 'manage_woocommerce' ) ) {
			wp_die( __( 'Access denied.', WOO_VOLDISC_PLUGIN_DOMAIN ) );
		}

		$options = get_option( 'woocommerce-volume-discount-coupons', null );
		if ( $options === null ) {
			if ( add_option( 'woocommerce-volume-discount-coupons', array(), null, 'no' ) ) {
				$options = get_option( 'woocommerce-volume-discount-coupons' );
			}
		}

		if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST[self::NONCE], 'set' ) ) {
				$options['add-inline-display-styles']  = isset( $_POST['add-inline-display-styles'] );
				$options['inline-display-styles']      = !empty( $_POST['inline-display-styles'] ) ? $_POST['inline-display-styles'] : '';
				update_option( 'woocommerce-volume-discount-coupons', $options );
			}
		}

		$add_inline_display_styles  = isset( $options['add-inline-display-styles'] ) ? $options['add-inline-display-styles'] : true;
		$inline_display_styles      = !empty( $options['inline-display-styles'] ) ? $options['inline-display-styles'] : self::CSS;

		echo '<div class="woocommerce-volume-discount-coupons">';

		echo '<h2>' . __( 'Volume Discount Coupons', WOO_VOLDISC_PLUGIN_DOMAIN ) . '</h2>';

		echo '<form action="" name="options" method="post">';
		echo '<div>';

		echo '<p>';
		echo '<label>';
		printf( '<input name="%s" type="checkbox" %s />', 'add-inline-display-styles', $add_inline_display_styles ? ' checked="checked" ' : '' );
		echo ' ';
		_e( 'Use inline styles', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">';
		_e( 'When this option is enabled, the inline styles are used when the coupon description or volume discount info is displayed.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';
		
		echo '<p>';
		echo '<label>';
		_e( 'Inline styles', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '<br/>';
		printf( '<textarea style="font-family:monospace;width:50%%;height:20em;" name="%s">%s</textarea>', 'inline-display-styles', stripslashes( esc_textarea( $inline_display_styles ) ) );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">';
		echo __( 'The default inline style is:', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';
		echo '<p>';
		echo '<code style="display:block;background-color:#eee;color:#111;padding:1em;margin:1em;">';
		echo esc_html( self::CSS );
		echo '</code>';
		echo '</p>';

		echo '<p>';
		echo wp_nonce_field( 'set', self::NONCE, true, false );
		echo '<input class="button" type="submit" name="submit" value="' . __( 'Save', WOO_VOLDISC_PLUGIN_DOMAIN ) . '"/>';
		echo '</p>';
		echo '</div>';

		echo '</form>';

		echo '</div>';

	}
}
WooCommerce_Volume_Discount_Coupons_Admin::init();
