<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriber extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Subscriber';
        $data['main_content'] = $this->load->view('admin/subscriber/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'subscriberemail' => $_POST['subscriberemail'],
                'subscribertitme' => $_POST['subscribertitme']
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
                $subscriber_id = $this->common_model->insert($data, 'code_subscriber')
                ;
                $this->session->set_flashdata('msg', 'Subscriber added Successfully');
                redirect(base_url('admin/subscriber/all_subscriber_list'));
            
            
            

        }
    }

    public function all_subscriber_list()
    {
        $data['subscribers'] = $this->common_model->get_all_subscriber();
        $data['main_content'] = $this->load->view('admin/subscriber/subscribers', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {

            $data = array(
                'subscriberemail' => $_POST['subscriberemail'],
                'subscribertitme' => $_POST['subscribertitme']
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_subscriber', 'subscriberid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/subscriber/all_subscriber_list'));

        }

        $data['subscriber'] = $this->common_model->get_single_subscriber_info($id);
        $data['main_content'] = $this->load->view('admin/subscriber/edit_subscriber', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active subscriber
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'subscriber');
        $this->session->set_flashdata('msg', 'Subscriber active Successfully');
        redirect(base_url('admin/subscriber/all_subscriber_list'));
    }

    //-- deactive subscriber
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'subscriber');
        $this->session->set_flashdata('msg', 'Subscriber deactive Successfully');
        redirect(base_url('admin/subscriber/all_subscriber_list'));
    }

    //-- delete subscriber
    public function delete($id)
    {
        $this->common_model->delete($id,'code_subscriber','subscriberid'); 
        $this->session->set_flashdata('msg', 'Subscriber deleted Successfully');
        redirect(base_url('admin/subscriber/all_subscriber_list'));
    }


}