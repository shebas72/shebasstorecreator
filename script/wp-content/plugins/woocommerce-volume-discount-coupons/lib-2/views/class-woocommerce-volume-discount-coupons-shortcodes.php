<?php
/**
 * class-woocommerce-volume-discount-coupons-shortcodes.php
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
 * Shortcodes.
 */
class WooCommerce_Volume_Discount_Coupons_Shortcodes {

	/**
	 * Adds shortcodes.
	 */
	public static function init() {
		if ( !shortcode_exists( 'coupon_is_valid' ) ) {
			add_shortcode( 'coupon_is_valid', array( __CLASS__, 'coupon_is_valid' ) );
		}
		if ( !shortcode_exists( 'coupon_is_not_valid' ) ) {
			add_shortcode( 'coupon_is_not_valid', array( __CLASS__, 'coupon_is_not_valid' ) );
		}
		if ( !shortcode_exists( 'coupon_code' ) ) {
			add_shortcode( 'coupon_code', array( __CLASS__, 'coupon_code' ) );
		}
		if ( !shortcode_exists( 'coupon_description' ) ) {
			add_shortcode( 'coupon_description', array( __CLASS__, 'coupon_description' ) );
		}
		if ( !shortcode_exists( 'coupon_volume_discount' ) ) {
			add_shortcode( 'coupon_volume_discount', array( __CLASS__, 'coupon_volume_discount' ) );
		}
		add_shortcode( 'volume_discount_coupon', array( __CLASS__, 'volume_discount_coupon' ) );
		add_shortcode( 'volume_discounts_coupon', array( __CLASS__, 'volume_discount_coupon' ) );
		add_shortcode( 'volume_discount_coupons', array( __CLASS__, 'volume_discount_coupon' ) );
		add_shortcode( 'volume_discounts_coupons', array( __CLASS__, 'volume_discount_coupon' ) );
	}

	/**
	 * Evaluate common validity based on op and coupon codes.
	 * 
	 * @param array $atts
	 * @return boolean
	 */
	private static function _is_valid( $atts ) {
		$options = shortcode_atts(
			array(
				'coupon' => null,
				'code'   => null,
				'op'     => 'and'
			),
			$atts
		);

		$code = null;
		if ( !empty( $options['code'] ) ) {
			$code = $options['code'];
		} else if ( !empty( $options['coupon'] ) ) {
			$code = $options['coupon'];
		}
		if ( $code === null ) {
			return '';
		}

		$codes = array_map( 'trim', explode( ',', $code ) );

		$validities = array();
		foreach ( $codes as $code ) {
			$coupon = new WC_Coupon( $code );
			if ( $coupon->id ) {
				$validities[] = $coupon->is_valid();
			}
		}

		if ( count( $validities ) > 0 ) {
			$valid = ( $options['op'] != 'or' );
			foreach( $validities as $validity ) {
				if ( $options['op'] == 'or' ) {
					$valid = $valid || $validity;
					if ( $valid ) {
						break;
					}
				} else {
					$valid = $valid && $validity;
					if ( !$valid ) {
						break;
					}
				}
			}
		} else {
			$valid = false;
		}
	}

	/**
	 * Conditionally render content based on coupon validity.
	 * 
	 * Takes a comma-separated list of coupon codes as coupon or code attribute.
	 * 
	 * The op attribute determines whether all codes must be valid (and) or
	 * any code can be valid (or) for the content to be rendered.
	 * 
	 * @param array $atts attributes
	 * @param string $content content to render
	 * @return string
	 */
	public static function coupon_is_valid( $atts, $content = null ) {
		$output = '';
		if ( !empty( $content ) ) {
			$valid = self::_is_valid( $atts );
			if ( $valid ) {
				remove_shortcode( 'coupon_is_valid' );
				$content = do_shortcode( $content );
				add_shortcode( 'coupon_is_valid', array( __CLASS__, 'coupon_is_valid' ) );
				$output = $content;
			}
		}
		return $output;
	}

	/**
	 * Conditionally render content based on coupon non-validity.
	 *
	 * Takes a comma-separated list of coupon codes as coupon or code attribute.
	 *
	 * The op attribute determines whether all codes must be valid (and) or
	 * any code can be valid (or) for the content to be rendered.
	 *
	 * @param array $atts attributes
	 * @param string $content content to render
	 * @return string
	 */
	public static function coupon_is_not_valid( $atts, $content = null ) {
		$output = '';
		if ( !empty( $content ) ) {
			$valid = !self::_is_valid( $atts );
			if ( $valid ) {
				remove_shortcode( 'coupon_is_not_valid' );
				$content = do_shortcode( $content );
				add_shortcode( 'coupon_is_not_valid', array( __CLASS__, 'coupon_is_not_valid' ) );
				$output = $content;
			}
		}
		return $output;
	}

	/**
	 * Renders the code(s) of coupon(s).
	 *
	 * @param array $atts
	 * @param string $content not used
	 * @return string
	 */
	public static function coupon_code( $atts, $content = null ) {
		$output = '';
		$options = shortcode_atts(
			array(
				'coupon'    => null,
				'code'      => null,
				'separator' => ' '
			),
			$atts
		);

		$code = null;
		if ( !empty( $options['code'] ) ) {
			$code = $options['code'];
		} else if ( !empty( $options['coupon'] ) ) {
			$code = $options['coupon'];
		}
		if ( $code === null ) {
			return '';
		}
		$codes = array_map( 'trim', explode( ',', $code ) );
		foreach ( $codes as $code ) {
			$coupon = new WC_Coupon( $code );
			if ( $coupon->id ) {
				$output .= sprintf( '<span class="coupon code %s">', wp_strip_all_tags( $coupon->code ) );
				$output .= wp_strip_all_tags( $coupon->code );
				$output .= '</span>';
				$output .= stripslashes( wp_filter_kses( $options['separator'] ) );
			}
		}
		return $output;
	}

	/**
	 * Renders the description(s) of coupon(s).
	 * 
	 * @param array $atts
	 * @param string $content not used
	 * @return string
	 */
	public static function coupon_description( $atts, $content = null ) {
		$output = '';
		$options = shortcode_atts(
			array(
				'coupon'    => null,
				'code'      => null,
				'separator' => ' '
			),
			$atts
		);

		$code = null;
		if ( !empty( $options['code'] ) ) {
			$code = $options['code'];
		} else if ( !empty( $options['coupon'] ) ) {
			$code = $options['coupon'];
		}
		if ( $code === null ) {
			return '';
		}
		$codes = array_map( 'trim', explode( ',', $code ) );
		foreach ( $codes as $code ) {
			$coupon = new WC_Coupon( $code );
			if ( $coupon->id ) {
				if ( $post = get_post( $coupon->id ) ) {
					if ( !empty( $post->post_excerpt ) ) {
						$output .= sprintf( '<span class="coupon description %s">', wp_strip_all_tags( $coupon->code ) );
						$output .= stripslashes( wp_filter_kses( $post->post_excerpt ) );
						$output .= '</span>';
						$output .= stripslashes( wp_filter_kses( $options['separator'] ) );
					}
				}
			}
		}
		return $output;
	}

	/**
	 * Renders information about the volume discount for coupon(s).
	 *
	 * @param array $atts
	 * @param string $content not used
	 * @return string
	 */
	public static function coupon_volume_discount( $atts, $content = null ) {
		$output = '';
		$options = shortcode_atts(
			array(
				'coupon'    => null,
				'code'      => null,
				'separator' => ' '
			),
			$atts
		);
		$code = null;
		if ( !empty( $options['code'] ) ) {
			$code = $options['code'];
		} else if ( !empty( $options['coupon'] ) ) {
			$code = $options['coupon'];
		}
		if ( $code === null ) {
			return '';
		}
		$codes = array_map( 'trim', explode( ',', $code ) );
		foreach ( $codes as $code ) {
			$coupon = new WC_Coupon( $code );
			if ( $coupon->id ) {
				$output .= sprintf( '<span class="coupon volume-discount %s">', wp_strip_all_tags( $coupon->code ) );
				$output .= self::get_volume_discount_info( $coupon, $atts );
				$output .= '</span>';
				$output .= stripslashes( wp_filter_kses( $options['separator'] ) );
			}
		}
		return $output;
	}

	/**
	 * Returns a description of the volume discount.
	 *
	 * @param WC_Coupon $coupon
	 * @return string HTML describing the discount
	 */
	public static function get_volume_discount_info( $coupon, $atts = array() ) {
		$product_delimiter = isset( $atts['product_delimiter'] ) ? $atts['product_delimiter'] : ', ';
		$category_delimiter = isset( $atts['category_delimiter'] ) ? $atts['category_delimiter'] : ', ';
		$product_category_delimiter = isset( $atts['product_category_delimiter'] ) ? $atts['product_category_delimiter'] : __( ', ', WOO_VOLDISC_PLUGIN_DOMAIN );
		$show_using_code = isset( $atts['show_using_code'] ) ? $atts['show_using_code'] : true;

		$result = '';

		$amount_suffix = get_woocommerce_currency_symbol();
		if ( function_exists( 'wc_price' ) ) {
			$amount_suffix = null;
		}
		switch( $coupon->type ) {
			case 'percent' :
			case 'percent_product' :
				$amount_suffix = '%';
				break;
		}

		$vd_product_ids = get_post_meta( $coupon->id, '_vd_product_ids', false );
		$vd_term_ids = get_post_meta( $coupon->id, '_vd_term_ids', false );
		$min         = get_post_meta( $coupon->id, '_vd_min', true );
		$max         = get_post_meta( $coupon->id, '_vd_max', true );
		$auto        = get_post_meta( $coupon->id, '_vd_auto', true );

		$vd_products = array();
		foreach( $vd_product_ids as $product_id ) {
			$product = get_product( $product_id );
			if ( $product ) {
				$vd_products[] = sprintf(
					'<span class="product-link"><a href="%s">%s</a></span>',
					esc_url( get_permalink( $product_id ) ),
					$product->get_title()
				);
			}
		}

		$vd_terms = array();
		foreach( $vd_term_ids as $term_id ) {
			if ( $term = get_term_by( 'id', $term_id, 'product_cat' ) ) {
				$vd_terms[] = sprintf(
					'<span class="product-link"><a href="%s">%s</a></span>',
					get_term_link( $term->slug, 'product_cat' ),
					esc_html( $term->name )
				);
			}
		}

		$products = array();
		$categories = array();
		switch ( $coupon->type ) {
			case 'fixed_product' :
			case 'percent_product' :
				if ( sizeof( $coupon->product_ids ) > 0 ) {
					foreach( $coupon->product_ids as $product_id ) {
						$product = get_product( $product_id );
						if ( $product ) {
							$products[] = sprintf(
								'<span class="product-link"><a href="%s">%s</a></span>',
								esc_url( get_permalink( $product_id ) ),
								$product->get_title()
							);
						}
					}
				}
				if ( sizeof( $coupon->product_categories ) > 0 ) {
					foreach( $coupon->product_categories as $term_id ) {
						if ( $term = get_term_by( 'id', $term_id, 'product_cat' ) ) {
							$categories[] = sprintf(
								'<span class="product-link"><a href="%s">%s</a></span>',
								get_term_link( $term->slug, 'product_cat' ),
								esc_html( $term->name )
							);
						}
					}
				}
				break;
		}

		$last = null;
		$n = count( $products );
		if ( $n >= 2 ) {
			$last = array_pop( $products );
		}
		$products_list = implode( $product_delimiter, $products );
		if ( $last !== null ) {
			$products_list .= sprintf( __( ' or %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $last );
		}

		$last = null;
		$n = count( $categories );
		if ( $n >= 2 ) {
			$last = array_pop( $categories );
		}
		$categories_list = implode( $category_delimiter, $categories );
		if ( $last !== null ) {
			$categories_list .= sprintf( __( ' or %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $last );
		}

		$discount= '';
		$amount = $coupon->amount;
		if ( $amount_suffix === null ) {
			$amount = wc_price( $amount );
			$amount_suffix = '';
		}
		switch ( $coupon->type ) {
			case 'fixed_product' :
			case 'percent_product' :
				if ( sizeof( $coupon->product_ids ) > 0 ) {
					if ( count( $products ) > 0 ) {
						$discount = sprintf( __( '%s%s discount on %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix, $products_list );
					} else {
						$discount = sprintf( __( '%s%s discount on selected products', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix );
					}
				} else if ( sizeof( $coupon->product_categories ) > 0 ) {
					$discount = sprintf( __( '%s%s discount in %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix, $categories_list );
				} else if ( sizeof( $coupon->exclude_product_ids ) > 0 || sizeof( $coupon->exclude_product_categories ) > 0 ) {
					$discount = sprintf( __( '%s%s discount on selected products', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix );
				} else {
					$discount = sprintf( __( '%s%s discount', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix );
				}
				break;
			case 'fixed_cart' :
			case 'percent' :
				$discount = sprintf( __( '%s%s cart discount', WOO_VOLDISC_PLUGIN_DOMAIN ), $amount, $amount_suffix );
				break;
		}

		$last = null;
		$n = count( $vd_products );
		if ( $n >= 2 ) {
			$last = array_pop( $vd_products );
		}
		$vd_products_list = implode( $product_delimiter, $vd_products );
		if ( $last !== null ) {
			$vd_products_list .= sprintf( __( ' or %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $last );
		}

		$last = null;
		$n = count( $vd_terms );
		if ( $n >= 2 ) {
			$last = array_pop( $vd_terms );
		}
		$vd_terms_list = implode( $category_delimiter, $vd_terms );
		if ( $last !== null ) {
			$vd_terms_list .= sprintf( __( ' or %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $last );
		}

		$vd_list = array();
		if ( !empty( $vd_products_list ) ) {
			$vd_list[] = $vd_products_list;
		}
		if ( !empty( $vd_terms_list ) ) {
			$vd_list[] = sprintf( __( ' in %s', WOO_VOLDISC_PLUGIN_DOMAIN ), $vd_terms_list );
		}
		$vd_list = implode( $product_category_delimiter, $vd_list );

		if ( $auto || !$show_using_code ) {
			if ( $min > 0 && $max > 0 ) {
				if ( $min != $max ) {
					$result = sprintf( __( 'Buy %1$d to %2$d %3$s and get a %4$s', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $max, $vd_list, $discount );
				} else {
					$result = sprintf( __( 'Buy %1$d %2$s and get a %3$s', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $vd_list, $discount );
				}
			} else if ( $min > 0 ) {
				$result = sprintf( __( 'Buy %1$d or more %2$s and get a %3$s', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $vd_list, $discount );
			} else if ( $max > 0 ) {
				$result = sprintf( __( 'Buy up to %1$d %2$s and get a %3$s', WOO_VOLDISC_PLUGIN_DOMAIN ), $max, $vd_list, $discount );
			}
		} else {
			if ( $min > 0 && $max > 0 ) {
				if ( $min != $max ) {
					$result = sprintf( __( 'Buy %1$d to %2$d %3$s and get a <span class="coupon discount">%4$s</span> using the coupon code <span class="coupon code">%5$s</span>', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $max, $vd_list, $discount, $coupon->code );
				} else {
					$result = sprintf( __( 'Buy %1$d %2$s and get a <span class="coupon discount">%3$s</span> using the coupon code <span class="coupon code">%4$s</span>', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $vd_list, $discount, $coupon->code );
				}
			} else if ( $min > 0 ) {
				$result = sprintf( __( 'Buy %1$d or more %2$s and get a <span class="coupon discount">%3$s</span> using the coupon code <span class="coupon code">%4$s</span>', WOO_VOLDISC_PLUGIN_DOMAIN ), $min, $vd_list, $discount, $coupon->code );
			} else if ( $max > 0 ) {
				$result = sprintf( __( 'Buy up to %1$d %2$s and get a <span class="coupon discount">%3$s</span> using the coupon code <span class="coupon code">%4$s</span>', WOO_VOLDISC_PLUGIN_DOMAIN ), $max, $vd_list, $discount, $coupon->code );
			}
		}

		$result = '<div class="volume-discount">' . $result . '</div>';

		return apply_filters( 'woocommerce_volume_discount_coupons_info', $result, $coupon );
	}
	
	/**
	 * Renders a volume discount coupon.
	 *
	 * Attributes:
	 * - "code" OR "coupon" : a coupon code or a comma-separated list of coupon codes
	 * - "order_by"   : defaults to "none" (renders coupons in the same order as given through the code/coupon attribute), also accepts "code" and "id"
	 * - "order"      : default to "ASC", also accepts "asc", "desc" and "DESC"
	 * - "pad"        : default true, use 0-padding on hours, minutes and seconds when value is below 10
	 * - "color"      : color CSS class applied along with .volume-discount-container and .volume-discount, defaults to blue
	 * - "stylesheet" : an alternative stylesheet can be loaded, must be a valid URL pointing to the stylesheet
	 *
	 * The stylesheet is only loaded once and only if the shortcode is used.
	 *
	 * @param array $atts attributes
	 * @param string $content not used
	 * @return rendered coupons
	 */
	public static function volume_discount_coupon( $atts, $content = null ) {

		global $wpdb, $woocommerce_volume_discount_coupons;

		$options = shortcode_atts(
			array(
				'coupon'               => null,
				'code'                 => null,
				'order_by'             => 'code',
				'order'                => 'ASC',
				'pad'                  => true,
				'color'                => 'blue',
				'stylesheet'           => null,
				'show_code'            => 'yes',
				'show_description'     => 'yes',
				'show_discount'        => 'yes'
			),
			$atts
		);

		$pad              = $options['pad'];
		$color            = wp_strip_all_tags( $options['color'] );
		$show_code        = $options['show_code'] === true || $options['show_code'] === 'true' || $options['show_code'] === 'yes';
		$show_discount    = $options['show_discount'] === true || $options['show_discount'] === 'true' || $options['show_discount'] === 'yes';
		$show_description = $options['show_description'] === true || $options['show_description'] === 'true' || $options['show_description'] === 'yes';

		$output = '';
		if ( empty( $woocommerce_volume_discount_coupons ) ) {
			if ( $options['stylesheet'] === null ) {
				wp_enqueue_style( 'woocommerce-volume-discount-coupons', trailingslashit( WOO_VOLDISC_PLUGIN_URL ) . 'css/woocommerce-volume-discount-coupons.css', array(), WOO_VOLDISC_PLUGIN_VERSION );
			} else {
				if ( !empty( $options['stylesheet'] ) ) {
					wp_enqueue_style( 'woocommerce-volume-discount-coupons', $options['stylesheet'], array(), WOO_VOLDISC_PLUGIN_VERSION );
				}
			}
			$woocommerce_volume_discount_coupons = 0;
		}

		$code = null;
		if ( !empty( $options['code'] ) ) {
			$code = $options['code'];
		} else if ( !empty( $options['coupon'] ) ) {
			$code = $options['coupon'];
		}
		if ( $code === null ) {
			return '';
		}

		$codes = array_map( 'trim', explode( ',', $code ) );

		$coupons = array();
		foreach ( $codes as $code ) {
			$coupon = new WC_Coupon( $code );
			if ( isset( $coupon->id ) ) {
				$coupons[] = $coupon;
			}
		}

		switch( $options['order_by'] ) {
			case 'id' :
				usort( $coupons, array( __CLASS__, 'by_id' ) );
				break;
			case 'code' :
				usort( $coupons, array( __CLASS__, 'by_code' ) );
				break;
		}
		switch( $options['order'] ) {
			case 'desc' :
			case 'DESC' :
				$coupons = array_reverse( $coupons );
				break;
		}

		foreach( $coupons as $coupon ) {

			$output .= sprintf( '<div class="volume-discount-container %s">', $color );
			$output .= sprintf( '<div class="volume-discount-coupon %s">',  $color );

			if ( $show_code ) {
				$output .= '<div class="code">';
				$output .= wp_strip_all_tags( $coupon->code );
				$output .= '</div>';
			}

			if ( $show_discount ) {
				$discount_info = self::get_volume_discount_info( $coupon, array( 'show_using_code' => false ) );
				if ( !empty( $discount_info ) ) {
					$output .= '<div class="discount-info">';
					$output .= $discount_info;
					$output .= '</div>';
				}
			}

			if ( $show_description ) {
				if ( $post = get_post( $coupon->id ) ) {
					if ( !empty( $post->post_excerpt ) ) {
						$output .= '<div class="description">';
						$output .= stripslashes( wp_filter_kses( $post->post_excerpt ) );
						$output .= '</div>';
					}
				}
			}
			$output .= '</div>'; // .volume-discount
			$output .= '</div>'; // .volume-discount-container
		}

		return $output;
	}

	/**
	 * Coupon comparison by id.
	 *
	 * @param WC_Coupon $a
	 * @param WC_Coupon $b
	 * @return int
	 */
	public static function by_id( $a, $b ) {
		return $a->id - $b->id;
	}

	/**
	 * Coupon comparison by code.
	 *
	 * @param WC_Coupon $a
	 * @param WC_Coupon $b
	 * @return int
	 */
	public static function by_code( $a, $b ) {
		return strcmp( $a->code, $b->code );
	}

}
WooCommerce_Volume_Discount_Coupons_Shortcodes::init();
