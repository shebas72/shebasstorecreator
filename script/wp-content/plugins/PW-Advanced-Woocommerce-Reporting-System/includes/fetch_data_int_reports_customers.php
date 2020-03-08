<?php
	if($file_used=="sql_table")
	{
		$request 			= array();
		$start				= 0;

		$pw_from_date		  = $this->pw_get_woo_requests('pw_from_date',NULL,true);
		$pw_to_date			= $this->pw_get_woo_requests('pw_to_date',NULL,true);

		$pw_id_order_status 	= $this->pw_get_woo_requests('pw_id_order_status',NULL,true);
		$pw_paid_customer		= $this->pw_get_woo_requests('pw_customers_paid',NULL,true);
		$txtProduct 		= $this->pw_get_woo_requests('txtProduct',NULL,true);
		$pw_product_id			= $this->pw_get_woo_requests('pw_product_id',"-1",true);
		$category_id 		= $this->pw_get_woo_requests('pw_category_id','-1',true);

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id 		= $this->pw_get_woo_requests('pw_brand_id','-1',true);

		$limit 				= $this->pw_get_woo_requests('limit',15,true);
		$p 					= $this->pw_get_woo_requests('p',1,true);

		$page 				= $this->pw_get_woo_requests('page',NULL,true);
		$order_id 			= $this->pw_get_woo_requests('pw_id_order',NULL,true);
		$pw_from_date 		= $this->pw_get_woo_requests('pw_from_date',NULL,true);
		$pw_to_date 			= $this->pw_get_woo_requests('pw_to_date',NULL,true);

		$pw_txt_email 			= $this->pw_get_woo_requests('pw_email_text',NULL,true);

		$pw_txt_first_name		= $this->pw_get_woo_requests('pw_first_name_text',NULL,true);

		$pw_detail_view		= $this->pw_get_woo_requests('pw_view_details',"no",true);
		$pw_country_code		= $this->pw_get_woo_requests('pw_countries_code',NULL,true);
		$state_code			= $this->pw_get_woo_requests('pw_states_code','-1',true);
		$pw_payment_method		= $this->pw_get_woo_requests('payment_method',NULL,true);
		$pw_order_item_name	= $this->pw_get_woo_requests('order_item_name',NULL,true);//for coupon
		$pw_coupon_code		= $this->pw_get_woo_requests('coupon_code',NULL,true);//for coupon
		$pw_publish_order		= $this->pw_get_woo_requests('publish_order','no',true);//if publish display publish order only, no or null display all order
		$pw_coupon_used		= $this->pw_get_woo_requests('pw_use_coupon','no',true);
		$pw_order_meta_key		= $this->pw_get_woo_requests('order_meta_key','-1',true);
		$pw_order_status		= $this->pw_get_woo_requests('pw_orders_status','-1',true);
		//$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";

		$pw_paid_customer		= str_replace(",","','",$pw_paid_customer);
		//$pw_country_code		= str_replace(",","','",$pw_country_code);
		//$state_code		= str_replace(",","','",$state_code);
		//$pw_country_code		= str_replace(",","','",$pw_country_code);

		$pw_coupon_code		= $this->pw_get_woo_requests('coupon_code','-1',true);
		$pw_coupon_codes		= $this->pw_get_woo_requests('pw_codes_of_coupon','-1',true);

		$pw_max_amount			= $this->pw_get_woo_requests('max_amount','-1',true);
		$pw_min_amount			= $this->pw_get_woo_requests('min_amount','-1',true);

		$pw_billing_post_code		= $this->pw_get_woo_requests('pw_bill_post_code','-1',true);

		////ADDED IN V4.0
		$pw_variation_id		= $this->pw_get_woo_requests('pw_variation_id','-1',true);
		$pw_variation_only		= $this->pw_get_woo_requests('pw_variation_only','-1',true);
		$pw_variations=$pw_item_meta_key='';
		if($pw_variation_id != '-1' and strlen($pw_variation_id) > 0){

			$pw_variations = explode(",",$pw_variation_id);
			//$this->print_array($pw_variations);
			$var = array();
			$item_att = array();
			foreach($pw_variations as $key => $value):
				$var[] .=  "attribute_pa_".$value;
				$var[] .=  "attribute_".$value;
				$item_att[] .=  "pa_".$value;
				$item_att[] .=  $value;
			endforeach;
			$pw_variations =  implode("', '",$var);
			$pw_item_meta_key =  implode("', '",$item_att);
		}
		$pw_variation_attributes= $pw_variations;
		$pw_variation_item_meta_key= $pw_item_meta_key;

		$pw_hide_os		= $this->pw_get_woo_requests('pw_hide_os','"trash"',true);

		$pw_show_cog		= $this->pw_get_woo_requests('pw_show_cog','no',true);

		///////////HIDDEN FIELDS////////////
		$pw_hide_os=$this->otder_status_hide;
		$pw_publish_order='no';
		$pw_order_item_name='';
		$pw_coupon_code='';
		$pw_coupon_codes='';
		$pw_payment_method='';

		$pw_order_meta_key='';

		$data_format=$this->pw_get_woo_requests('date_format',get_option('date_format'),true);

		$amont_zero='';
		//////////////////////

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key='all_orders';

		$category_id=$this->pw_get_form_element_permission('pw_category_id',$category_id,$key);

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id=$this->pw_get_form_element_permission('pw_brand_id',$brand_id,$key);

		$pw_product_id=$this->pw_get_form_element_permission('pw_product_id',$pw_product_id,$key);

		$pw_country_code=$this->pw_get_form_element_permission('pw_countries_code',$pw_country_code,$key);

		if($pw_country_code != NULL  && $pw_country_code != '-1')
			$pw_country_code  		= "'".str_replace(",","','",$pw_country_code)."'";

		$state_code=$this->pw_get_form_element_permission('pw_states_code',$state_code,$key);

		if($state_code != NULL  && $state_code != '-1')
			$state_code  		= "'".str_replace(",","','",$state_code)."'";

		$pw_order_status=$this->pw_get_form_element_permission('pw_orders_status',$pw_order_status,$key);

		if($pw_order_status != NULL  && $pw_order_status != '-1')
			$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";
		///////////////////////////

		$pw_variations_formated='';

		if(strlen($pw_max_amount)<=0) $_REQUEST['max_amount']	= 	$pw_max_amount = '-1';
		if(strlen($pw_min_amount)<=0) $_REQUEST['min_amount']	=	$pw_min_amount = '-1';

		if($pw_max_amount != '-1' || $pw_min_amount != '-1'){
			if($pw_order_meta_key == '-1'){
				$_REQUEST['order_meta_key']	= "_order_total";
			}
		}

		$last_days_orders 		= "0";
		if(is_array($pw_id_order_status)){		$pw_id_order_status 	= implode(",", $pw_id_order_status);}
		if(is_array($category_id)){ 		$category_id		= implode(",", $category_id);}

		/////ADDED IN VER4.0
		//BRANDS ADDONS
		if(is_array($brand_id)){ 		$brand_id		= implode(",", $brand_id);}

		if(!$pw_from_date){	$pw_from_date = date_i18n('Y-m-d');}
		if(!$pw_to_date){
			$last_days_orders 		= apply_filters($page.'_back_day', $last_days_orders);//-1,-2,-3,-4,-5
			$pw_to_date = date('Y-m-d', strtotime($last_days_orders.' day', strtotime(date_i18n("Y-m-d"))));}

		$pw_sort_by 			= $this->pw_get_woo_requests('sort_by','order_id',true);
		$pw_order_by 			= $this->pw_get_woo_requests('order_by','DESC',true);


		//pw_first_name_text
		$pw_txt_first_name_cols='';
		$pw_txt_first_name_join = '';
		$pw_txt_first_name_condition_1 = '';
		$pw_txt_first_name_condition_2 = '';

		//pw_email_text
		$pw_txt_email_cols ='';
		$pw_txt_email_join = '';
		$pw_txt_email_condition_1 = '';
		$pw_txt_email_condition_2 = '';

		//SORT BY
		$pw_sort_by_cols ='';

		//CATEGORY
		$category_id_join ='';
		$category_id_condition = '';

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id_join ='';
		$brand_id_condition = '';

		//ORDER ID
		$pw_id_order_status_join ='';
		$pw_id_order_status_condition = '';

		//COUNTRY
		$pw_country_code_join = '';
		$pw_country_code_condition_1 = '';
		$pw_country_code_condition_2 = '';

		//STATE
		$state_code_join= '';
		$state_code_condition_1 = '';
		$state_code_condition_2 = '';

		//PAYMENT METHOD
		$pw_payment_method_join= '';
		$pw_payment_method_condition_1 = '';
		$pw_payment_method_condition_2 = '';

		//POSTCODE
		$pw_billing_post_code_join = '';
		$pw_billing_post_code_condition= '';

		//COUPON USED
		$pw_coupon_used_join = '';
		$pw_coupon_used_condition = '';

		//VARIATION ID
		$pw_variation_id_join = '';
		$pw_variation_id_condition = '';

		////ADDED IN V4.0
		//VARIATION
		$pw_variation_item_meta_key_join='';
		$sql_variation_join='';
		$pw_show_variation_join='';
		$pw_variation_item_meta_key_condition='';
		$sql_variation_condition='';

		//VARIATION ONLY
		$pw_variation_only_join = '';
		$pw_variation_only_condition = '';

		//VARIATION FORMAT
		$pw_variations_formated_join = '';
		$pw_variations_formated_condition = '';

		//ORDER META KEY
		$pw_order_meta_key_join = '';
		$pw_order_meta_key_condition = '';

		//COUPON CODES
		$pw_coupon_codes_join = '';
		$pw_coupon_codes_condition = '';

		//COUPON CODE
		$pw_coupon_code_condition = '';

		//DATA CONDITION
		$date_condition = '';

		//ORDER ID
		$order_id_condition = '';

		//PAID CUSTOMER
		$pw_paid_customer_condition = '';

		//PUBLISH ORDER
		$pw_publish_order_condition_1 = '';
		$pw_publish_order_condition_2 = '';

		//ORDER ITEM NAME
		$pw_order_item_name_condition = '';

		//txt PRODUCT
		$txtProduct_condition = '';

		//PRODUCT ID
		$pw_product_id_condition = '';

		//CATEGORY ID
		$category_id_condition = '';

		//ORDER STATUS ID
		$pw_id_order_status_condition = '';

		//ORDER STATUS
		$pw_order_status_condition = '';

		//HIDE ORDER STATUS
		$pw_hide_os_condition = '';

		////ADDED IN VER4.0
		/// COST OF GOOD
		$pw_show_cog_cols='';
		$pw_show_cog_join='';
		$pw_show_cog_condition='';

		$sql_columns .= "
        billing_country.meta_value as billing_country,
        DATE_FORMAT(pw_posts.post_date,'%m/%d/%Y') 													AS order_date,
		pw_woocommerce_order_items.order_id 															AS order_id,					
		pw_woocommerce_order_items.order_item_name 													AS product_name,					
		pw_woocommerce_order_items.order_item_id														AS order_item_id,
		woocommerce_order_itemmeta.meta_value 														AS woocommerce_order_itemmeta_meta_value,					
		(pw_woocommerce_order_itemmeta2.meta_value/pw_woocommerce_order_itemmeta3.meta_value) 			AS sold_rate,
		(pw_woocommerce_order_itemmeta4.meta_value/pw_woocommerce_order_itemmeta3.meta_value) 			AS product_rate,
		(pw_woocommerce_order_itemmeta4.meta_value) 													AS item_amount,
		(pw_woocommerce_order_itemmeta2.meta_value) 													AS item_net_amount,
		(pw_woocommerce_order_itemmeta4.meta_value - pw_woocommerce_order_itemmeta2.meta_value) 			AS item_discount,					
		pw_woocommerce_order_itemmeta2.meta_value 														AS total_price,
		count(pw_woocommerce_order_items.order_item_id) 												AS product_quentity,
		woocommerce_order_itemmeta.meta_value 														AS product_id
		
		,pw_woocommerce_order_itemmeta3.meta_value 													AS 'product_quantity'					
		,pw_posts.post_status 																			AS post_status
		,pw_posts.post_status 																			AS order_status
		
		";

		$sql_joins ="{$wpdb->prefix}woocommerce_order_items as pw_woocommerce_order_items 
		
		LEFT JOIN  {$wpdb->prefix}posts as pw_posts ON pw_posts.ID=pw_woocommerce_order_items.order_id				
		
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta 	ON woocommerce_order_itemmeta.order_item_id		=	pw_woocommerce_order_items.order_item_id";

		$sql_joins.="
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta2 	ON pw_woocommerce_order_itemmeta2.order_item_id	=	pw_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta3 	ON pw_woocommerce_order_itemmeta3.order_item_id	=	pw_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta4 	ON pw_woocommerce_order_itemmeta4.order_item_id	=	pw_woocommerce_order_items.order_item_id AND pw_woocommerce_order_itemmeta4.meta_key='_line_subtotal'
        LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id = pw_posts.ID
        ";

		$post_type_condition="pw_posts.post_type = 'shop_order' AND billing_country.meta_key	= '_billing_country'";

		$other_condition_1 = "
		AND woocommerce_order_itemmeta.meta_key = '_product_id' ";

		$other_condition_1 .= "
		AND pw_woocommerce_order_itemmeta2.meta_key='_line_total'
		AND pw_woocommerce_order_itemmeta3.meta_key='_qty' ";


		if ($pw_from_date != NULL &&  $pw_to_date !=NULL){
			$date_condition = " AND DATE(pw_posts.post_date) BETWEEN '".$pw_from_date."' AND '". $pw_to_date ."'";
		}

		if($pw_order_status  && $pw_order_status != '-1' and $pw_order_status != "'-1'")
			$pw_order_status_condition = " AND pw_posts.post_status IN (".$pw_order_status.")";

		if($pw_hide_os  && $pw_hide_os != '-1' and $pw_hide_os != "'-1'")
			$pw_hide_os_condition = " AND pw_posts.post_status NOT IN ('".$pw_hide_os."')";


		$sql ="SELECT $sql_columns FROM $sql_joins";

		$sql .="$category_id_join $brand_id_join $pw_id_order_status_join $pw_txt_email_join $pw_txt_first_name_join
				$pw_country_code_join $state_code_join $pw_payment_method_join $pw_billing_post_code_join
				$pw_coupon_used_join $pw_variation_id_join $pw_variation_only_join $pw_variations_formated_join
				$pw_order_meta_key_join $pw_coupon_codes_join $pw_variation_item_meta_key_join $pw_show_cog_join ";

		$sql .= " Where $post_type_condition $pw_txt_email_condition_1 $pw_txt_first_name_condition_1
						$other_condition_1 $pw_country_code_condition_1 $state_code_condition_1
						$pw_billing_post_code_condition $pw_payment_method_condition_1 $date_condition
						$order_id_condition $pw_txt_email_condition_2 $pw_paid_customer_condition
						$pw_txt_first_name_condition_2 $pw_publish_order_condition_1 $pw_publish_order_condition_2
						$pw_country_code_condition_2 $state_code_condition_2 $pw_payment_method_condition_2
						$pw_order_meta_key_condition $pw_order_item_name_condition $txtProduct_condition
						$pw_product_id_condition $category_id_condition $brand_id_condition $pw_id_order_status_condition 
						$pw_coupon_used_condition $pw_coupon_code_condition $pw_coupon_codes_condition $pw_variation_item_meta_key_condition
						$pw_variation_id_condition $pw_variation_only_condition $pw_variations_formated_condition $pw_show_cog_condition
						$pw_order_status_condition $pw_hide_os_condition ";

		$sql_group_by = " GROUP BY pw_woocommerce_order_items.order_item_id ";
		$sql_order_by = " ORDER BY {$pw_sort_by} {$pw_order_by}";

		$sql .=$sql_group_by.$sql_order_by;

		//echo $sql;

	}
    elseif($file_used=="data_table"){

        $output.= '
        <div class="pw-cols col-xs-12 col-md-4">
            <div class="int-awr-box">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">                    
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/5.jpg" class="charts" >
                    </div> 
                </div>
            </div>
        </div>
        
        <div class="pw-cols col-xs-12 col-md-3">
            <div class="int-awr-box">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">                    
                        
                            <div class="pw-info">
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">$370.63</div>
                                    <div class="pw-xs-font pw-val">Avg LTV</div>
                                </div>
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">$3,332.25 • 18</div>
                                    <div class="pw-xs-font pw-val">Top 20% Customers</div>
                                </div>
                            </div>    
                            
                            <div class="pw-info">
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">$109.60</div>
                                    <div class="pw-xs-font pw-val">Avg Value</div>
                                </div>
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">1.28</div>
                                    <div class="pw-xs-font pw-val">Avg Orders</div>
                                </div>
                            </div>    
                            
                            <div class="pw-info">
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">0</div>
                                    <div class="pw-xs-font pw-val">Acquired / Day</div>
                                </div>
                                <div class="pw-cols col-xs-12 col-md-6 pw-center-align">
                                    <div class="pw-md-font pw-blue">3 • 5.17%</div>
                                    <div class="pw-xs-font pw-val">Refunded</div>
                                </div>
                            </div>    
                        
                    </div> 
                </div>
            </div>
        </div>
        <div class="pw-cols col-xs-12 col-md-5">
            <div class="int-awr-box">
                <div class="awr-title">
                    <h3>
                        <i class="fa fa-money"></i>RFM Analysis</h3>
                    <div class="awr-title-icons">
                        <div class="awr-title-icon awr-add-fav-icon" data-smenu="all_orders"><i class="fa  fa-info "></i></div>
                        <div class="awr-title-icon awr-toggle-icon"><i class="fa fa-arrow-up"></i></div>
                        <div class="awr-title-icon awr-setting-icon" style="display: none;"><i class="fa fa-cog"></i></div>
                        <div class="awr-title-icon awr-close-icon" style="display: none;"><i class="fa fa-times"></i></div>
                    </div>
                </div>
                
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">                    
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/6.jpg" class="charts" >
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <h3 class="pw-out-title">Customer Cards</h3>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-blue">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            
            
            
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-blue">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-blue">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-yellow">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-yellow">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-2">
                <div class="pw-customer-cards-cnt pw-customer-green">
                <div class="pw-customer-card-thumb pw-center-align">
                    <span class="pw-customer-link pw-val pw-md-font"><i class="fa fa-external-link-square"></i></span>
                    <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/avatar.jpg">
                </div>
                
                <div class="pw-customer-detail pw-center-align">
                    <div class="pw-md-font">william lambert</div>
                    <div class="pw-val pw-sm-font pw-customer-email">william.lambert@demo.com</div>
                    <div class="pw-xs-font pw-map-cnt"><i class="fa fa-map-marker"></i>Montreal</div>
                    
                    <div class="pw-customer-product-imgs">
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-1.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-2.jpg" >
                        <img src="'. __PW_REPORT_WCREPORT_URL__.'/assets/images/pr-3.jpg" >
                    </div>
                    
                    <div class="pw-xs-font pwl-lbl">Revenue</div>
                    <div class="pw-md-font pw-green">$446.00</div>
                </div>
                
            </div>
            </div>
        </div>
        
        
       
        
        
        
        ';
	    $order_items=$this->results;
	    $categories = array();
	    $order_meta = array();
	    if(count($order_items)>0)
		    foreach ( $order_items as $key => $order_item ) {

			    $order_id								= $order_item->order_id;
			    $order_items[$key]->billing_first_name  = '';//Default, some time it missing
			    $order_items[$key]->billing_last_name  	= '';//Default, some time it missing
			    $order_items[$key]->billing_email  		= '';//Default, some time it missing

			    if(!isset($order_meta[$order_id])){
				    $order_meta[$order_id]					= $this->pw_get_full_post_meta($order_id);
			    }

			    //	die(print_r($order_meta[$order_id]));

			    foreach($order_meta[$order_id] as $k => $v){
				    $order_items[$key]->$k			= $v;
			    }


			    $order_items[$key]->order_total			= isset($order_item->order_total)		? $order_item->order_total 		: 0;
			    $order_items[$key]->order_shipping		= isset($order_item->order_shipping)	? $order_item->order_shipping 	: 0;


			    $order_items[$key]->cart_discount		= isset($order_item->cart_discount)		? $order_item->cart_discount 	: 0;
			    $order_items[$key]->order_discount		= isset($order_item->order_discount)	? $order_item->order_discount 	: 0;
			    $order_items[$key]->total_discount 		= isset($order_item->total_discount)	? $order_item->total_discount 	: ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


			    $order_items[$key]->order_tax 			= isset($order_item->order_tax)			? $order_item->order_tax : 0;
			    $order_items[$key]->order_shipping_tax 	= isset($order_item->order_shipping_tax)? $order_item->order_shipping_tax : 0;
			    $order_items[$key]->total_tax 			= isset($order_item->total_tax)			? $order_item->total_tax 	: ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

			    $transaction_id = "ransaction ID";
			    $order_items[$key]->transaction_id		= isset($order_item->$transaction_id) 	? $order_item->$transaction_id		: (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
			    $order_items[$key]->gross_amount 		= ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping +  $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax );


			    $order_items[$key]->billing_first_name	= isset($order_item->billing_first_name)? $order_item->billing_first_name 	: '';
			    $order_items[$key]->billing_last_name	= isset($order_item->billing_last_name)	? $order_item->billing_last_name 	: '';
			    $order_items[$key]->billing_name		= $order_items[$key]->billing_first_name.' '.$order_items[$key]->billing_last_name;
		    }



        //print_r($order_items);



	}elseif($file_used=="search_form"){
		global $pw_rpt_main_class;
		$this->pw_get_date_form_to();
		$pw_from_date=$pw_rpt_main_class->pw_from_date_dashboard;
		$pw_to_date=$pw_rpt_main_class->pw_to_date_dashboard;
	?>
		<form class='alldetails search_form_report' action='' method='post'>
            <input type='hidden' name='action' value='submit-form' />


            <input type='hidden' name='action' value='submit-form' />
            <input type='hidden' name="pw_from_date" id="pwr_from_date_dashboard" value="<?php echo $pw_from_date;?>"/>
            <input type='hidden' name="pw_to_date" id="pwr_to_date_dashboard"  value="<?php echo $pw_to_date;?>"/>


            <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo __('Search',__PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            <div id="dashboard-report-range" class="pull-right tooltips  btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>
            </div>



            <div class="col-md-12">
                
                    <?php
                    	$pw_hide_os=$this->otder_status_hide;
						$pw_publish_order='no';
						$data_format=$this->pw_get_woo_requests_links('date_format',get_option('date_format'),true);
					?>
                    <input type="hidden" name="list_parent_category" value="">
                    <input type="hidden" name="pw_category_id" value="-1">
                    <input type="hidden" name="group_by_parent_cat" value="0">
                    
                	<input type="hidden" name="pw_hide_os" id="pw_hide_os" value="<?php echo $pw_hide_os;?>" />
                    
                    <input type="hidden" name="date_format" id="date_format" value="<?php echo $data_format;?>" />
                
                	<input type="hidden" name="table_names" value="<?php echo $table_name;?>"/>
                    <div class="fetch_form_loading search-form-loading"></div>

            </div>  
                                
        </form>
    <?php
	}
?>