<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller {

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
        $data['page_title'] = 'Newsletter';
        $data['main_content'] = $this->load->view('admin/newsletter/add_newsletter', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'newsletterevent' => $_POST['newsletterevent'],
                'newslettersubject' => $_POST['newslettersubject'],
                'newslettermail' => $_POST['newslettermail']
            );
            
            $data = $this->security->xss_clean($data);

            $newsletter_id = $this->common_model->insert($data, 'code_newsletter');
            $this->session->set_flashdata('msg', 'Newsletter added Successfully');
            redirect(base_url('admin/newsletter/newsletter_list'));
            
            
            

        }
    }
    public function newsletter_list()
    {
        $data['newsletters'] = $this->common_model->get_all_newsletter();
        $data['main_content'] = $this->load->view('admin/newsletter/newsletter', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {
            $data['newsletter'] = $this->common_model->get_single_newsletter_info($id);

            $data = array(
                'newsletterevent' => $_POST['newsletterevent'],
                'newslettersubject' => $_POST['newslettersubject'],
                'newslettermail' => $_POST['newslettermail']
            );

            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_newsletter', 'newsletterid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/newsletter/newsletter_list'));

        }

        $data['newsletter'] = $this->common_model->get_single_newsletter_info($id);
        $data['main_content'] = $this->load->view('admin/newsletter/edit_newsletter', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    //-- delete newsletter
    public function delete($id)
    {
        $this->common_model->delete($id,'code_newsletter','newsletterid'); 
        $this->session->set_flashdata('msg', 'Newsletter deleted Successfully');
        redirect(base_url('admin/newsletter/newsletter_list'));
    }


}