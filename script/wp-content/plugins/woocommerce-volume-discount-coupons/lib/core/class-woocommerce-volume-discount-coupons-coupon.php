<?php
/**
 * class-woocommerce-volume-discount-coupons-coupon.php
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
 * Coupon handler.
 */
class WooCommerce_Volume_Discount_Coupons_Coupon {

	private static $display_indexes = null;

	/**
	 * Initialize hooks and filters.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'woocommerce_calculate_totals', array( __CLASS__, 'woocommerce_calculate_totals' ) );
		add_filter( 'woocommerce_coupon_is_valid', array( __CLASS__, 'woocommerce_coupon_is_valid' ), 10, 2 );
		add_filter( 'woocommerce_coupon_data_tabs', array( __CLASS__, 'woocommerce_coupon_data_tabs' ) );
		add_action( 'woocommerce_process_shop_coupon_meta', array( __CLASS__, 'woocommerce_process_shop_coupon_meta' ), 10, 2 );

		self::$display_indexes = array(
			'anywhere'     => __( 'Anywhere', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'product_cat'  => __( 'Product Categories', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'product_tag'  => __( 'Product Tags', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'shop'         => __( 'Shop', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'archive'      => __( 'Product Archives', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'single'       => __( 'Product Pages', WOO_VOLDISC_PLUGIN_DOMAIN )
		);
	}

	/**
	 * Data panel actions.
	 */
	public static function wp_init() {
		add_action( 'woocommerce_coupon_data_panels', array( __CLASS__, 'woocommerce_coupon_data_panels' ) );
	}

	/**
	 * Automatically apply coupons.
	 * 
	 * Also removes auto-apply coupons (although that should happen
	 * automatically, it seems we're on the safer side doing that as well
	 * here).
	 * 
	 * @param WC_Cart $cart
	 */
	public static function woocommerce_calculate_totals( $cart ) {

		global $wpdb, $woocommerce;

		if ( isset( $woocommerce ) && isset( $woocommerce->cart ) && $woocommerce->cart->coupons_enabled() ) {
			$coupons = $wpdb->get_results( "SELECT DISTINCT ID, post_title FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id WHERE {$wpdb->posts}.post_status = 'publish' AND {$wpdb->postmeta}.meta_key = '_vd_auto'" );
			if ( $coupons && ( count( $coupons ) > 0 ) ) {
				foreach ( $coupons as $coupon ) {
					$coupon_code = $coupon->post_title;
					$coupon = new WC_Coupon( $coupon_code );
					if ( $coupon->get_id() ) {

						if ( $coupon->is_valid() ) {

							if ( !$woocommerce->cart->has_discount( $coupon_code ) ) {

								// Don't try to apply a coupon which is restricted
								// to individual use when there already are other
								// coupons applied to the cart.
								$applied_coupon_codes = $cart->get_applied_coupons();
								if ( $coupon->get_individual_use() ) {
									if ( !empty( $applied_coupon_codes ) ) {
										return;
									}
								}

								// Don't try to apply the coupon if there is a coupon
								// restricted for individual use already applied to
								// the cart.
								foreach( $applied_coupon_codes as $applied_coupon_code ) {
									$applied_coupon = new WC_Coupon( $applied_coupon_code );
									if ( $applied_coupon->get_id() ) {
										if ( $applied_coupon->get_individual_use() ) {
											return;
										}
									}
									unset( $applied_coupon );
								}

								$woocommerce->cart->add_discount( $coupon_code );

								$msg = '';
								$message          = get_post_meta( $coupon->get_id(), '_vd_auto_message_display', true );
								$show_description = get_post_meta( $coupon->get_id(), '_vd_auto_description_display', true ) == 'yes';
								$show_info        = get_post_meta( $coupon->get_id(), '_vd_auto_info_display', true ) == 'yes';

								if ( !empty( $message ) ) {
									$msg .= sprintf( '<div class="coupon display message %s">', wp_strip_all_tags( $coupon->get_code() ) );
									$msg .= stripslashes( wp_filter_kses( $message ) );
									$msg .= '</div>';
								}

								if ( $show_description ) {
									if ( $post = get_post( $coupon->get_id() ) ) {
										if ( !empty( $post->post_excerpt ) ) {
											$msg .= sprintf( '<div class="coupon display description %s">', wp_strip_all_tags( $coupon->get_code() ) );
											$msg .= stripslashes( wp_filter_kses( $post->post_excerpt ) );
											$msg .= '</div>';
										}
									}
								}

								if ( $show_info ) {
									$msg .= sprintf( '<div class="coupon display volume-discount %s">', wp_strip_all_tags( $coupon->get_code() ) );
									$msg .= WooCommerce_Volume_Discount_Coupons_Shortcodes::get_volume_discount_info( $coupon );
									$msg .= '</div>';
								}

								if ( !empty( $msg ) ) {
									if ( function_exists( 'wc_add_notice' ) ) {
										wc_add_notice( $msg );
									} else {
										$woocommerce->add_message( $msg );
									}
								}

							}
						} else {
							if ( $woocommerce->cart->has_discount( $coupon_code ) ) {
								$woocommerce->cart->remove_coupon( $coupon_code );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Filter the validity of a coupon based on our volume discount criteria.
	 * 
	 * @param boolean $valid
	 * @param WC_Coupon $coupon
	 * @return boolean true if coupon is valid, false otherwise
	 */
	public static function woocommerce_coupon_is_valid( $valid, $coupon ) {

		global $woocommerce;

		// Only perform checks if the coupon is valid at this stage.
		if ( $valid && !empty( $coupon ) && $coupon->get_id() ) {

			$product_ids    = get_post_meta( $coupon->get_id(), '_vd_product_ids', false );
			$term_ids       = get_post_meta( $coupon->get_id(), '_vd_term_ids', false );
			$min            = intval( get_post_meta( $coupon->get_id(), '_vd_min', true ) );
			$max            = intval( get_post_meta( $coupon->get_id(), '_vd_max', true ) );
			$sum_by_term_id = get_post_meta( $coupon->get_id(), '_vd_sum_by_term_id', true );

			// check if min or max should be checked for total cart items and no product
			// or category restrictions are set
			if ( ( empty( $product_ids ) ) && empty( $term_ids ) && ( $min > 0 || $max > 0 ) ) {

				// must assume invalid unless quantity checks are passed
				$valid = false;

				$quantity = 0;
				if ( count( $woocommerce->cart->get_cart() ) > 0 ) {
					foreach( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
						$quantity += $cart_item['quantity'];
					}
				}

				if ( $min > 0 && $max > 0 ) {
					if ( ( $quantity >= $min ) && ( $quantity <= $max ) ) {
						$valid = true;
					}
				} else if ( $min > 0 ) {
					if ( $quantity >= $min ) {
						$valid = true;
					}
				} else if ( $max > 0 ) {
					if ( $quantity  <= $max ) {
						$valid = true;
					}
				}

			} else {

			// check minimum and maximum quantities in the cart based on products
			if ( !empty( $product_ids ) && ( $min > 0 || $max > 0 ) ) {

				// map product ids to their quantities in the cart
				$quantities = array();
				if ( count( $woocommerce->cart->get_cart() ) > 0 ) {
					foreach( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {

						// add product count
						if ( !isset( $quantities[$cart_item['product_id']] ) ) {
							$quantities[$cart_item['product_id']] = $cart_item['quantity'];
						} else {
							$quantities[$cart_item['product_id']] += $cart_item['quantity'];
						}
						// add additional counts for variations 
						if ( !empty( $cart_item['variation_id'] ) ) {
							if ( !isset( $quantities[$cart_item['variation_id']] ) ) {
								$quantities[$cart_item['variation_id']] = $cart_item['quantity'];
							} else {
								$quantities[$cart_item['variation_id']] += $cart_item['quantity'];
							}
						}

					}
				}

				// Assume invalid unless one of the products in the cart meets
				// the volume criteria:
				$valid = false;
				foreach( $product_ids as $product_id ) {
					if ( isset( $quantities[$product_id] ) ) {
						$quantity = $quantities[$product_id];
						if ( $min > 0 && $max > 0 ) {
							if ( ( $quantity >= $min ) && ( $quantity <= $max ) ) {
								$valid = true;
								break;
							}
						} else if ( $min > 0 ) {
							if ( $quantity >= $min ) {
								$valid = true;
								break;
							}
						} else if ( $max > 0 ) {
							if ( $quantity  <= $max ) {
								$valid = true;
								break;
							}
						}
					}
				}

			}

			// Check minimum and maximum quantities in the cart based on
			// categories.
			if ( ( !$valid || empty( $product_ids ) ) && !empty( $term_ids ) && ( $min > 0 || $max > 0 ) ) {
				if ( $sum_by_term_id != 'yes' ) {
					// maps term ids to the sum of related products in the cart
					$quantities = array();
					if ( count( $woocommerce->cart->get_cart() ) > 0 ) {
						foreach( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
							$product_term_ids = wp_get_post_terms( $cart_item['product_id'], 'product_cat', array( "fields" => "ids" ) );
							$common_term_ids = array_intersect( $product_term_ids, $term_ids );
							if ( count( $common_term_ids )  > 0 ) {
								// add product count
								if ( !isset( $quantities[$cart_item['product_id']] ) ) {
									$quantities[$cart_item['product_id']] = $cart_item['quantity'];
								} else {
									$quantities[$cart_item['product_id']] += $cart_item['quantity'];
								}
								// add additional counts for variations
								if ( !empty( $cart_item['variation_id'] ) ) {
									if ( !isset( $quantities[$cart_item['variation_id']] ) ) {
										$quantities[$cart_item['variation_id']] = $cart_item['quantity'];
									} else {
										$quantities[$cart_item['variation_id']] += $cart_item['quantity'];
									}
								}
							}
						}
					}

					// Assume invalid unless one of the products in the cart meets
					// the volume criteria:
					$valid = false;
					foreach( $quantities as $product_id => $quantity ) {
						if ( $min > 0 && $max > 0 ) {
							if ( ( $quantity >= $min ) && ( $quantity <= $max ) ) {
								$valid = true;
								break;
							}
						} else if ( $min > 0 ) {
							if ( $quantity >= $min ) {
								$valid = true;
								break;
							}
						} else if ( $max > 0 ) {
							if ( $quantity  <= $max ) {
								$valid = true;
								break;
							}
						}
					}

				} else {
					// maps term ids to the sum of related products in the cart
					$quantities = array();
					if ( count( $woocommerce->cart->get_cart() ) > 0 ) {
						foreach( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
							$product_term_ids = wp_get_post_terms( $cart_item['product_id'], 'product_cat', array( "fields" => "ids" ) );
							$common_term_ids = array_intersect( $product_term_ids, $term_ids );
							foreach( $common_term_ids as $tid ) {
								// add product count
								if ( !isset( $quantities[$tid] ) ) {
									$quantities[$tid] = $cart_item['quantity'];
								} else {
									$quantities[$tid] += $cart_item['quantity'];
								}
							}
						}
					}

					// Invalid until one category meets volume criteria.
					$valid = false;
					foreach( $term_ids as $term_id ) {
						if ( isset( $quantities[$term_id] ) ) {
							$quantity = $quantities[$term_id];
							if ( $min > 0 && $max > 0 ) {
								if ( ( $quantity >= $min ) && ( $quantity <= $max ) ) {
									$valid = true;
									break;
								}
							} else if ( $min > 0 ) {
								if ( $quantity >= $min ) {
									$valid = true;
									break;
								}
							} else if ( $max > 0 ) {
								if ( $quantity  <= $max ) {
									$valid = true;
									break;
								}
							}
						}
					}
				}
			}

			}

			// Allow others to plug in here:
			$valid = apply_filters( 'woocommerce_volume_discount_coupons_coupon_is_valid', $valid, $coupon );

		}
		return $valid;
	}

	/**
	 * Adds the Volume Discount tab.
	 * @param array $tabs
	 * @return array
	 */
	public static function woocommerce_coupon_data_tabs( $tabs ) {
		$tabs['wvdc'] = array(
			'label'  => __( 'Volume Discount', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'target' => 'custom_coupon_wvdc',
			'class'  => 'coupon-wvdc'
		);
		return $tabs;
	}

	/**
	 * Renders coupon options.
	 */
	public static function woocommerce_coupon_data_panels() {

		global $post, $woocommerce;

		// guard against woocommerce_coupon_options action invoked during save
		if ( isset( $_POST['action'] ) ) {
			return;
		}

		//
		echo '<div id="custom_coupon_wvdc" class="panel woocommerce_options_panel">';

		//
		// Volume discounts based on cart items
		//
		echo '<div class="options_group">';

		echo '<p>';
		echo '<strong>';
		echo __( 'Volume Discount', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</strong>';
		echo '</p>';

		//
		// Products
		//
		?>
		<p class="form-field"><label><?php _e( 'Products', WOO_VOLDISC_PLUGIN_DOMAIN ); ?></label>
		<select class="wc-product-search" multiple="multiple" style="width: 50%;" name="_vd_product_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', WOO_VOLDISC_PLUGIN_DOMAIN ); ?>" data-action="woocommerce_json_search_products_and_variations">
		<?php
			$product_ids = !empty( $post ) && !empty( $post->ID ) ? get_post_meta( $post->ID, '_vd_product_ids', false ) : array();
			foreach ( $product_ids as $product_id ) {
				$product = wc_get_product( $product_id );
				if ( is_object( $product ) ) {
					echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
				}
			}
		?>
		</select>
		<?php
			echo wc_help_tip(
				__( 'For a customer to be allowed to apply this coupon, at least one of the chosen products must be in the cart and its quantity must be within the given minimum and maximum.', WOO_VOLDISC_PLUGIN_DOMAIN )
			);
		?>
		</p>

		<?php
		//
		// Product categories
		//
		?>
		<p class="form-field"><label for="exclude_product_categories"><?php _e( 'Product categories', WOO_VOLDISC_PLUGIN_DOMAIN ); ?></label>
		<select id="exclude_product_categories" name="_vd_term_ids[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'No categories', WOO_VOLDISC_PLUGIN_DOMAIN ); ?>">
			<?php
				$category_ids = !empty( $post ) && !empty( $post->ID ) ? get_post_meta( $post->ID, '_vd_term_ids', false ) : array();
				$categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );
				if ( $categories ) {
					foreach ( $categories as $cat ) {
						echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( in_array( $cat->term_id, $category_ids ), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
					}
				}
			?>
		</select>
		<?php
			echo wc_help_tip(
				__( 'If one or more categories are chosen, the coupon is valid if at least one product in the selected categories is in the cart and its quantity is within the given minimum and maximum.', WOO_VOLDISC_PLUGIN_DOMAIN )
			);
		?>
		 </p>
		<?php

		woocommerce_wp_text_input( array(
			'id'          => '_vd_min',
			'label'       => __( 'Minimum', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'placeholder' => __( 'no restriction', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'Input the minimum quantity that must be in the cart. The condition is met, if for any of the chosen products, or any product in the selected categories, the minimum quantity is in the cart. If no products or categories are specified, the restriction applies to the sum of quantities in the cart.', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'desc_tip'    => true,
			'type'        => 'number'
		) );

		woocommerce_wp_text_input( array(
			'id'          => '_vd_max',
			'label'       => __( 'Maximum', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'placeholder' => __( 'no restriction', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'Input the maximum quantity allowed in the cart. The condition is met, if for any of the chosen products, or any product in the selected categories, the quantity in the cart does not exceed the maximum. If no products or categories are specified, the restriction applies to the sum of quantities in the cart.', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'desc_tip'    => true,
			'type'        => 'number'
		) );

		woocommerce_wp_checkbox( array(
			'id'          => '_vd_auto',
			'label'       => __( 'Apply automatically', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'Apply this coupon automatically when valid based on these conditions.', WOO_VOLDISC_PLUGIN_DOMAIN )
		) );

		woocommerce_wp_checkbox( array(
				'id'          => '_vd_sum_by_term_id',
				'label'       => __( 'Sum categories', WOO_VOLDISC_PLUGIN_DOMAIN ),
				'description' => __( 'Sum the number of units per category. If this is enabled, the quantity restrictions are based on the totals per category, instead of per individual product. This applies only to products in the selected categories, if any.', WOO_VOLDISC_PLUGIN_DOMAIN )
		) );

		echo '<p class="description">';
		echo __( 'If no product or category is set, the minimum and maximum (or both) conditions apply to the sum of quantities in the cart.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo ' ';
		echo __( 'For product <strong>variations</strong>, if a variable product is chosen (i.e. the parent to its variations), the quantity in the cart used to check the minimum or maximum is the combined total of all variations in the cart.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo ' ';
		echo __( 'If a product variation is chosen (i.e. a product variation derived by attribute from its parent product), the quantity check is made for that variation only, independent of other variations in the cart.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo ' ';
		echo __( 'If both products and categories are indicated, one of the specified products or a product that belongs to one of the categories must meet the quantity restrictions.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';

		echo '<p>';
		echo __( '<strong>Display Options</strong>', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo ' - ';
		echo __( 'For the products indicated and products in the selected categories, the product displayed can be enhanced with information based on the coupon\'s description and volume discount.', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';

		echo '<p>';
		echo __( 'Show the <em>coupon description</em> for products on these pages:', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';

		$description_display = get_post_meta( $post->ID, '_vd_description_display', false );

		foreach( self::$display_indexes as $key => $label ) {
			woocommerce_wp_checkbox( array(
				'id'          => '_vd_description_display_' . $key,
				'label'       => $label,
				'value'       => in_array( $key, $description_display ) ? 'yes' : ''
			) );
		}

		echo '<p>';
		echo __( 'Show the <em>volume discount info</em> for products on these pages:', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';

		$info_display = get_post_meta( $post->ID, '_vd_info_display', false );
		foreach( self::$display_indexes as $key => $label ) {
			woocommerce_wp_checkbox( array(
				'id'          => '_vd_info_display_' . $key,
				'label'       => $label,
				'value'       => in_array( $key, $info_display ) ? 'yes' : ''
			) );
		}

		echo '<p>';
		echo __( '<strong>Auto-apply Display Options</strong>', WOO_VOLDISC_PLUGIN_DOMAIN );
		echo '</p>';

		woocommerce_wp_textarea_input( array(
			'id'          => '_vd_auto_message_display',
			'label'       => __( 'Message', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'If not empty, display a message when the coupon is automatically applied.', WOO_VOLDISC_PLUGIN_DOMAIN )
		) );

		woocommerce_wp_checkbox( array(
			'id'          => '_vd_auto_description_display',
			'label'       => __( 'Description', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'Display the coupon description when the coupon is automatically applied.', WOO_VOLDISC_PLUGIN_DOMAIN )
		) );

		woocommerce_wp_checkbox( array(
			'id'          => '_vd_auto_info_display',
			'label'       => __( 'Volume Discount Info', WOO_VOLDISC_PLUGIN_DOMAIN ),
			'description' => __( 'Display the <em>volume discount info</em> when the coupon is automatically applied.', WOO_VOLDISC_PLUGIN_DOMAIN )
		) );

		echo '</div>'; // .options_group

		echo '</div>'; // #custom_coupon_wvdc

	}

	/**
	 * Saves our data for the coupon.
	 * @param int $post_id coupon ID
	 * @param object $post coupon
	 */
	public static function woocommerce_process_shop_coupon_meta( $post_id, $post ) {
		global $woocommerce;
		delete_post_meta( $post_id, '_vd_product_ids' );
		delete_post_meta( $post_id, '_vd_term_ids' );
		delete_post_meta( $post_id, '_vd_min' );
		delete_post_meta( $post_id, '_vd_max' );
		delete_post_meta( $post_id, '_vd_auto' );
		delete_post_meta( $post_id, '_vd_sum_by_term_id' );
		delete_post_meta( $post_id, '_vd_description_display' );
		delete_post_meta( $post_id, '_vd_info_display' );
		delete_post_meta( $post_id, '_vd_auto_message_display' );
		delete_post_meta( $post_id, '_vd_auto_description_display' );
		delete_post_meta( $post_id, '_vd_auto_info_display' );
		if ( !empty( $_POST['_vd_product_ids'] ) ) {
			$product_ids = is_array( $_POST['_vd_product_ids'] ) ? $_POST['_vd_product_ids'] : explode(',', $_POST['_vd_product_ids'] );
			foreach( $product_ids as $product_id ) {
				add_post_meta( $post_id, '_vd_product_ids', intval( $product_id ) );
			}
		}
		if ( !empty( $_POST['_vd_term_ids'] ) ) {
			foreach( $_POST['_vd_term_ids'] as $term_id ) {
				add_post_meta( $post_id, '_vd_term_ids', intval( $term_id ) );
			}
		}
		if ( !empty( $_POST['_vd_min'] ) ) {
			$min = intval( $_POST['_vd_min'] );
			if ( $min > 0 ) {
				add_post_meta( $post_id, '_vd_min', $min );
			}
		}
		if ( !empty( $_POST['_vd_max'] ) ) {
			$max = intval( $_POST['_vd_max'] );
			if ( $max > 0 ) {
				$min = intval( get_post_meta( $post_id, '_vd_min', true ) );
				if ( $min > 0 ) {
					if ( $max < $min ) {
						$max = $min;
					}
				}
				add_post_meta( $post_id, '_vd_max', $max );
			}
		}
		if ( !empty( $_POST['_vd_auto'] ) ) {
			add_post_meta( $post_id, '_vd_auto', 'yes' );
		}
		if ( !empty( $_POST['_vd_sum_by_term_id'] ) ) {
			add_post_meta( $post_id, '_vd_sum_by_term_id', 'yes' );
		}

		foreach( self::$display_indexes as $key => $label ) {
			if ( !empty( $_POST['_vd_description_display_' . $key] ) ) {
				add_post_meta( $post_id, '_vd_description_display', $key );
			}
			if ( !empty( $_POST['_vd_info_display_' . $key] ) ) {
				add_post_meta( $post_id, '_vd_info_display', $key );
			}
		}
		if ( !empty( $_POST['_vd_auto_message_display'] ) ) {
			add_post_meta( $post_id, '_vd_auto_message_display', $_POST['_vd_auto_message_display'] );
		}
		if ( !empty( $_POST['_vd_auto_description_display'] ) ) {
			add_post_meta( $post_id, '_vd_auto_description_display', 'yes' );
		}
		if ( !empty( $_POST['_vd_auto_info_display'] ) ) {
			add_post_meta( $post_id, '_vd_auto_info_display', 'yes' );
		}
	}
}
WooCommerce_Volume_Discount_Coupons_Coupon::init();
