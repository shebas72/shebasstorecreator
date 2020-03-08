<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        if ($_POST) {
            $data = array(
                'contacttype' => $_POST['contacttype'],
                'contacttitle' => $_POST['contacttitle'],
                'contactname' => $_POST['contactname'],
                'contactemail' => $_POST['contactemail'],
                'contactcontent' => $_POST['contactcontent']
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
                $contact_id = $this->common_model->insert($data, 'code_contact')
                ;
                $this->session->set_flashdata('msg', 'Contact added Successfully');
                redirect(base_url('contact'));
        }

        $data = array();
        $data['page_title'] = 'Contact';
        $this->load->view('contact', $data);
    }


}