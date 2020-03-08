<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class AFRSM_Shipping_Method.
 *
 * WooCommerce Advanced flat rate shipping method class.
 */
if (class_exists('AFRSM_Shipping_Method'))
    return; // Stop if the class already exists

class AFRSM_Shipping_Method extends WC_Shipping_Method {

    /**
     * Constructor
     *
     * @since 3.0.0
     */
    public function __construct() {

        $post_title = isset($_REQUEST['id']) ? get_the_title($_REQUEST['id']) : '';

        $shipping_method_id = isset($_REQUEST['id']) && !empty($_REQUEST['id']) ? $_REQUEST['id'] : 'advanced_flat_rate_shipping';
        $shipping_method_title = !empty($post_title) ? $post_title : 'Advanced Flat Rate Shipping';

        $this->id = $shipping_method_id;
        $this->title = __('Advanced Flat Rate Shipping', AFRSM_PRO_TEXT_DOMAIN);
        $this->method_title = __($shipping_method_title, AFRSM_PRO_TEXT_DOMAIN);

        $this->init();

        // Save settings
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * Init
     *
     * @since 3.0.0
     */
    function init() {
        $this->init_form_fields();
        $this->init_settings();
    }

    /**
     * Init form fields.
     *
     * @since 3.0.0
     */
    public function init_form_fields() {

        $this->form_fields = array(
            'advanced_flat_rate_shipping_table' => array(
                'type' => 'advanced_flat_rate_shipping_table',
            ),
        );
    }

    /**
     * General advanced flat rate settings tab table.
     *
     * @since 3.0.0
     */
    public function generate_advanced_flat_rate_shipping_table_html() {
        ob_start();
        require plugin_dir_path(__FILE__) . 'afrsm-pro-list-page.php';
        return ob_get_clean();
    }

    /**
     * Match methods.
     *
     * Check all created AFRSM shipping methods have a matching condition group.
     *
     * @since 3.0.0
     *
     * @param  array $package List of shipping package data.
     * @return array          List of all matched shipping methods.
     */
    public function afrsm_match_methods($package) {

        $matched_methods = array();
        $sm_args = array(
            'post_type' => 'wc_afrsm',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $sm_posts = get_posts($sm_args);

        foreach ($sm_posts as $sm_post) {

            // Check if shipping method conditions match
            $is_match = $this->afrsm_match_conditions($sm_post, $package);

            // Add to matched methods array
            if ($is_match == true) {
                $matched_methods[] = $sm_post->ID;
            }
        }
        return $matched_methods;
    }

    /**
     * Match conditions.
     *
     * Check if conditions match, if all conditions in one condition group
     * matches it will return TRUE and the shipping method will display.
     *
     * @since 1.0.0
     *
     * @param array $sm_post_data
     * @param  array $package List of shipping package data.
     *
     * @return BOOL                    TRUE if all the conditions in one of the condition groups matches true.
     */
    public function afrsm_match_conditions($sm_post_data = array(), $package = array()) {

        if (empty($sm_post_data)) {
            return false;
        }

        if (!empty($sm_post_data)) {
            $final_condition_flag = apply_filters('afrsm_condition_match_rules', $sm_post_data, $package);
            if ($final_condition_flag) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculate shipping.
     *
     * @since 3.0.0
     *
     * @param array $package List containing all products for this method.
     */
    public function calculate_shipping($package = array()) {

        global $sitepress, $woocommerce, $woocommerce_wpml;

        if (!empty($sitepress)) {
            $default_lang = $sitepress->get_default_language();
        }
        $matched_shipping_methods = $this->afrsm_match_methods($package);
        if ($matched_shipping_methods == false || !is_array($matched_shipping_methods)) {
            return;
        }
        $cart_array = $woocommerce->cart->get_cart();
        if (!empty($matched_shipping_methods)) {
            foreach ($matched_shipping_methods as $shipping_method_id) {
                $shipping_title = get_the_title($shipping_method_id);

                $shipping_rate = array(
                    'id' => $shipping_method_id,
                    'label' => $shipping_title,
                    'cost' => 0,
                );
                $cart_based_qty = '';
                if (!empty($cart_array)) {
                    foreach ($cart_array as $woo_cart_item_key => $value) {
                        $cart_based_qty += $value['quantity'];
                    }
                }

                // Calculate the costs
                $has_costs = false; // True when a cost is set. False if all costs are blank strings.
                $costs = get_post_meta($shipping_method_id, 'sm_product_cost', true);
                $getFeesPerQtyFlag = get_post_meta($shipping_method_id, 'sm_fee_chk_qty_price', true);
                $getFeesPerQty = get_post_meta($shipping_method_id, 'sm_fee_per_qty', true);
                $extraProductCostOriginal = get_post_meta($shipping_method_id, 'sm_extra_product_cost', true);
                
                if (isset($woocommerce_wpml) && !empty($woocommerce_wpml->multi_currency)) {
                    $extraProductCost = $woocommerce_wpml->multi_currency->prices->convert_price_amount($extraProductCostOriginal);
                } else {
                    $extraProductCost = $extraProductCostOriginal;
                }
                $products_based_qty = '';
                /*Per Qty Condition start*/
                if ($getFeesPerQtyFlag == 'on') {
                    $cart_final_products_array = array();
                    $site_product_id = '';
                    $productFeesArray = get_post_meta($shipping_method_id, 'sm_metabox', true);
                    /* @var $productFeesArray type */
                    if (!empty($productFeesArray)) {
                        foreach ($productFeesArray as $key => $condition) {
                            if (array_search('product', $condition)) {
                                $site_product_id = '';
                                $cart_final_products_array = array();
                                /* Product Condition Start */
                                if ($condition['product_fees_conditions_is'] == 'is_equal_to') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $product_id) {
                                            foreach ($cart_array as $key => $value) {
                                                if (!empty($sitepress)) {
                                                    $site_product_id = apply_filters('wpml_object_id', $value['product_id'], 'product', TRUE, $default_lang);
                                                } else {
                                                    $site_product_id = $value['product_id'];
                                                }

                                                if ($product_id == $site_product_id) {
                                                    $cart_final_products_array[] = $value;
                                                }
                                            }
                                        }
                                    }
                                } elseif ($condition['product_fees_conditions_is'] == 'not_in') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $product_id) {
                                            foreach ($cart_array as $key => $value) {

                                                if (!empty($sitepress)) {
                                                    $site_product_id = apply_filters('wpml_object_id', $value['product_id'], 'product', TRUE, $default_lang);
                                                } else {
                                                    $site_product_id = $value['product_id'];
                                                }

                                                if ($product_id != $site_product_id) {
                                                    $cart_final_products_array[] = $value;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (!empty($cart_final_products_array)) {
                                    foreach ($cart_final_products_array as $cart_item) {
                                        $products_based_qty += $cart_item['quantity'];
                                    }
                                }

                                /* Product Condition End */
                            }

                            if (array_search('variableproduct', $condition)) {
                                $site_product_id = '';
                                $cart_final_products_array = array();
                                /* Variable Product Condition Start */
                                if ($condition['product_fees_conditions_is'] == 'is_equal_to') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $product_id) {

                                            foreach ($cart_array as $key => $value) {
                                                if (!empty($sitepress)) {
                                                    $site_product_id = apply_filters('wpml_object_id', $value['variation_id'], 'product', TRUE, $default_lang);
                                                } else {
                                                    $site_product_id = $value['variation_id'];
                                                }

                                                if ($product_id == $site_product_id) {
                                                    $cart_final_products_array[] = $value;
                                                }
                                            }
                                        }
                                    }
                                } elseif ($condition['product_fees_conditions_is'] == 'not_in') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $product_id) {
                                            foreach ($cart_array as $key => $value) {

                                                if (!empty($sitepress)) {
                                                    $site_product_id = apply_filters('wpml_object_id', $value['variation_id'], 'product', TRUE, $default_lang);
                                                } else {
                                                    $site_product_id = $value['product_id'];
                                                }

                                                if ($product_id != $site_product_id) {
                                                    $cart_final_products_array[] = $value;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (!empty($cart_final_products_array)) {
                                    foreach ($cart_final_products_array as $cart_item) {
                                        $products_based_qty += $cart_item['quantity'];
                                    }
                                }
                                /* Variable Product Condition End */
                            }
                            /* Category Condition Start */
                            if (array_search('category', $condition)) {
                                $final_cart_products_cats_ids = array();
                                $cart_final_cat_products_array = array();

                                $all_cats = get_terms(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'fields' => 'ids'
                                        )
                                );

                                if ($condition['product_fees_conditions_is'] == 'is_equal_to') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $category_id) {
                                            $final_cart_products_cats_ids[] = $category_id;
                                        }
                                    }
                                } elseif ($condition['product_fees_conditions_is'] == 'not_in') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        $final_cart_products_cats_ids = array_diff($all_cats, $condition['product_fees_conditions_values']);
                                    }
                                }

                                $cat_args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => -1,
                                    'order' => 'ASC',
                                    'fields' => 'ids',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'term_id',
                                            'terms' => $final_cart_products_cats_ids,
                                        )
                                    )
                                );
                                $cat_products_ids = get_posts($cat_args);

                                foreach ($cart_array as $key => $value) {
                                    if (in_array($value['product_id'], $cat_products_ids)) {
                                        $cart_final_cat_products_array[] = $value;
                                    }
                                }

                                if (!empty($cart_final_cat_products_array)) {
                                    foreach ($cart_final_cat_products_array as $cart_item) {
                                        $products_based_qty += $cart_item['quantity'];
                                    }
                                }
                            }
                            /* Category Condition End */
                            if (array_search('tag', $condition)) {

                                /* Tag Condition Start */
                                $final_cart_products_tag_ids = array();
                                $cart_final_tag_products_array = array();
	                        $final_cart_products_tag_not_in_flag = 0;
                                $all_tags = get_terms(
                                        array(
                                            'taxonomy' => 'product_tag',
                                            'fields' => 'ids'
                                        )
                                );
                                if ($condition['product_fees_conditions_is'] == 'is_equal_to') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
                                        foreach ($condition['product_fees_conditions_values'] as $tag_id) {
                                            $final_cart_products_tag_ids[] = $tag_id;
                                        }
                                    }
                                } elseif ($condition['product_fees_conditions_is'] == 'not_in') {
                                    if (!empty($condition['product_fees_conditions_values'])) {
	                                $final_cart_products_tag_not_in_flag = 1;
                                        $final_cart_products_tag_ids = array_diff($all_tags, $condition['product_fees_conditions_values']);
                                    }
                                }

                                $tag_args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => -1,
                                    'order' => 'ASC',
                                    'fields' => 'ids',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_tag',
                                            'field' => 'term_id',
                                            'terms' => $final_cart_products_tag_ids,
                                        )
                                    )
                                );
                                $tag_products_ids = get_posts($tag_args);

                                foreach ($cart_array as $key => $value) {
                                	if($final_cart_products_tag_not_in_flag == 1){
		                                $cart_final_tag_products_array[] = $value;
	                                } elseif (in_array($value['product_id'], $tag_products_ids)) {
		                                $cart_final_tag_products_array[] = $value;
	                                }
                                }
                                if (!empty($cart_final_tag_products_array)) {
                                    foreach ($cart_final_tag_products_array as $cart_item) {
                                        $products_based_qty += $cart_item['quantity'];
                                    }
                                }
                            }
                            /* Tag Condition End */
                        }
                    }
                    if ($getFeesPerQty == 'qty_cart_based') {
                        $cost = $costs + (($cart_based_qty - 1) * $extraProductCost);
                    } else if ($getFeesPerQty == 'qty_product_based') {
                        $cost = $costs + (($products_based_qty - 1) * $extraProductCost);
                    }
                    /*Per Qty Condition end*/
                } else {
                    $cost = $costs;
                }
                
                $sm_taxable = get_post_meta($shipping_method_id, 'sm_select_taxable', true);
                $sm_extra_cost_calculation_type = get_post_meta($shipping_method_id, 'sm_extra_cost_calculation_type', true);
                if ($cost !== '') {
                    $has_costs = true;
                    $cost_args = array(
                        'qty' => $this->get_package_item_qty($package),
                        'cost' => $package['contents_cost']
                    );
                    $shipping_rate['cost'] = $this->evaluate_cost($cost, $cost_args);
                }

                // Add shipping class costs
                $found_shipping_classes = $this->find_shipping_classes($package);
                $highest_class_cost = 0;

                if (!empty($found_shipping_classes)) {
                    foreach ($found_shipping_classes as $shipping_class => $products) {
                        $shipping_class_term = get_term_by('slug', $shipping_class, 'product_shipping_class');
                        $shipping_extra_id = '';
                        if ($shipping_class_term !== FALSE) {
                            
                            if (!empty($sitepress)) {
                                $shipping_extra_id = apply_filters('wpml_object_id', $shipping_class_term->term_id, 'product_shipping_class', TRUE, $default_lang);
                            } else {
                                $shipping_extra_id = $shipping_class_term->term_id;
                            }
                            
                        }
                        $sm_extra_cost = get_post_meta($shipping_method_id, 'sm_extra_cost', true);
                        $class_cost_string = isset($sm_extra_cost[$shipping_extra_id]) && !empty($sm_extra_cost[$shipping_extra_id]) ? $sm_extra_cost[$shipping_extra_id] : '';
                        if ($class_cost_string === '') {
                            continue;
                        }

                        $has_costs = true;
                        $class_cost = $this->evaluate_cost($class_cost_string, array(
                            'qty' => array_sum(wp_list_pluck($products, 'quantity')),
                            'cost' => array_sum(wp_list_pluck($products, 'line_total'))
                        ));

                        if ($sm_extra_cost_calculation_type === 'per_class') {
                            $shipping_rate['cost'] += $class_cost;
                        } else {
                            $highest_class_cost = $class_cost > $highest_class_cost ? $class_cost : $highest_class_cost;
                        }
                        if ($sm_extra_cost_calculation_type === 'per_order' && $highest_class_cost) {
                            $shipping_rate['cost'] += $highest_class_cost;
                        }
                    }
                }

                if ($sm_taxable == 'no') {
                    $shipping_rate['taxes'] = false;
                } else {
                    $shipping_rate['taxes'] = '';
                }

                // Add the rate
                if ($has_costs) {
                    $this->add_rate($shipping_rate);
                }

                do_action('woocommerce_' . $this->id . '_shipping_add_rate', $this, $shipping_rate, $package);
            }
        }
    }

    /**
     * Get items in package.
     * @param  array $package
     * @return int
     */
    public function get_package_item_qty($package) {
        $total_quantity = 0;
        foreach ($package['contents'] as $item_id => $values) {
            if ($values['quantity'] > 0 && $values['data']->needs_shipping()) {
                $total_quantity += $values['quantity'];
            }
        }
        return $total_quantity;
    }

    /**
     * Finds and returns shipping classes and the products with said class.
     * @param mixed $package
     * @return array
     */
    public function find_shipping_classes($package) {
        $found_shipping_classes = array();

        foreach ($package['contents'] as $item_id => $values) {
            if ($values['data']->needs_shipping()) {
                $found_class = $values['data']->get_shipping_class();

                if (!isset($found_shipping_classes[$found_class])) {
                    $found_shipping_classes[$found_class] = array();
                }

                $found_shipping_classes[$found_class][$item_id] = $values;
            }
        }
        return $found_shipping_classes;
    }

    /**
     * Evaluate a cost from a sum/string.
     * @param  string $shipping_cost_sum
     * @param  array  $args
     * @return string
     */
    protected function evaluate_cost($shipping_cost_sum, $args = array()) {
        include_once( 'class-wc-extra-flat-eval-math.php' );

        // Allow 3rd parties to process shipping cost arguments
        $args = apply_filters('woocommerce_evaluate_shipping_cost_args', $args, $shipping_cost_sum, $this);
        $locale = localeconv();
        $decimals = array(wc_get_price_decimal_separator(), $locale['decimal_point'], $locale['mon_decimal_point']);
        $this->fee_cost = $args['cost'];

        // Expand shortcodes
        add_shortcode('fee', array($this, 'fee'));

        $shipping_cost_sum = do_shortcode(str_replace(array('[qty]', '[cost]'), array($args['qty'], $args['cost']), $shipping_cost_sum));

        remove_shortcode('fee', array($this, 'fee'));

        // Remove whitespace from string
        $shipping_cost_sum = preg_replace('/\s+/', '', $shipping_cost_sum);

        // Remove locale from string
        $shipping_cost_sum = str_replace($decimals, '.', $shipping_cost_sum);

        // Trim invalid start/end characters
        $shipping_cost_sum = rtrim(ltrim($shipping_cost_sum, "\t\n\r\0\x0B+*/"), "\t\n\r\0\x0B+-*/");

        // Do the math
        return $shipping_cost_sum ? WC_Eval_Math_Extra::evaluate($shipping_cost_sum) : 0;
    }

    /**
     * Work out fee (shortcode).
     * @param  array $atts
     * @return string
     */
    public function fee($atts) {
        $atts = shortcode_atts(array('percent' => '', 'min_fee' => ''), $atts);

        $atts['percent'] = $this->string_sanitize($atts['percent']);
        $atts['min_fee'] = $this->string_sanitize($atts['min_fee']);

        $calculated_fee = 0;

        if ($atts['percent']) {
            $calculated_fee = $this->fee_cost * ( floatval($atts['percent']) / 100 );
        }

        if ($atts['min_fee'] && $calculated_fee < $atts['min_fee']) {
            $calculated_fee = $atts['min_fee'];
        }

        return $calculated_fee;
    }

    public function string_sanitize($string) {
        $result = preg_replace("/[^ A-Za-z0-9_=.*()+\-\[\]\/]+/", "", html_entity_decode($string, ENT_QUOTES));
        return $result;
    }

}
