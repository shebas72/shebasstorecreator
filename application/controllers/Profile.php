<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct(){
        parent::__construct();
       check_login_user();
       $this->load->model('common_model');
       $this->load->model('login_model');
       $this->load->library('session');
        $this->load->library('upload');
        $this->load->database();
    }


    public function index()
    {
        $data = array();
        $id = $this->session->userdata('id');
        $data['user'] = $this->common_model->get_single_user_info($id);
        $data['page_title'] = 'Profile';
        $data['countryName'] = $this->common_model->get_countryName_by_id($data['user']->country);
        $data['country'] = $this->common_model->select('country');
        $data['main_content'] = $this->load->view('admin/user/profile', $data, TRUE);
        $this->load->view('profile', $data);
    }


    public function update()
    {
        check_login_user();
        if (empty($_POST['password'])) {
            $this->load->library('form_validation'); 
            $this->form_validation->set_error_delimiters('', '');       
            $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[5]|max_length[12]');
            //$this->form_validation->set_rules('email', 'Email', 'required');
            $data = array();
            if ($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    //'email' => $_POST['email'],
                    'country'  => $this->input->post('country'),
                    'mobile'   => $this->input->post('mobile')
                );

                $data = $this->security->xss_clean($data);
                $this->common_model->update($data, $_POST['userid'], 'user');
                $this->session->set_flashdata('msg', 'User updated Successfully');
                redirect(base_url('profile'));
            } else {
                $this->session->set_flashdata('error_msg', validation_errors());
                redirect(base_url('profile'));
            }
        } else {
            $this->load->library('form_validation'); 
            $this->form_validation->set_error_delimiters('', '');       
            $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('passwordr', 'Password Confirmation', 'required|matches[password]');
            //$this->form_validation->set_rules('email', 'Email', 'required');
            $data = array();
            if ($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    //'email' => $_POST['email'],
                    'password' => md5($_POST['password']),
                    'country'  => $this->input->post('country'),
                    'mobile'   => $this->input->post('mobile')
                );

                $data = $this->security->xss_clean($data);
                $this->common_model->update($data, $_POST['userid'], 'user');
                $this->session->set_flashdata('msg', 'User updated Successfully');
                redirect(base_url('profile'));
            } else {
                $this->session->set_flashdata('error_msg', validation_errors());
                redirect(base_url('profile'));
            }
        }
    }

    public function avatar()
    {
        check_login_user();

        $data = array();
        if(!empty($_FILES['avatar']['name'])){

            $imageData = $this->common_model->upload_image('92000','avatar');
            $data['avatar'] = $imageData['images'];
            $data = $this->security->xss_clean($data);

            $this->common_model->update($data, $_POST['userid'], 'user');
            $this->session->set_flashdata('msg', 'User updated Successfully');
            redirect(base_url('profile'));
        } else {
            $this->session->set_flashdata('error_msg', "Sorry error! Error in uploading image.");
            redirect(base_url('profile'));
        }
    }

}