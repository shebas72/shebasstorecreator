<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pricing extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
	   $this->load->database();
    }


    public function index()
    {
        $data = array();
        $ci =& get_instance();
        
        $data['pricing'] = $this->common_model->get_all_packages();
        $data['userdata'] = $this->common_model->get_single_user_info($ci->session->userdata('id'));
        $data['page_title'] = 'pricing';
        $this->load->view('pricing', $data);
    }


    public function cancel()
    {
        $data = array();
        $data['pricing'] = $this->common_model->get_all_packages();
        $data['page_title'] = 'Cancel Package';
        $this->load->view('pricing', $data);
    }


}