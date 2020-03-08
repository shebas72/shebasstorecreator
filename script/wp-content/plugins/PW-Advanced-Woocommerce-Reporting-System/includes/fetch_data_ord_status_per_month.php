<?php
	
	if($file_used=="sql_table")
	{
		//GET POSTED PARAMETERS
		$start				= 0;
		$pw_from_date		  = $this->pw_get_woo_requests('pw_from_date',NULL,true);
		$pw_to_date			= $this->pw_get_woo_requests('pw_to_date',NULL,true);
		
		$pw_from_date=substr($pw_from_date,0,strlen($pw_from_date)-3);
		$pw_to_date=substr($pw_to_date,0,strlen($pw_to_date)-3);

		$pw_product_id			= $this->pw_get_woo_requests('pw_product_id',"-1",true);
		$category_id 		= $this->pw_get_woo_requests('pw_category_id','-1',true);
		$pw_cat_prod_id_string = $this->pw_get_woo_pli_category($category_id,$pw_product_id);
		$category_id 				= "-1";
		
		$pw_sort_by 			= $this->pw_get_woo_requests('sort_by','item_name',true);
		$pw_order_by 			= $this->pw_get_woo_requests('order_by','ASC',true);
		
		$pw_id_order_status 	= $this->pw_get_woo_requests('pw_id_order_status',NULL,true);
		$pw_order_status		= $this->pw_get_woo_requests('pw_orders_status','-1',true);
		//$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";
		
		///////////HIDDEN FIELDS////////////
		$pw_hide_os		= $this->pw_get_woo_requests('pw_hide_os','-1',true);
		$pw_publish_order='no';
		$data_format=$this->pw_get_woo_requests_links('date_format',get_option('date_format'),true);
		
		/////////////////////////
		//APPLY PERMISSION TERMS
		$key='order_status_per_month';

		$pw_order_status=$this->pw_get_form_element_permission('pw_orders_status',$pw_order_status,$key);

		if($pw_order_status != NULL  && $pw_order_status != '-1')
			$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";
		
		///////////////////////////
		
		//////////////////////
		
		//ORDER Status ID
		$pw_id_order_status_condition='';
		//START DATE CONDITION
		$pw_from_date_condition='';
		//ORDER STATUS
		$pw_order_status_condition='';
		//HIDE ORDER STATUS
		$pw_hide_os_condition='';

		$sql_columns = "";
		
		$sql_columns = " 
			shop_order.post_status 					as id
			,shop_order.post_status					as group_column
			,shop_order.post_status				 	as status_name	
			,shop_order.post_status				 	as item_name
			,shop_order.post_status				 	as order_status";
		
		$sql_columns .= " 					
			,SUM(pw_postmeta2.meta_value)				as total
			,COUNT(shop_order.ID) 					as quantity
			,MONTH(shop_order.post_date) 			as month_number
			
			,MONTH(shop_order.post_date) 					as month_number
			,DATE_FORMAT(shop_order.post_date, '%Y-%m')		as month_key";
								
			$sql_joins= "{$wpdb->prefix}posts as shop_order 
			LEFT JOIN	{$wpdb->prefix}postmeta as pw_postmeta2 on pw_postmeta2.post_id = shop_order.ID
			
			";
				
		
		$sql_condition = "shop_order.post_type	= 'shop_order' AND	pw_postmeta2.meta_key 		= '_order_total'";
		
		if($pw_id_order_status != NULL  && $pw_id_order_status != '-1'){
			$pw_id_order_status_condition  = "						
			AND terms2.term_id IN (".$pw_id_order_status .")";
		}
	
		if ($pw_from_date != NULL &&  $pw_to_date !=NULL)
			$pw_from_date_condition = " AND DATE_FORMAT(shop_order.post_date, '%Y-%m') BETWEEN '".$pw_from_date."' AND '". $pw_to_date ."'";
		
		if($pw_order_status  && $pw_order_status != '-1' and $pw_order_status != "'-1'")
			$pw_order_status_condition = " AND shop_order.post_status IN (".$pw_order_status.")";
			
		if($pw_hide_os  && $pw_hide_os != '-1' and $pw_hide_os != "'-1'")
			$pw_hide_os_condition = " AND shop_order.post_status NOT IN ('".$pw_hide_os."')";
		

		$sql_group_by = " GROUP BY group_column";
		
		$sql_order_by="ORDER BY {$pw_sort_by} {$pw_order_by}";
		
		$sql = "SELECT $sql_columns FROM $sql_joins WHERE $sql_condition
			$pw_id_order_status_condition $pw_from_date_condition
			$pw_order_status_condition $pw_hide_os_condition 
			$sql_group_by $sql_order_by
		";
		
		//echo $sql;
		
		///////////////////
		//MONTHS
		
		$array_index=2;
		$this->table_cols =$this->table_columns($table_name);
		
		$pw_from_date		  = $this->pw_get_woo_requests('pw_from_date',NULL,true);
		$pw_to_date			= $this->pw_get_woo_requests('pw_to_date',NULL,true);

		$time1  = strtotime($pw_from_date); 
	   	$time2  = strtotime($pw_to_date); 
	   	$my     = date('mY', $time2); 
		$this->month_start=date('m', $time1);
		$months=array();	
		
		$month_count=0;
		
		$data_month=[];
		
		if($my!=date('mY', $time1))
		{	
			$year=date('Y', $time1);
			$months = array(array('lable'=>$this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year,'status'=>'currency')); 
			$month_count=1;
			$data_month[]=$year."-".date('m', $time1);
				
			while($time1 < $time2) { 
				
				$time1 = strtotime(date('Y-m-d', $time1).' +1 month'); 
			  
				if(date('mY', $time1) != $my && ($time1 < $time2)) 
				{
					if($year!=date('Y', $time1))
					{
						$year=date('Y', $time1);
						$label = $this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year; 
					}else
						$label = $this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1)); 
				
					$month_count++;
					$months[] = array('lable'=>$label,'status'=>'currency');
					$data_month[]=$year."-".date('m', $time1);
				}
			} 
		
			if($year!=date('Y', $time2)){
				$year=date('Y', $time2);
				$label = $this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time2).'_translate',date('M', $time2))."-".$year; 
			}else
				$label = $this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time2).'_translate',date('M', $time2)); 
			$months[] = array('lable'=>$label,'status'=>'currency');	
			$data_month[]=$year."-".date('m', $time2);
		}else
		{
			$year=date('Y', $time1);
			$months = array(array('lable'=>$this->pw_translate_function(__PW_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year,'status'=>'currency')); 
			$data_month[]=$year."-".date('m', $time1);
			$month_count=1;
		}	
	  	//print_r( $months); 
		

		$value=array(array('lable'=>__('Total',__PW_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'));
		$value=array_merge($months,$value);			
		
		array_splice($this->table_cols, $array_index, count($this->table_cols), $value);
		
		//print_r($this->table_cols);


		$this->month_count=$month_count;
		$this->data_month=$data_month;
		
	}elseif($file_used=="data_table"){
		
		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){
			$datatable_value.=("<tr>");
				
				//Status Name
				$pw_table_value = isset($items->status_name) ? $items->status_name : '';
					
				if($pw_table_value=='wc-completed')
					$pw_table_value = '<span class="awr-order-status awr-order-status-'.sanitize_title($pw_table_value).'" >'.ucwords(__($pw_table_value, __PW_REPORT_WCREPORT_TEXTDOMAIN__)).'</span>';
				else if($pw_table_value=='wc-refunded')
					$pw_table_value = '<span class="awr-order-status awr-order-status-'.sanitize_title($pw_table_value).'" >'.ucwords(__($pw_table_value, __PW_REPORT_WCREPORT_TEXTDOMAIN__)).'</span>';
				else if($pw_table_value=='auto-draft')
					$pw_table_value = '';	
				else
					$pw_table_value = '<span class="awr-order-status awr-order-status-'.sanitize_title($pw_table_value).'" >'.ucwords(__($pw_table_value, __PW_REPORT_WCREPORT_TEXTDOMAIN__)).'</span>';		
					
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= str_replace("Wc-","",$pw_table_value);
				$datatable_value.=("</td>");
				
				$type = 'limit_row';$items_only = true; $id = $items->id;
				$pw_from_date		  = $this->pw_get_woo_requests('pw_from_date',NULL,true);
				$pw_to_date			= $this->pw_get_woo_requests('pw_to_date',NULL,true);
				$pw_order_status		= $this->pw_get_woo_requests('pw_orders_status','-1',true);
				$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";
				$pw_from_date=substr($pw_from_date,0,strlen($pw_from_date)-3);
				$pw_to_date=substr($pw_to_date,0,strlen($pw_to_date)-3);
				
				$params=array(
					"pw_from_date"=>$pw_from_date,
					"pw_to_date"=>$pw_to_date,
					"order_status"=>$pw_order_status,
					"pw_hide_os"=>'"trash"'
				);
				$items_product=$this->pw_get_woo_items_status($type , $items_only, $id,$params);
				
				//print_r($items_product);
								
				$month_arr=[];
				foreach($items_product as $item_product){
					$month_arr[$item_product->month_key]['total']=$item_product->total;
					$month_arr[$item_product->month_key]['qty']=$item_product->quantity;
				}
				
				$j=1;
				$total=0;
				$qty=0;
				
								
				foreach($this->data_month as $month_name){
					
					$pw_table_value=$this->price(0);
					if(isset($month_arr[$month_name]['total'])){
						$pw_table_value=$this->price($month_arr[$month_name]['total']);
						$total+=$month_arr[$month_name]['total'];
						$qty+=$month_arr[$month_name]['qty'];
					}
					
					
					$display_class='';
					if($this->table_cols[$j++]['status']=='hide') $display_class='display:none';
					$datatable_value.=("<td style='".$display_class."'>");
						$datatable_value.= $pw_table_value;
					$datatable_value.=("</td>");
				}	
			
				$display_class='';
				if($this->table_cols[$j]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->price($total) .' #'.$qty;
				$datatable_value.=("</td>");
	
				
				
			$datatable_value.=("</tr>");
		}
	}elseif($file_used=="search_form"){
			$now_date= date("Y-m-d");
			$cur_year=substr($now_date,0,4);
			$pw_from_date= $cur_year."-01-01";
			$pw_to_date= $cur_year."-12-31";
		?>
		<form class='alldetails search_form_report' action='' method='post'>
			<input type='hidden' name='action' value='submit-form' />
			<div class="row">
				
				<div class="col-md-6">
					<div>
						<?php _e('From Date',__PW_REPORT_WCREPORT_TEXTDOMAIN__);?>
					</div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
					<input name="pw_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick" value="<?php echo $pw_from_date;?>"/>                
				</div>
				<div class="col-md-6">
					<div class="awr-form-title">
						<?php _e('To Date',__PW_REPORT_WCREPORT_TEXTDOMAIN__);?>
					</div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
					<input name="pw_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"  value="<?php echo $pw_to_date;?>"/>
				</div>
				<?php
					$col_style='';
					$permission_value=$this->get_form_element_value_permission('pw_orders_status');
					if($this->get_form_element_permission('pw_orders_status') ||  $permission_value!=''){
						if(!$this->get_form_element_permission('pw_orders_status') &&  $permission_value!='')
							$col_style='display:none';
						
				?>
                <div class="col-md-6" style=" <?php echo $col_style;?>">
                    <div class="awr-form-title">
                        <?php _e('Status',__PW_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-check"></i></span>
					<?php
                        $pw_order_status=$this->pw_get_woo_orders_statuses();

                        ////ADDED IN VER4.0
                        /// APPLY DEFAULT STATUS AT FIRST
                        $shop_status_selected='';
                        if($this->pw_shop_status)
                            $shop_status_selected=explode(",",$this->pw_shop_status);

                        $option='';
                        foreach($pw_order_status as $key => $value){
							$selected='';
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($key,$permission_value))
								continue;
							
							/*if(!$this->get_form_element_permission('pw_orders_status') &&  $permission_value!='')
								$selected="selected";*/

	                        ////ADDED IN VER4.0
	                        /// APPLY DEFAULT STATUS AT FIRST
	                        if(is_array($shop_status_selected) && in_array($key,$shop_status_selected))
		                        $selected="selected";

	                        $option.="<option value='".$key."' $selected >".$value."</option>";
                        }
                    ?>
                
                    <select name="pw_orders_status[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('pw_orders_status') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
							{
						?>
                        <option value="-1"><?php _e('Select All',__PW_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
							}
						?>
                        <?php
                            echo $option;
                        ?>
                    </select>  
                    <input type="hidden" name="pw_id_order_status[]" id="pw_id_order_status" value="-1">
                </div>	
                
                <?php
					}
				?>
                
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
                    
                	<input type="hidden" name="table_names" value="<?php echo $table_name;?>"/>
                    <div class="fetch_form_loading search-form-loading"></div>	
                    <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo __('Search',__PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
					<button type="button" value="Reset" class="button-secondary form_reset_btn"><i class="fa fa-reply"></i><span><?php echo __('Reset Form',__PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            </div>  
                                
        </form>
    <?php
	}
	
?>