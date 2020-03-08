<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	

if (!function_exists('footer_menu')) {
	function footer_menu($id,$table){
		$ci = get_instance();
		
		$ci->db->select();
        $ci->db->from($table);
        $ci->db->where('menuinnerparentid', $id);
        $ci->db->where('menuineeractive', '1');
        $query = $ci->db->get();
        return  $query->result_array(); 

	}
}

if (!function_exists('footer_menu_options')) {
	function footer_menu_options($id,$table){
		$ci = get_instance();
		
		$ci->db->select();
        $ci->db->from($table);
        $ci->db->where('optionkey', $id);
        $query = $ci->db->get();
        return  $query->result_array(); 

	}
}
