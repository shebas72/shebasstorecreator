<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
       $this->load->library('upload');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Sale';
        $data['memberships'] = $this->common_model->get_all_membership();
        $data['main_content'] = $this->load->view('admin/sale/sale', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function view($id)
    {
        $data['sale'] = $this->common_model->get_single_sale_record($id);
        $data['main_content'] = $this->load->view('admin/sale/view', $data, TRUE);
        $this->load->view('admin/index', $data);

    }

}