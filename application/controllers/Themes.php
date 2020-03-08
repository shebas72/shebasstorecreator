<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['themes'] = $this->common_model->get_all_theme();
        $data['themesgroup'] = $this->common_model->get_all_theme_group();
        $data['page_title'] = 'themes';
        $this->load->view('themes', $data);
    }


}