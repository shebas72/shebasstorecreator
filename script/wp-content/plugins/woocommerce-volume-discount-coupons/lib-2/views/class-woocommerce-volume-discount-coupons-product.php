<?php
/**
 * class-woocommerce-volume-discount-product.php
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
 * Adds volume discount coupon description to products.
 */
class WooCommerce_Volume_Discount_Coupons_Product {

	/** 
	 * Registers our display handler.
	 */
	public static function init() {
		// Rendering our info can be problematic when it contains links
		// to products or categories and is displayed after the price
		// using this hook. It can be problematic because the price
		// may be displayed within a link.
		//add_filter( 'woocommerce_get_price_html', array( __CLASS__, 'woocommerce_get_price_html' ), 10, 2 );
		add_filter( 'woocommerce_loop_add_to_cart_link', array( __CLASS__, 'woocommerce_loop_add_to_cart_link' ), 1000 );
		add_action( 'woocommerce_after_add_to_cart_form', array( __CLASS__, 'woocommerce_after_add_to_cart_form' ), 1000 );
	}

	/**
	 * Add info on prices.
	 * Not used.
	 * @param string $price
	 * @param WC_Product $product
	 * @return string
	 */
	public static function woocommerce_get_price_html( $price, $product ) {
		return $price . self::render_info($product);
	}

	/**
	 * Hook for single product pages.
	 * Echoes coupon description / info.
	 */
	public static function woocommerce_after_add_to_cart_form() {
		global $product;
	
		$output = '';
		if ( !empty( $product ) ) {
			$output .= self::render_info( $product );
		}
		echo $output;
	}

	/**
	 * Hook for products in the loop.
	 * Return coupon description/info appended to link.
	 * @param string $link
	 * @return string
	 */
	public static function woocommerce_loop_add_to_cart_link( $link ) {
		global $product;
		$output = '';
		if ( !empty( $product ) ) {
			$output .= self::render_info( $product );
		}
		return $link . $output;
	}

	/**
	 * Render coupon description/info for product.
	 * @param WC_Product $product
	 * @return string
	 */
	public static function render_info( $product ) {

		global $wpdb;

		$output = '';

		// Get all coupons that want to modify their display,
		// i.e. those that have _vd_description_display or
		// _vd_info_display set.
		$coupons = $wpdb->get_results(
			"SELECT DISTINCT ID, post_title FROM $wpdb->posts " .
			"LEFT JOIN $wpdb->postmeta ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id " .
			"WHERE TRUE " .
			"AND {$wpdb->posts}.post_type = 'shop_coupon' " .
			"AND {$wpdb->posts}.post_status = 'publish' " .
			"AND " .
			"( " .
			"{$wpdb->postmeta}.meta_key = '_vd_description_display' " .
			"OR " .
			"{$wpdb->postmeta}.meta_key = '_vd_info_display' " .
			") "
		);
		if ( $coupons && ( count( $coupons ) > 0 ) ) {
			$product_term_ids = array_map( 'intval', wp_get_post_terms( $product->id, 'product_cat', array( 'fields' => 'ids' ) ) );
			foreach ( $coupons as $coupon ) {
				$show_description   = false;
				$show_info          = false;
				$coupon_product_ids = array_map( 'intval', get_post_meta( $coupon->ID, '_vd_product_ids', false ) );
				$coupon_term_ids    = array_map( 'intval', get_post_meta( $coupon->ID, '_vd_term_ids', false ) );

				// Check if the coupon applies to the product or it is within
				// its related product categories.
				if ( in_array( intval( $product->id ), $coupon_product_ids ) ||
					( count( array_intersect( $product_term_ids, $coupon_term_ids ) ) > 0 )
				) {
					$description_display = get_post_meta( $coupon->ID, '_vd_description_display', false );
					$info_display        = get_post_meta( $coupon->ID, '_vd_info_display', false );
					$show_description_anywhere = in_array( 'anywhere', $description_display );
					$show_info_anywhere        = in_array( 'anywhere', $info_display );
					if ( is_product() ) {
						$show_description = $show_description_anywhere || in_array( 'single', $description_display );
						$show_info = $show_info_anywhere || in_array( 'single', $info_display );
					}
					if ( is_product_category() ) {
						$show_description = $show_description_anywhere || in_array( 'product_cat', $description_display );
						$show_info = $show_info_anywhere || in_array( 'product_cat', $info_display );
					}
					if ( is_product_tag() ) {
						$show_description = $show_description_anywhere || in_array( 'product_tag', $description_display );
						$show_info = $show_info_anywhere || in_array( 'product_tag', $info_display );
					}
					if ( is_post_type_archive( 'product' ) ) {
						$show_description = $show_description_anywhere || in_array( 'archive', $description_display );
						$show_info = $show_info_anywhere || in_array( 'archive', $info_display );
					}
					if ( is_shop() ) {
						$show_description = $show_description_anywhere || in_array( 'shop', $description_display );
						$show_info = $show_info_anywhere || in_array( 'shop', $info_display );
					}
					if ( $show_description || $show_info ) {
						$output .= self::inline_styles();
						$coupon = new WC_Coupon( $coupon->post_title );
						if ( $coupon->id ) {
							if ( $show_description ) {
								if ( $post = get_post( $coupon->id ) ) {
									if ( !empty( $post->post_excerpt ) ) {
										$output .= sprintf( '<div class="coupon display description %s">', wp_strip_all_tags( $coupon->code ) );
										$output .= stripslashes( wp_filter_kses( $post->post_excerpt ) );
										$output .= '</div>';
									}
								}
							}
							if ( $show_info ) {
								$output .= sprintf( '<div class="coupon display volume-discount %s">', wp_strip_all_tags( $coupon->code ) );
								$output .= WooCommerce_Volume_Discount_Coupons_Shortcodes::get_volume_discount_info( $coupon );
								$output .= '</div>';
							}
						}
					}
				}
			}
		}
		return $output;
	}

	/**
	 * Renders inline styles once.
	 * @return string
	 */
	public static function inline_styles() {
		global $woocommerce_volume_discount_coupons_inline_styles;
		$output = '';
		if ( !isset( $woocommerce_volume_discount_coupons_inline_styles ) ) {
			$options = get_option( 'woocommerce-volume-discount-coupons', array() );
			if ( !isset( $options['add-inline-display-styles'] ) || $options['add-inline-display-styles'] ) { // do render by default
				$css = isset( $options['inline-display-styles'] ) ? $options['inline-display-styles'] : null;
				if ( $css === null ) {
					require_once( WOO_VOLDISC_ADMIN_LIB . '/class-woocommerce-volume-discount-coupons-admin.php' );
					$css = WooCommerce_Volume_Discount_Coupons_Admin::CSS;
				}
				if ( !empty( $css ) ) {
					$output .= '<style type="text/css">';
					$output .= wp_strip_all_tags( stripslashes( $css ), true );
					$output .= '</style>';
				}
			}
			$woocommerce_volume_discount_coupons_inline_styles = true;
		}
		return $output;
	}

}
WooCommerce_Volume_Discount_Coupons_Product::init();
