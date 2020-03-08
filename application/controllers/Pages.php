<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Pages';
        $data['main_content'] = $this->load->view('Pages', $data, TRUE);
        $data['Pagess'] = $this->common_model->get_all_Pages();
        $this->load->view('Pages', $data);
    }

    //-- update users info
    public function id($id)
    {
        $data['pages'] = $this->common_model->get_single_custompages_info($id);
        $this->load->view('pages', $data);
        
    }



}