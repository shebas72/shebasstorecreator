<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Features extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Feature';
        $data['feature'] = $this->common_model->get_single_custompages_info('feature');
        $this->load->view('features', $data);
    }


}