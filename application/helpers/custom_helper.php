<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	
	//-- check logged user
	if (!function_exists('check_login_user')) {
	    function check_login_user() {
	        $ci = get_instance();
	        if ($ci->session->userdata('is_login') != TRUE) {
	            $ci->session->sess_destroy();
	            redirect(base_url('login'));
	        }
	    }
	}
	if (!function_exists('check_if_user_member')) {
	    function check_if_user_member() {
			$ci = get_instance();
			$ci->db->select('*');
			$ci->db->from('user');
			$ci->db->where('id', $ci->session->userdata('id'));
			$query = $ci->db->get();

			$dbexpiry = $query->result_array()[0]['user_mem_expire'];
			$dbmembership = $query->result_array()[0]['user_membership'];
			if(empty($dbexpiry)) {
    			$ci->session->set_flashdata('msg', 'Please get membership first!');
	            redirect(base_url('pricing'));
			}
			if(empty($dbmembership)) {
    			$ci->session->set_flashdata('msg', 'Please get membership first!');
	            redirect(base_url('pricing'));
			}
			if($dbmembership == '1') {
    			$ci->session->set_flashdata('msgs', 'Trail package');
			}
			// return  $query->result_array(); 
	    }
	}
	if (!function_exists('check_login_user_admin')) {
	    function check_login_user_admin() {
	        $ci = get_instance();
	        if ($ci->session->userdata('is_login') != TRUE) {
	            $ci->session->sess_destroy();
	            redirect(base_url('login'));
	        }
	        if ($ci->session->userdata('is_login') == TRUE) {
		        if ($ci->session->userdata('role') != 'admin') {
		            redirect(base_url());
		        }
	        }
	    }
	}

	if (!function_exists('check_login_user_or_no')) {
	    function check_login_user_or_no() {
	        $ci = get_instance();
	        if ($ci->session->userdata('is_login') == TRUE) {
	        	if ($ci->session->userdata('role') == 'admin') {
		            redirect(base_url('admin/dashboard'));
	        	} else {
		            redirect(base_url());
	        	}
	        }
	    }
	}

	if (!function_exists('check_login_user_or_no_developer')) {
	    function check_login_user_or_no_developer() {
	        $ci = get_instance();
	        if ($ci->session->userdata('islogin') == TRUE) {
	        	if ($ci->session->userdata('role') == 'developer') {
		            redirect(base_url('developer/dashboard'));
	        	} 
	        }
	    }
	}

	if (!function_exists('check_login_user_no_developer')) {
	    function check_login_user_no_developer() {
	        $ci = get_instance();
	        if ($ci->session->userdata('islogin') == TRUE) {
	        	if ($ci->session->userdata('role') != 'developer') {
		            redirect(base_url('developer/login'));
	        	} 
	        }
	    }
	}

	if(!function_exists('check_power')){
	    function check_power($type){        
	        $ci = get_instance();
	        
	        $ci->load->model('common_model');
	        $option = $ci->common_model->check_power($type);        
	        
	        return $option;
	    }
    } 

	//-- current date time function
	if(!function_exists('current_datetime')){
	    function current_datetime(){        
	        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
	        $date_time = $dt->format('Y-m-d H:i:s');      
	        return $date_time;
	    }
	}

	//-- show current date & time with custom format
	if(!function_exists('my_date_show_time')){
	    function my_date_show_time($date){       
	        if($date != ''){
	            $date2 = date_create($date);
	            $date_new = date_format($date2,"d M Y h:i A");
	            return $date_new;
	        }else{
	            return '';
	        }
	    }
	}

	//-- show current date with custom format
	if(!function_exists('my_date_show')){
	    function my_date_show($date){       
	        
	        if($date != ''){
	            $date2 = date_create($date);
	            $date_new = date_format($date2,"d M Y");
	            return $date_new;
	        }else{
	            return '';
	        }
	    }
	}

	
	if (!function_exists('page_fetch')) {
		function page_fetch($id,$table){
			$ci = get_instance();
			
			$ci->db->select();
			$ci->db->from($table);
			$ci->db->where('pagestitle', $id);
			$query = $ci->db->get();
			return  $query->result_array(); 

		}
	}
  
	if (!function_exists('check_membership')) {
		function check_membership(){
			$ci = get_instance();
			$ci->db->select('*');
			$ci->db->from('user');
			$ci->db->where('id', $ci->session->userdata('id'));
			$query = $ci->db->get();

			$ciexpiry = $ci->session->userdata('expiremembership');
			$cimembership = $ci->session->userdata('membership');
			$dbexpiry = $query->result_array()[0]['user_mem_expire'];
			$dbmembership = $query->result_array()[0]['user_membership'];
			if($query->result_array()[0]['role'] != 'admin') {
				if(!empty($dbexpiry)) {
					if(strtotime($dbexpiry) < strtotime(date("m/d/Y"))) {
		                $ci->session->set_flashdata('error_msg', "Your package is expired.");
			            redirect(base_url('pricing'));
					} else { 
						// Expiry is left
					}
				}
			}
			// return  $query->result_array(); 

		}
	}
  