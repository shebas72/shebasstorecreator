<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showcase extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['showcase'] = $this->common_model->get_all_showcase();
        $data['showcasegroup'] = $this->common_model->get_all_showcase_group();
        $data['page_title'] = 'showcase';
        $this->load->view('showcase', $data);
    }


}