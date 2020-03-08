<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Contact';
        $data['main_content'] = $this->load->view('admin/contact/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
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
                redirect(base_url('admin/contact/all_contact_list'));
            
            
            

        }
    }

    public function all_contact_list()
    {
        $data['contacts'] = $this->common_model->get_all_contact();
        $data['main_content'] = $this->load->view('admin/contact/contacts', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
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

            $this->common_model->edit_option($data, $id, 'code_contact', 'contactid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/contact/all_contact_list'));

        }

        $data['contact'] = $this->common_model->get_single_contact_info($id);
        $data['main_content'] = $this->load->view('admin/contact/edit_contact', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active contact
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'contact');
        $this->session->set_flashdata('msg', 'Contact active Successfully');
        redirect(base_url('admin/contact/all_contact_list'));
    }

    //-- deactive contact
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'contact');
        $this->session->set_flashdata('msg', 'Contact deactive Successfully');
        redirect(base_url('admin/contact/all_contact_list'));
    }

    //-- delete contact
    public function delete($id)
    {
        $this->common_model->delete($id,'code_contact','contactid'); 
        $this->session->set_flashdata('msg', 'Contact deleted Successfully');
        redirect(base_url('admin/contact/all_contact_list'));
    }


}